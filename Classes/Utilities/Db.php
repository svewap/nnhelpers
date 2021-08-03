<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Core\Utility\ClassNamingUtility;

/**
 * Zugriff auf die meist genutzten Datenbank-Operationen für Schreiben, Lesen, Löschen vereinfachen.
 */
class Db implements SingletonInterface {
	

	/**
	 * QueryBuilder für eine Tabelle holen
	 * ```
	 * $queryBuilder = \nn\t3::Db()->getQueryBuilder( 'fe_users' );
	 * ```
	 * Beispiel:
	 * ```
	 * $queryBuilder = \nn\t3::Db()->getQueryBuilder( 'fe_users' );
	 * $queryBuilder->select('name')->from( 'fe_users' );
	 * $queryBuilder->andWhere( $queryBuilder->expr()->eq( 'uid', $queryBuilder->createNamedParameter(12) ));
	 * $rows = $queryBuilder->execute()->fetchAll();
	 * ```
	 * @param string $table
	 * @return QueryBuilder
	 */
	public function getQueryBuilder( $table = '' ) {
		if (\nn\t3::t3Version() > 7) {
			$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable( $table );
			return $queryBuilder;
		}
	}

	/**
	 * Eine "rohe" Verbindung zur Datenbank holen.
	 * Nur in wirklichen Notfällen sinnvoll.
	 * ```
	 * $connection = \nn\t3::Db()->getConnection();
	 * $connection->fetchAll( 'SELECT * FROM tt_news WHERE 1;' );
	 * ```
	 * @return \TYPO3\CMS\Core\Database\Connection
	 */
	public function getConnection() {
		$connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
		$connectionName = array_shift($connectionPool->getConnectionNames());
		return $connectionPool->getConnectionByName( $connectionName );
	}

	/**
	 * Findet einen Eintrag anhand der UID.
	 * Funktioniert auch, wenn	Frontend noch nicht initialisiert wurden,
	 * z.B. während AuthentificationService läuft oder im Scheduler.
	 * ```
	 * \nn\t3::Db()->findByUid('fe_user', 12);
	 * \nn\t3::Db()->findByUid('fe_user', 12, true);
	 * ```
	 * @param int $uid
	 * @return array
	 */
	public function findByUid( $table = '', $uid = null, $ignoreEnableFields = false ) {
		$rows = $this->findByValues( $table, ['uid' => $uid], false, $ignoreEnableFields );
		return $rows ? array_shift($rows) : [];
	}
	
	/**
	 * action findAll
	 * Findet ALLE Eintrag
	 * 
	 * ```
	 * \nn\t3::Db()->findAll('fe_users');
	 * \nn\t3::Db()->findAll('fe_users', true);
	 * ```
	 *  @return array
	 */
	public function findAll( $table = '', $ignoreEnableFields = false ) {
		$rows = $this->findByValues( $table, [], false, $ignoreEnableFields );
		return $rows ?: [];
	}

	/**
	 * Alles persistieren...
	 * ```
	 * \nn\t3::Db()->persistAll();
	 * ```
	 * @return void
	 */	
	public function persistAll () {
		$persistenceManager = \nn\t3::injectClass( PersistenceManager::class );		
		$persistenceManager->persistAll();
	}

	/**
	 * Findet EINEN Eintrag anhand von gewünschten Feld-Werten.
	 * ```
	 * \nn\t3::Db()->findOneByValues('fe_users', ['email'=>'david@99grad.de']);
	 * ```
	 * @param string $table
	 * @param array $whereArr
	 * @param boolean $useLogicalOr
	 * @param boolean $ignoreEnableFields
	 * @return array
	 */
	public function findOneByValues( $table = null, $whereArr = [], $useLogicalOr = false, $ignoreEnableFields = false ) {
		$result = $this->findByValues( $table, $whereArr, $useLogicalOr, $ignoreEnableFields );
		return $result ? array_shift($result) : []; 
	}

