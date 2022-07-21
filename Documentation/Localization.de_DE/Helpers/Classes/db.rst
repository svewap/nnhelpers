
.. include:: ../../Includes.txt

.. _Db:

==============================================
Db
==============================================

\\nn\\t3::Db()
----------------------------------------------

Zugriff auf die meist genutzten Datenbank-Operationen für Schreiben, Lesen, Löschen vereinfachen.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Db()->debug(``$query = NULL, $return = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Debug des ``QueryBuilder``-Statements.

Gibt den kompletten, kompilierten Query als lesbaren String aus, so wie er später in der Datenbank
ausgeführt wird z.B. ``SELECT  FROM fe_users WHERE ...``

.. code-block:: php

	// Statement direkt im Browser ausgeben
	\nn\t3::Db()->debug( $query );
	
	// Statement als String zurückgeben, nicht automatisch ausgeben
	echo \nn\t3::Db()->debug( $query, true );

| ``@param mixed $query``
| ``@param boolean $return``
| ``@return string``

\\nn\\t3::Db()->delete(``$table = '', $constraint = [], $reallyDelete = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Datenbank-Eintrag löschen. Klein und Fein.
Es kann entweder ein Tabellenname und die UID übergeben werden - oder ein Model.

Löschen eines Datensatzes per Tabellenname und uid oder einem beliebigen Constraint:

.. code-block:: php

	// Löschen anhand der uid
	\nn\t3::Db()->delete('table', $uid);
	
	// Löschen anhand eines eigenen Feldes
	\nn\t3::Db()->delete('table', ['uid_local'=>$uid]);
	
	// Eintrag komplett und unwiderruflich löschen (nicht nur per Flag deleted = 1 entfernen)
	\nn\t3::Db()->delete('table', $uid, true);
	

Löschen eines Datensatzes per Model:

.. code-block:: php

	\nn\t3::Db()->delete( $model );

| ``@param mixed $table``
| ``@param array $constraint``
| ``@param boolean $reallyDelete``
| ``@return mixed``

\\nn\\t3::Db()->filterDataForTable(``$data = [], $table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

In key/val-Array nur Elemente behalten, deren keys auch
in TCA für bestimmte Tabelle existieren

| ``@param array $data``
| ``@param string $table``
| ``@return array``

\\nn\\t3::Db()->findAll(``$table = '', $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt ALLE Eintrag aus einer Datenbank-Tabelle.

Die Daten werden als Array zurückgegeben – das ist (leider) noch immer die absolute
performanteste Art, viele Datensätze aus einer Tabelle zu holen, da kein ``DataMapper``
die einzelnen Zeilen parsen muss.

.. code-block:: php

	// Alle Datensätze holen. "hidden" wird berücksichtigt.
	\nn\t3::Db()->findAll('fe_users');
	
	// Auch Datensätze holen, die "hidden" sind
	\nn\t3::Db()->findAll('fe_users', true);

| ``@param string $table``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->findByUid(``$table = '', $uid = NULL, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Findet einen Eintrag anhand der UID.
Funktioniert auch, wenn Frontend noch nicht initialisiert wurden,
z.B. während AuthentificationService läuft oder im Scheduler.

.. code-block:: php

	\nn\t3::Db()->findByUid('fe_user', 12);
	\nn\t3::Db()->findByUid('fe_user', 12, true);

| ``@param string $table``
| ``@param int $uid``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->findByUids(``$table = '', $uids = NULL, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Findet Einträge anhand mehrerer UIDs.

.. code-block:: php

	\nn\t3::Db()->findByUids('fe_user', [12,13]);
	\nn\t3::Db()->findByUids('fe_user', [12,13], true);

| ``@param string $table``
| ``@param int|array $uids``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->findByValues(``$table = NULL, $whereArr = [], $useLogicalOr = false, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Findet ALLE Einträge anhand eines gewünschten Feld-Wertes.
Funktioniert auch, wenn Frontend noch nicht initialisiert wurde.

.. code-block:: php

	// SELECT  FROM fe_users WHERE email = 'david@99grad.de'
	\nn\t3::Db()->findByValues('fe_users', ['email'=>'david@99grad.de']);
	
	// SELECT  FROM fe_users WHERE uid IN (1,2,3)
	\nn\t3::Db()->findByValues('fe_users', ['uid'=>[1,2,3]]);

| ``@param string $table``
| ``@param array $whereArr``
| ``@param boolean $useLogicalOr``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->findIn(``$table = '', $column = '', $values = [], $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Findet ALLE Einträge, die in der Spalte ``$column`` einen Wert aus dem Array ``$values`` enthält.
Funktioniert auch, wenn das Frontend noch nicht initialisiert wurden.
Alias zu ``\nn\t3::Db()->findByValues()``

.. code-block:: php

	// SELECT  FROM fe_users WHERE uid IN (1,2,3)
	\nn\t3::Db()->findIn('fe_users', 'uid', [1,2,3]);
	
	// SELECT  FROM fe_users WHERE username IN ('david', 'martin')
	\nn\t3::Db()->findIn('fe_users', 'username', ['david', 'martin']);

| ``@param string $table``
| ``@param string $column``
| ``@param array $values``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->findNotIn(``$table = '', $colName = '', $values = [], $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Umkehrung zu ``\nn\t3::Db()->findIn()``:

Findet ALLE Einträge, die in der Spalte ``$column`` NICHT einen Wert aus dem Array ``$values`` enthält.
Funktioniert auch, wenn das Frontend noch nicht initialisiert wurden.

.. code-block:: php

	// SELECT  FROM fe_users WHERE uid NOT IN (1,2,3)
	\nn\t3::Db()->findNotIn('fe_users', 'uid', [1,2,3]);
	
	// SELECT  FROM fe_users WHERE username NOT IN ('david', 'martin')
	\nn\t3::Db()->findNotIn('fe_users', 'username', ['david', 'martin']);

| ``@param string $table``
| ``@param string $colName``
| ``@param array $values``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->findOneByValues(``$table = NULL, $whereArr = [], $useLogicalOr = false, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Findet EINEN Eintrag anhand von gewünschten Feld-Werten.

.. code-block:: php

	// SELECT  FROM fe_users WHERE email = 'david@99grad.de'
	\nn\t3::Db()->findOneByValues('fe_users', ['email'=>'david@99grad.de']);
	
	// SELECT  FROM fe_users WHERE firstname = 'david' AND username = 'john'
	\nn\t3::Db()->findOneByValues('fe_users', ['firstname'=>'david', 'username'=>'john']);
	
	// SELECT  FROM fe_users WHERE firstname = 'david' OR username = 'john'
	\nn\t3::Db()->findOneByValues('fe_users', ['firstname'=>'david', 'username'=>'john'], true);

| ``@param string $table``
| ``@param array $whereArr``
| ``@param boolean $useLogicalOr``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->get(``$uid, $modelType = '', $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein oder mehrere Domain-Model/Entity anhand einer ``uid`` holen.
Es kann eine einzelne ``$uid`` oder eine Liste von ``$uids`` übergeben werden.

Liefert das "echte" Model/Object inklusive aller Relationen,
analog zu einer Query über das Repository.

.. code-block:: php

	// Ein einzelnes Model anhand seiner uid holen
	$model = \nn\t3::Db()->get( 1, \Nng\MyExt\Domain\Model\Name::class );
	
	// Ein Array an Models anhand ihrer uids holen
	$modelArray = \nn\t3::Db()->get( [1,2,3], \Nng\MyExt\Domain\Model\Name::class );
	
	// Gibt auch hidden Models zurück
	$modelArrayWithHidden = \nn\t3::Db()->get( [1,2,3], \Nng\MyExt\Domain\Model\Name::class, true );

| ``@param int $uid``
| ``@param string $modelType``
| ``@param boolean $ignoreEnableFields``
| ``@return Object``

\\nn\\t3::Db()->getColumn(``$table = '', $colName = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine Tabellen-Spalte (TCA) für bestimmte Tabelle holen

.. code-block:: php

	\nn\t3::Db()->getColumn( 'tablename', 'fieldname' );

| ``@param string $table``
| ``@param string $colName``
| ``@param boolean $useSchemaManager``
| ``@return array``

\\nn\\t3::Db()->getColumnLabel(``$column = '', $table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lokalisiertes Label eines bestimmten TCA Feldes holen

| ``@param string $column``
| ``@param string $table``
| ``@return string``

\\nn\\t3::Db()->getColumns(``$table = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Alle Tabellen-Spalten (TCA) für bestimmte Tabelle holen

.. code-block:: php

	// Felder anhand des TCA-Arrays holen
	\nn\t3::Db()->getColumns( 'tablename' );
	
	// Felder über den SchemaManager ermitteln
	\nn\t3::Db()->getColumns( 'tablename', true );

| ``@param string $table``
| ``@param boolean $useSchemaManager``
| ``@return array``

\\nn\\t3::Db()->getColumnsByType(``$table = '', $colType = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Felder einer Tabelle nach einem bestimmten Typ holen

.. code-block:: php

	\nn\t3::Db()->getColumnsByType( 'tx_news_domain_model_news', 'slug' );

| ``@param string $table``
| ``@param string $colType``
| ``@param boolean $useSchemaManager``
| ``@return array``

\\nn\\t3::Db()->getConnection();
"""""""""""""""""""""""""""""""""""""""""""""""

Eine "rohe" Verbindung zur Datenbank holen.
Nur in wirklichen Ausnahmefällen sinnvoll.

.. code-block:: php

	$connection = \nn\t3::Db()->getConnection();
	$connection->fetchAll( 'SELECT  FROM tt_news WHERE 1;' );

| ``@return \TYPO3\CMS\Core\Database\Connection``

\\nn\\t3::Db()->getDeleteColumn(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Delete-Column für bestimmte Tabelle holen.

Diese Spalte wird als Flag für gelöschte Datensätze verwendet.
Normalerweise: ``deleted`` = 1

| ``@param string $table``
| ``@return string``

\\nn\\t3::Db()->getQueryBuilder(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

QueryBuilder für eine Tabelle holen

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( 'fe_users' );

Beispiel:

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( 'fe_users' );
	$queryBuilder->select('name')->from( 'fe_users' );
	$queryBuilder->andWhere( $queryBuilder->expr()->eq( 'uid', $queryBuilder->createNamedParameter(12) ));
	$rows = $queryBuilder->execute()->fetchAll();

| ``@param string $table``
| ``@return QueryBuilder``

\\nn\\t3::Db()->getRepositoryForModel(``$className = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Instanz des Repositories für ein Model (oder einen Model-Klassennamen) holen.

.. code-block:: php

	\nn\t3::Db()->getRepositoryForModel( \My\Domain\Model\Name::class );
	\nn\t3::Db()->getRepositoryForModel( $myModel );

| ``@param mixed $className``
| ``@return \TYPO3\CMS\Extbase\Persistence\Repository``

\\nn\\t3::Db()->getTableNameForModel(``$className = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Tabellen-Name für ein Model (oder einen Model-Klassennamen) holen.
Alias zu ``\nn\t3::Obj()->getTableName()``

.. code-block:: php

	// tx_myext_domain_model_entry
	\nn\t3::Db()->getTableNameForModel( $myModel );
	
	// tx_myext_domain_model_entry
	\nn\t3::Db()->getTableNameForModel( \My\Domain\Model\Name::class );

| ``@param mixed $className``
| ``@return string``

\\nn\\t3::Db()->ignoreEnableFields(``$queryOrRepository, $ignoreStoragePid = true, $ignoreHidden = false, $ignoreDeleted = false, $ignoreStartEnd = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Entfernt Default-Constraints zur StoragePID, hidden und/oder deleted
zu einer Query oder Repository.

.. code-block:: php

	\nn\t3::Db()->ignoreEnableFields( $entryRepository );
	\nn\t3::Db()->ignoreEnableFields( $query );

Beispiel für eine Custom Query:

.. code-block:: php

	$table = 'tx_myext_domain_model_entry';
	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	$queryBuilder->select('uid','title','hidden')->from( $table );
	\nn\t3::Db()->ignoreEnableFields( $queryBuilder, true, true );
	$rows = $queryBuilder->execute()->fetchAll();

Sollte das nicht reichen oder zu kompliziert werden, siehe:

.. code-block:: php

	\nn\t3::Db()->statement();

| ``@param mixed $queryOrRepository``
| ``@param boolean $ignoreStoragePid``
| ``@param boolean $ignoreHidden``
| ``@param boolean $ignoreDeleted``
| ``@param boolean $ignoreStartEnd``
| ``@return mixed``

\\nn\\t3::Db()->insert(``$tableNameOrModel = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Datenbank-Eintrag einfügen. Simpel und idiotensicher.
Entweder kann der Tabellenname und ein Array übergeben werden - oder ein Domain-Model.

Einfügen eines neuen Datensatzes per Tabellenname und Daten-Array:

.. code-block:: php

	$insertArr = \nn\t3::Db()->insert('table', ['bodytext'=>'...']);

Einfügen eines neuen Models. Das Repository wird automatisch ermittelt.
Das Model wird direkt persistiert.

.. code-block:: php

	$model = new \My\Nice\Model();
	$persistedModel = \nn\t3::Db()->insert( $model );

| ``@param mixed $tableNameOrModel``
| ``@param array $data``
| ``@return mixed``

\\nn\\t3::Db()->orderBy(``$queryOrRepository, $ordering = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sortierung für ein Repository oder einen Query setzen.

.. code-block:: php

	$ordering = ['title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING];
	\nn\t3::Db()->orderBy( $queryOrRepository, $ordering );
	
	// asc und desc können als synonym verwendet werden
	$ordering = ['title' => 'asc'];
	$ordering = ['title' => 'desc'];
	\nn\t3::Db()->orderBy( $queryOrRepository, $ordering );

Kann auch zum Sortieren nach einer Liste von Werten (z.B. ``uids``) verwendet werden.
Dazu wird ein Array für den Wert des einzelnen orderings übergeben:

.. code-block:: php

	$ordering = ['uid' => [3,7,2,1]];
	\nn\t3::Db()->orderBy( $queryOrRepository, $ordering );

| ``@param mixed $queryOrRepository``
| ``@param array $ordering``
| ``@return mixed``

\\nn\\t3::Db()->persistAll();
"""""""""""""""""""""""""""""""""""""""""""""""

Alles persistieren.

.. code-block:: php

	\nn\t3::Db()->persistAll();

| ``@return void``

\\nn\\t3::Db()->quote(``$value = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein Ersatz für die ``mysqli_real_escape_string()`` Methode.

Sollte nur im Notfall bei Low-Level Queries verwendet werden.
Besser ist es, ``preparedStatements`` zu verwenden.

Funktioniert nur bei SQL, nicht bei DQL.

.. code-block:: php

	$sword = \nn\t3::Db()->quote('test');            // => 'test'
	$sword = \nn\t3::Db()->quote("test';SET");     // => 'test\';SET'
	$sword = \nn\t3::Db()->quote([1, 'test', '2']);  // => [1, "'test'", '2']
	$sword = \nn\t3::Db()->quote('"; DROP TABLE fe_user;#');

| ``@param string|array $value``
| ``@return string|array``

\\nn\\t3::Db()->save(``$tableNameOrModel = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Datenbank-Eintrag erstellen ODER einen vorhandenen Datensatz updaten.

Entscheidet selbstständig, ob der Eintrag per ``UPDATE`` oder ``INSERT`` in die Datenbank
eingefügt bzw. ein vorhandener Datensatz aktualisiert werden muss. Die Daten werden
direkt persistiert!

Beispiel für Übergabe eines Tabellennamens und eines Arrays:

.. code-block:: php

	// keine uid übergeben? Dann INSERT eines neuen Datensatzes
	\nn\t3::Db()->save('table', ['bodytext'=>'...']);
	
	// uid übergeben? Dann UPDATE vorhandener Daten
	\nn\t3::Db()->save('table', ['uid'=>123, 'bodytext'=>'...']);

Beispiel für Übergabe eines Domain-Models:

.. code-block:: php

	// neues Model? Wird per $repo->add() eingefügt
	$model = new \My\Nice\Model();
	$model->setBodytext('...');
	$persistedModel = \nn\t3::Db()->save( $model );
	
	// vorhandenes Model? Wird per $repo->update() aktualisiert
	$model = $myRepo->findByUid(123);
	$model->setBodytext('...');
	$persistedModel = \nn\t3::Db()->save( $model );

| ``@param mixed $tableNameOrModel``
| ``@param array $data``
| ``@return mixed``

\\nn\\t3::Db()->setFalConstraint(``$queryBuilder = NULL, $tableName = '', $falFieldName = '', $numFal = true, $operator = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Constraint für sys_file_reference zu einem QueryBuilder hinzufügen.
Beschränkt die Ergebnisse darauf, ob es eine FAL-Relation gibt.

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	
	// Nur Datensätze holen, die für falfield mindestes eine SysFileReference haben
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield' );
	
	// ... die KEINE SysFileReference für falfield haben
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', false );
	
	// ... die GENAU 2 SysFileReferences haben
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2 );
	
	// ... die 2 oder weniger (less than or equal) SysFileReferences haben
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2, 'lte' );

| ``@param \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder``
| ``@param string $tableName``
| ``@param string $falFieldName``
| ``@param boolean $numFal``
| ``@param boolean $operator``
| ``@return \TYPO3\CMS\Core\Database\Query\QueryBuilder``

\\nn\\t3::Db()->setNotInSysCategoryConstraint(``$queryBuilder = NULL, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Contraint auf Datensätze beschränken, die NICHT in eine der angegebenen Kategorien sind.
Gegenteil und Alias zu ``\nn\t3::Db()->setSysCategoryConstraint()``

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	\nn\t3::Db()->setNotInSysCategoryConstraint( $queryBuilder, [1,3,4], 'tx_myext_tablename', 'categories' );

| ``@param \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder``
| ``@param array $sysCategoryUids``
| ``@param string $tableName``
| ``@param string $categoryFieldName``
| ``@return \TYPO3\CMS\Core\Database\Query\QueryBuilder``

\\nn\\t3::Db()->setSysCategoryConstraint(``$queryBuilder = NULL, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories', $useNotIn = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Constraint für sys_category / sys_category_record_mm zu einem QueryBuilder hinzufügen.
Beschränkt die Ergebnisse auf die angegebenen Sys-Categories-UIDs.

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	\nn\t3::Db()->setSysCategoryConstraint( $queryBuilder, [1,3,4], 'tx_myext_tablename', 'categories' );

| ``@param \TYPO3\CMS\Core\Database\Query\QueryBuilder $querybuilder``
| ``@param array $sysCategoryUids``
| ``@param string $tableName``
| ``@param string $categoryFieldName``
| ``@param boolean $useNotIn``
| ``@return \TYPO3\CMS\Core\Database\Query\QueryBuilder``

\\nn\\t3::Db()->sortBy(``$objectArray, $fieldName = 'uid', $uidList = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sortiert Ergebnisse eines Queries nach einem Array und bestimmten Feld.
Löst das Problem, dass eine ``->in()``-Query die Ergebnisse nicht
in der Reihenfolge der übergebenen IDs liefert. Beispiel:
| ``$query->matching($query->in('uid', [3,1,2]));`` kommt nicht zwingend
in der Reihenfolge ``[3,1,2]`` zurück.

.. code-block:: php

	$insertArr = \nn\t3::Db()->sortBy( $storageOrArray, 'uid', [2,1,5]);

| ``@param mixed $objectArray``
| ``@param string $fieldName``
| ``@param array $uidList``
| ``@return array``

\\nn\\t3::Db()->statement(``$statement = '', $params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine "rohe" Query an die Datenbank absetzen.
Näher an der Datenbank geht nicht. Du bist für alles selbst verantwortlich.
Injections steht nur Deine (hoffentlich ausreichende :) Intelligenz entgegen.

Hilft z.B. bei Abfragen von Tabellen, die nicht Teil der Typo3 Installation sind und
daher über den normal QueryBuilder nicht erreicht werden könnten.

.. code-block:: php

	// Variablen IMMER über escapen!
	$keyword = \nn\t3::Db()->quote('suchbegriff');
	$rows = \nn\t3::Db()->statement( "SELECT  FROM tt_news WHERE bodytext LIKE '%${keyword}%'");
	
	// oder besser gleich prepared statements verwenden:
	$rows = \nn\t3::Db()->statement( 'SELECT  FROM tt_news WHERE bodytext LIKE :str', ['str'=>"%${keyword}%"] );

Bei einem ``SELECT`` Statement werden die Zeilen aus der Datenbank als Array zurückgegeben.
Bei allen anderen Statements (z.B. ``UPDATE`` oder ``DELETE``) wird die Anzahl der betroffenen Zeilen zurückgegeben.

| ``@param string $statement``
| ``@param array $params``
| ``@return mixed``

\\nn\\t3::Db()->tableExists(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Existiert eine bestimmte DB-Tabelle?

.. code-block:: php

	$exists = \nn\t3::Db()->tableExists('table');

| ``@return boolean``

\\nn\\t3::Db()->truncate(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Datenbank-Tabelle leeren.
Löscht alle Einträge in der angegebenen Tabelle und setzt den Auto-Increment-Wert auf ``0`` zurück.

.. code-block:: php

	\nn\t3::Db()->truncate('table');

| ``@param string $table``
| ``@return boolean``

\\nn\\t3::Db()->undelete(``$table = '', $constraint = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gelöschten Datenbank-Eintrag wiederherstellen.
Dazu wird der Flag für "gelöscht" (``deleted``) wieder auf ``0`` gesetzt wird.

.. code-block:: php

	\nn\t3::Db()->undelete('table', $uid);
	\nn\t3::Db()->undelete('table', ['uid_local'=>$uid]);

| ``@param string $table``
| ``@param array $constraint``
| ``@return boolean``

\\nn\\t3::Db()->update(``$tableNameOrModel = '', $data = [], $uid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Datenbank-Eintrag aktualisieren. Schnell und einfach.
Das Update kann entweder per Tabellenname und Daten-Array passieren.
Oder man übergibt ein Model.

Beispiele:

.. code-block:: php

	// UPDATES table SET title='new' WHERE uid=1
	\nn\t3::Db()->update('table', ['title'=>'new'], 1);
	
	// UPDATE table SET title='new' WHERE email='david@99grad.de' AND pid=12
	\nn\t3::Db()->update('table', ['title'=>'new'], ['email'=>'david@99grad.de', 'pid'=>12, ...]);

Mit ``true`` statt einer ``$uid`` werden ALLE Datensätze der Tabelle geupdated.

.. code-block:: php

	// UPDATE table SET test='1' WHERE 1
	\nn\t3::Db()->update('table', ['test'=>1], true);

Statt einem Tabellenname kann auch ein einfach Model übergeben werden.
Das Repository wird automatisch ermittelt und das Model direkt persistiert.

.. code-block:: php

	$model = $myRepo->findByUid(1);
	\nn\t3::Db()->update( $model );

| ``@param mixed $tableNameOrModel``
| ``@param array $data``
| ``@param int $uid``
| ``@return mixed``