	/**
	 * action findByCustomField
	 * Findet ALLE Einträge anhand eines gewünschten Feld-Wertes.
	 * Funktioniert auch, wenn	Frontend noch nicht initialisiert wurden,
	 * ```
	 * \nn\t3::Db()->findByValues('fe_users', ['email'=>'david@99grad.de']);
	 * ```
	 * @param string $table
	 * @param array $whereArr
	 * @param boolean $useLogicalOr
	 * @param boolean $ignoreEnableFields
	 * @return array
	 */
	public function findByValues( $table = null, $whereArr = [], $useLogicalOr = false, $ignoreEnableFields = false ) {
		
		// Legacy für Typo3-Versionen < 8
		if (\nn\t3::t3Version() < 8) {
			$where = ['1=1'];
			foreach ($whereArr as $k=>$v) {
				$where[] = "{$k} = " . $GLOBALS['TYPO3_DB']->fullQuoteStr($v, $table);
			}
			$where = '(' . ($useLogicalOr ? join(' OR ', $where) : join(' AND ', $where )) . ')';
			if (!$ignoreEnableFields) {
				$sysPage = \nn\t3::injectClass( \TYPO3\CMS\Frontend\Page\PageRepository::class );
				$where .= $sysPage->enableFields($table);
			}
			$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( '*', $table, $where );
			return $rows;
		}

		// Nur Felder behalten, die auch in Tabelle (TCA) existieren
		$whereArr = $this->filterDataForTable( $whereArr, $table );

		$queryBuilder = $this->getQueryBuilder( $table );
		$queryBuilder->select('*')->from( $table );

		// Alle Einschränkungen z.B. hidden oder starttime / endtime entfernen?
		if ($ignoreEnableFields) {
			$queryBuilder->getRestrictions()->removeAll();
		}

		if ($whereArr) {
			foreach ($whereArr as $colName=>$v) {
				$expr = $queryBuilder->expr()->eq( $colName, $queryBuilder->createNamedParameter( $v ));
				if (!$useLogicalOr) {
					$queryBuilder->andWhere( $expr );	
				} else {
					$queryBuilder->orWhere( $expr );	
				}
			}
		}

		// "deleted" IMMER berücksichtigen!
		if ($deleteCol = $this->getDeleteColumn( $table )) {
			$queryBuilder->andWhere( $queryBuilder->expr()->eq($deleteCol, 0) );	
		}

		$rows = $queryBuilder->execute()->fetchAll();
		return $rows;
	}


	/**
	 * Sortierung für ein Repository oder einen Query setzen.
	 * ```
	 * $ordering = ['title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING];
	 * \nn\t3::Db()->orderBy( $queryOrRepository, $ordering );
	 * ```
	 * @return $queryOrRepository
	 */
	public function orderBy( $queryOrRepository, $ordering = [] ) {
		$isQueryObject = get_class( $queryOrRepository ) == Query::class;
		$isQueryBuilderObject = get_class( $queryOrRepository) == QueryBuilder::class;

		if ($isQueryObject) {
			// ToDo!
		} else if ($isQueryBuilderObject) {
			foreach ($ordering as $colName => $ascDesc) {
				$queryOrRepository->addOrderBy( $colName, $ascDesc );
			}
		} else {
			$queryOrRepository->setDefaultOrderings( $ordering );
		}

		return $queryOrRepository;
	}

	/**
	 * Entfernt Default-Constraints zur StoragePID, hidden und/oder deleted
	 * zu einer Query oder Repository.
	 * ```
	 * \nn\t3::Db()->ignoreEnableFields( $entryRepository );
	 * \nn\t3::Db()->ignoreEnableFields( $query );
	 * ```
	 * Beispiel für eine Custom Query:
	 * ```
	 * $table = 'tx_myext_domain_model_entry';
	 * $queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	 * $queryBuilder->select('uid','title','hidden')->from( $table );
	 * \nn\t3::Db()->ignoreEnableFields( $queryBuilder, true, true );
	 * $rows = $queryBuilder->execute()->fetchAll();
	 * ```
	 * Sollte das nicht reichen oder zu kompliziert werden, siehe:
	 * ```
	 * \nn\t3::Db()->statement();
	 * ```
	 * @return boolean
	 */
    public function ignoreEnableFields ( $queryOrRepository, $ignoreStoragePid = true, $ignoreHidden = false, $ignoreDeleted = false, $ignoreStartEnd = false ) {

		$isQueryObject = get_class( $queryOrRepository ) == Query::class;
		$isQueryBuilderObject = get_class( $queryOrRepository) == QueryBuilder::class;

		if ($isQueryObject) {
			$query = $queryOrRepository;
		} else if ($isQueryBuilderObject) {

			// s. https://bit.ly/3fFvM18
			$restrictions = $queryOrRepository->getRestrictions();
			if ($ignoreStartEnd) {
				$restrictions->removeByType( \TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction::class );
				$restrictions->removeByType( \TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction::class );
			}
			if ($ignoreHidden) {
				$restrictions->removeByType( \TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction::class );
			}
			if ($ignoreDeleted) {
				$restrictions->removeByType( \TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction::class );
			}
			return $queryOrRepository;

		} else {
			$query = $queryOrRepository->createQuery();
		}

		$querySettings = $query->getQuerySettings();

		$querySettings->setRespectStoragePage( !$ignoreStoragePid );
		$querySettings->setIgnoreEnableFields( $ignoreHidden );
		$querySettings->setIncludeDeleted( $ignoreDeleted );

		if (!$isQueryObject) {
			$queryOrRepository->setDefaultQuerySettings( $querySettings );
		}

		return $query;
	}


	/**
	 * Datenbank-Eintrag aktualisieren. Schnell und einfach.
	 * ```
	 * \nn\t3::Db()->update('table', [], 1);
	 * \nn\t3::Db()->update('table', [], ['email'=>'david@99grad.de', 'pid'=>12, ...]);
	 * ```
	 * Mit `true` statt einer `$uid` werden ALLE Datensätze der Tabelle geupdated.
	 * ```
	 * \nn\t3::Db()->update('table', ['test'=>1], true);
	 * ```
	 * @return boolean
	 */
    public function update ( $table = '', $data = [], $uid ) {

		$queryBuilder = $this->getQueryBuilder( $table );
        $queryBuilder->getRestrictions()->removeAll();
		$queryBuilder->update($table);

		$data = $this->filterDataForTable( $data, $table );
		if (!$data) return false;

		foreach ($data as $k=>$v) {
			$queryBuilder->set( $k, $v );
		}

		if ($uid !== true) {	
			if (is_numeric($uid)) {
				$uid = ['uid' => $uid];
			}	
			foreach ($uid as $k=>$v) {
				$queryBuilder->andWhere(
					$queryBuilder->expr()->eq( $k, $queryBuilder->createNamedParameter($v))
				);
			}	
		}		
		
		return $queryBuilder->execute();
	}
	
	/**
	 * Datenbank-Eintrag einfügen. Simpel und idiotensicher.
	 * Gibt Array der eingefügten Daten zurück inkl. insertUid des Eintrags
	 * ```
	 * $insertArr = \nn\t3::Db()->insert('table', ['bodytext'=>'...']);
	 * ```
	 * @return int 
	 */
    public function insert ( $table = '', $data = [] ) {
		$data = $this->filterDataForTable( $data, $table );

		if (\nn\t3::t3Version() < 8) {
			$GLOBALS['TYPO3_DB']->exec_INSERTquery( $table, $data );
			$data['uid'] = $GLOBALS['TYPO3_DB']->sql_insert_id();
			return $data;
		} else {
			$queryBuilder = $this->getQueryBuilder( $table );
			$queryBuilder->insert($table)
				->values($data)->execute();
			$data['uid'] = $queryBuilder->getConnection()->lastInsertId();
			return $data;
		}
	}
	
	/**
	 * Sortiert Ergebnisse eines Queries nach einem Array und bestimmten Feld.
	 * Löst das Problem, dass eine `->in()`-Query die Ergebnisse nicht
	 * in der Reihenfolge der übergebenen IDs liefert. Beispiel:
	 * `$query->matching($query->in('uid', [3,1,2]));` kommt nicht zwingend
	 * in der Reihenfolge `[3,1,2]` zurück.
	 * ```
	 * $insertArr = \nn\t3::Db()->sortBy( $storageOrArray, 'uid', [2,1,5]);
	 * ```
	 * @return array 
	 */
    public function sortBy ( $objectArray, $fieldName = 'uid', $uidList = [] ) {
		if (method_exists( $objectArray, 'toArray')) {
			$objectArray = $objectArray->toArray();
		}
		usort( $objectArray, function ($a, $b) use ( $uidList, $fieldName ) {
			$p1 = array_search( \nn\t3::Obj()->accessSingleProperty($a, $fieldName), $uidList );
			$p2 = array_search( \nn\t3::Obj()->accessSingleProperty($b, $fieldName), $uidList );
			return $p1 > $p2 ? 1 : -1;
		});
		return $objectArray;
	}
	
	/**
	 * Datenbank-Eintrag löschen. Klein und Fein.
	 * 
	 * ```
	 * \nn\t3::Db()->delete('table', $uid);
	 * \nn\t3::Db()->delete('table', ['uid_local'=>$uid]);
	 * ```
	 * @return boolean 
	 */
    public function delete ( $table = '', $constraint = [], $reallyDelete = false ) {

		if (!$constraint) return false;
		if (is_numeric($constraint)) {
			$constraint = ['uid' => $constraint];
		}

		$deleteColumn = $reallyDelete ? false : $this->getDeleteColumn( $table );
		if ($deleteColumn) {
			return $this->update( $table, [$deleteColumn => 1], $constraint );
		}

		if (\nn\t3::t3Version() < 8) {
			if ($uid = intval($constraint['uid'])) {
				$GLOBALS['TYPO3_DB']->exec_DELETEquery( $table, 'uid='.$uid );
			}
		} else {
			$queryBuilder = $this->getQueryBuilder( $table );

			$queryBuilder->delete($table);
			foreach ($constraint as $k=>$v) {
				$queryBuilder->andWhere(
					$queryBuilder->expr()->eq( $k, $queryBuilder->createNamedParameter($v))
				);
			}

			return $queryBuilder->execute();
		}
	}

	/**
	 * Datenbank leeren.
	 * 
	 * ```
	 * \nn\t3::Db()->truncate('table');
	 * ```
	 * @return boolean 
	 */
    public function truncate ( $table = '' ) {
		$connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable( $table );
		return $connection->truncate( $table );
	}

	/**
	 * Eine "rohe" Query an die Datenbank absetzen.
	 * Näher an der Datenbank geht nicht. Du bist für alles selbst verantwortlich.
	 * Injections steht nur Deine (hoffentlich ausreichende :) Intelligenz entgegen.
	 * 
	 * Hilft z.B. bei Abfragen von Tabellen, die nicht Teil der Typo3 Installation sind und
	 * daher über den normal QueryBuilder nicht erreicht werden könnten.
	 * 
	 * ```
	 * // Variablen IMMER über escapen!
	 * $keyword = \nn\t3::Db()->quote('suchbegriff');
	 * $rows = \nn\t3::Db()->statement( "SELECT * FROM tt_news WHERE bodytext LIKE '%${keyword}%'");
	 * 
	 * // oder besser gleich prepared statements verwenden:
	 * $rows = \nn\t3::Db()->statement( 'SELECT * FROM tt_news WHERE bodytext LIKE :str', ['str'=>"%${keyword}%"] );
	 * ```
	 * 
	 * Bei einem `SELECT` Statement werden die Zeilen aus der Datenbank als Array zurückgegeben.
	 * Bei allen anderen Statements (z.B. `UPDATE` oder `DELETE`) wird die Anzahl der betroffenen Zeilen zurückgegeben.
	 * 
	 * @return mixed
	 */
	public function statement( $statement = '', $params = [] ) {
		$connection = $this->getConnection();

		// exec / fetchAll --> @siehe https://bit.ly/3ltPF0S

		if (stripos($statement, 'select ') !== false) {
			$result = $connection->fetchAll( $statement, $params );
		} else {
			$result = $connection->exec( $statement, $params );
		}

		return $result;
	}

	/**
	 * Ein Ersatz für die `mysqli_real_escape_string()` Methode.
	 * Sollte nur im Notfall bei Low-Level Queries verwendet werden. Besser ist es,
	 * preparedStatements zu verwenden.
	 * 
	 * Funktioniert nur bei SQL, nicht bei DQL.
	 * ```
	 * $sword = \nn\t3::Db()->quote($sword);
	 * $sword = \nn\t3::Db()->quote('"; DROP TABLE fe_user;#');
	 * ```
	 * @return string
	 */
	public function quote( $str = '') {
		return $this->getConnection()->quote( $str );
	}

	/**
	 * 	Datenbank-Eintrag wiederherstellen.
	 * 
	 * 	\nn\t3::Db()->undelete('table', $uid);
	 * 	\nn\t3::Db()->undelete('table', ['uid_local'=>$uid]);
	 * 
	 * 	@return boolean 
	 */
    public function undelete ( $table = '', $constraint = [] ) {
		if (!$constraint) return false;
		if (is_numeric($constraint)) {
			$constraint = ['uid' => $constraint];
		}
		if ($deleteColumn = $this->getDeleteColumn( $table )) {
			return $this->update( $table, [$deleteColumn => 0], $constraint );
		}
		return false;
	}

	/**
	 * Existiert eine bestimmte DB-Tabelle?
	 * ```
	 * $exists = \nn\t3::Db()->tableExists('table');
	 * ```
	 * @return boolean
	 */
	public function tableExists ( $table = '' ) {
		return isset($GLOBALS['TCA'][$table]);
	}

	/**
	 * Alle Tabellen-Spalten (TCA) für bestimmte Tabelle holen
	 * ```
	 * \nn\t3::Db()->getColumns( 'tablename' );
	 * ```
	 * @return array
	 */
	public function getColumns ( $table = '', $useSchemaManager = false ) {
		$cols = $GLOBALS['TCA'][$table]['columns'];

		// Diese Felder sind nicht ausdrücklich im TCA, aber für Abfrage legitim
		if ($cols) {
			$cols = \nn\t3::Arrays( $cols )->merge(['uid'=>'uid', 'pid'=>'pid', 'tstamp'=>'tstamp', 'crdate'=>'crdate', 'endtime'=>'endtime', 'starttime'=>'starttime', 'deleted'=>'deleted', 'disable'=>'disable']);
		}

		// Keine cols ermittelt, weil nicht  im TCA registriert – oder Abfrage erzwungen
		if (!$cols || $useSchemaManager) {
			$cols = GeneralUtility::makeInstance(ConnectionPool::class)
				->getConnectionForTable($table)
				->getSchemaManager()
				->listTableColumns($table);
		}
		
		foreach ($cols as $k=>$v) {
			$cols[GeneralUtility::underscoredToLowerCamelCase($k)] = $v;
		}
		return $cols;
	}
	
	/**
	 * Eine Tabellen-Spalte (TCA) für bestimmte Tabelle holen
	 * ```
	 * \nn\t3::Db()->getColumn( 'tablename', 'fieldname' );
	 * ```
	 * @return array
	 */
	public function getColumn ( $table = '', $colName = '', $useSchemaManager = false ) {
		$cols = $this->getColumns( $table, $useSchemaManager );
		return $cols[$colName] ?? [];
	}

	/**
	 * Felder einer Tabelle nach einem bestimmten Typ holen
	 * ```
	 * \nn\t3::Db()->getColumnsByType( 'tx_news_domain_model_news', 'slug' );
	 * ```
	 * @return array
	 */
	public function getColumnsByType( $table = '', $colType = '', $useSchemaManager = false ) {
		$cols = $this->getColumns( $table, $useSchemaManager );
		$results = [];
		foreach ($cols as $fieldName=>$col) {
			$type = $col['config']['type'] ?? false;
			$fieldName = GeneralUtility::camelCaseToLowerCaseUnderscored( $fieldName );
			if ($type == $colType) {
				$results[$fieldName] = array_merge(['fieldName'=>$fieldName], $col);
			}
		}
		return $results;
	}

	/**
	 * Delete-Column für bestimmte Tabelle holen.
	 * Diese Spalte wird als Flag für gelöschte Datensätze verwendet.
	 * Normalerweise: deleted = 1
	 * 
	 * @return string
	 */
	public function getDeleteColumn ( $table = '' ) {
		$ctrl = $GLOBALS['TCA'][$table]['ctrl'];
		return $ctrl['delete'] ?: false;
	}
	
	/**
	 * In key/val-Array nur Elemente behalten, deren keys auch 
	 * in TCA für bestimmte Tabelle existieren
	 * @return array
	 */
	public function filterDataForTable ( $data = [], $table = '' ) {
		$tcaColumns = $this->getColumns( $table );
		$existingCols = array_intersect( array_keys($data), array_keys($tcaColumns));

		foreach ($data as $k=>$v) {
			if (!in_array($k, $existingCols)) {
				unset($data[$k]);
			}
		}
		return $data;
	}

	/**
	 * Lokalisiertes Label eines bestimmten TCA Feldes holen
	 * @return string
	 */
	public function getColumnLabel ( $column = '', $table = '' ) {
		$tca = $this->getColumns( $table );
		$label = $tca[$column]['label'] ?? '';
		if ($label && ($LL = LocalizationUtility::translate($label))) return $LL;
		return $label;
	}
	
	/**
	 * Constraint für sys_category / sys_category_record_mm zu einem QueryBuilder hinzufügen.
	 * Beschränkt die Ergebnisse auf die angegebenen Sys-Categories-UIDs.
	 * 
	 * ```
	 * $queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	 * \nn\t3::Db()->setSysCategoryConstraint( $queryBuilder, [1,3,4], 'tx_myext_tablename', 'categories' );
	 * ```
	 * 
	 * @return $queryBuilder
	 */
	public function setSysCategoryConstraint ( &$queryBuilder = null, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories', $useNotIn = false ) {
		if (!$sysCategoryUids) return $queryBuilder;

		$and = [
			$queryBuilder->expr()->eq('categoryMM.tablenames', $queryBuilder->expr()->literal($tableName)),
			$queryBuilder->expr()->eq('categoryMM.fieldname', $queryBuilder->expr()->literal($categoryFieldName))
		];

		if (!$useNotIn) {
			$and[] = $queryBuilder->expr()->in( 'categoryMM.uid_local', $sysCategoryUids );
			$queryBuilder->andWhere(...$and);
		} else {			
			$and[] = $queryBuilder->expr()->notIn('categoryMM.uid_local', $sysCategoryUids);
			$queryBuilder->andWhere(
				$queryBuilder->expr()->orX(
					$queryBuilder->expr()->isNull('categoryMM.uid_foreign'),
					$queryBuilder->expr()->andX(...$and)
				)
			);
		}

		$queryBuilder->leftJoin(
			$tableName,
			'sys_category_record_mm',
			'categoryMM',
			$queryBuilder->expr()->eq('categoryMM.uid_foreign', $tableName . '.uid')
		)->groupBy('uid');

		return $queryBuilder;
	}

	/**
	 * Contraint auf Datensätze beschränken, die NICHT in eine der angegebenen Kategorien sind.
	 * Gegenteil und Alias zu `\nn\t3::Db()->setSysCategoryConstraint()`
	 * 
	 * ```
	 * $queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	 * \nn\t3::Db()->setNotInSysCategoryConstraint( $queryBuilder, [1,3,4], 'tx_myext_tablename', 'categories' );
	 * ```
	 * 
	 * @return $queryBuilder
	 */
	public function setNotInSysCategoryConstraint( &$queryBuilder = null, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories' ) {
		return $this->setSysCategoryConstraint( $queryBuilder, $sysCategoryUids, $tableName, $categoryFieldName, true );
	}

	/**
	 * Constraint für sys_file_reference zu einem QueryBuilder hinzufügen.
	 * Beschränkt die Ergebnisse darauf, ob es eine FAL-Relation gibt.
	 *
	 * ```
	 * $queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	 * 
	 * // Nur Datensätze holen, die für falfield mindestes eine SysFileReference haben
	 * \nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield' );
	 * 
	 * // ... die KEINE SysFileReference für falfield haben
	 * \nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', false );
	 * 
	 * // ... die GENAU 2 SysFileReferences haben
	 * \nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2 );
	 * 
	 * // ... die 2 oder weniger (less than or equal) SysFileReferences haben
	 * \nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2, 'lte' );
	 * ```
	 * 
	 *	@return $queryBuilder
	 */
	public function setFalConstraint( &$queryBuilder = null, $tableName = '', $falFieldName = '', $numFal = true, $operator = false ) {
		
		if ($operator === false) {
			if ($numFal === 0 || $numFal === 1) {
				$operator = 'eq';
			}
			if ($numFal === true) 	{
				$numFal = 1;
				$operator = 'gte';
			}
			if ($numFal === false) 	{
				$numFal = 0;
			}
		}
		if ($operator === false) {
			$operator = 'eq';
		}

		$groupName = 'cnt_' . preg_replace('[^a-zA-Z0-1]', '', $falFieldName);

		$subQuery = $this->getQueryBuilder( 'sys_file_reference' )
			->selectLiteral('COUNT(s.uid)')
			->from('sys_file_reference', 's')
			->andWhere($queryBuilder->expr()->eq('s.fieldname', $queryBuilder->createNamedParameter($falFieldName)))
			->andWhere($queryBuilder->expr()->eq('s.uid_foreign', $queryBuilder->quoteIdentifier($tableName.'.uid')))
			->getSql();

		$queryBuilder
			->addSelectLiteral("({$subQuery}) AS {$groupName}")
			->having( $queryBuilder->expr()->{$operator}($groupName, $numFal) );
		return $queryBuilder;
		
	}

	
	/**
	 * Tabellen-Name für ein Model holen.
	 * Alias zu `\nn\t3::Obj()->getTableName()`
	 * ```
	 * \nn\t3::Db()->getTableNameForModel( \My\Domain\Model\Name );
	 * ```
	 * @return string
	 */
	public function getTableNameForModel( $className = null ) {
		return \nn\t3::Obj()->getTableName( $className );
	}
	
	/**
	 * Repository für ein Model holen.
	 * ```
	 * \nn\t3::Db()->getRepositoryForModel( \My\Domain\Model\Name );
	 * ```
	 * @return string
	 */
	public function getRepositoryForModel( $className = null ) {
		if (!is_string($className)) $className = get_class($className);
		$repositoryName = \TYPO3\CMS\Core\Utility\ClassNamingUtility::translateModelNameToRepositoryName( $className );		
		return \nn\t3::injectClass( $repositoryName );
	}

	/**
	 * Debug MySQL Query
	 * ```
	 * \nn\t3::Db()->debug( $query );
	 * echo \nn\t3::Db()->debug( $query, true );
	 * ```
	 * @return string
	 */
	public function debug ( $query = null, $return = false ) {

		if( !($query instanceof QueryBuilder) ) {
			$queryParser = \nn\t3::injectClass(Typo3DbQueryParser::class);
			$query = $queryParser->convertQueryToDoctrineQueryBuilder($query);
		}

		$str = $query->getSQL();
		$dcValues = $query->getParameters();
		$dcValuesFull = [];
		foreach ($dcValues as $k=>$v) {
			$dcValuesFull[":{$k}"] = "'{$v}'";
		}

		$str = $query->getSQL();
		$str = str_replace( array_keys($dcValuesFull), array_values($dcValuesFull), $str );
		
		if (!$return) echo $str;
		return $str;

	}
}