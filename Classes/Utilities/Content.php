<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Frontend\ContentObject\RecordsContentObject;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Inhaltselemente und Inhalte einer Backend-Spalten (`colPos`) lesen und rendern
 */
class Content implements SingletonInterface {
  
	/**
	 * 	Lädt ein tt_content-Element als Array
	 *	```
	 *	\nn\t3::Content()->get( 1201 );
	 *	```
	 *	Laden von Relationen (`media`, `assets`, ...)
	 *	```
	 *	\nn\t3::Content()->get( 1201, true );
	 *	```
	 * 	@return array
	 */
    public function get( $ttContentUid = null, $getRelations = false ) {
		if (!$ttContentUid) return [];
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
		$data = $queryBuilder
			->select('*')
			->from('tt_content')
			->andWhere($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($ttContentUid)))
			->execute()
			->fetch();
		if (!$data) return [];

		if ($getRelations) {
			$data = $this->addRelations( $data );
		}

		return $data;
	}

	/**
	 * Lädt Relationen (`media`, `assets`, ...) zu einem `tt_content`-Data-Array.
	 * Nutzt dafür eine `EXT:mask`-Methode.
	 * ```
	 * \nn\t3::Content()->addRelations( $data );
	 * ```
	 * @todo: Von mask entkoppeln
	 * @return array
	 */
	public function addRelations ( $data = [] ) {
		if (!$data) return [];
		if (\nn\t3::Environment()->extLoaded('mask')) {
			$maskProcessor = GeneralUtility::makeInstance( \MASK\Mask\DataProcessing\MaskProcessor::class );
			$cObjRenderer = GeneralUtility::makeInstance( \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class );
			$dataWithRelations = $maskProcessor->process( $cObjRenderer, [], [], ['data'=>$data, 'current'=>null] );
			$data = $dataWithRelations['data'] ?: [];
		} else {
			\nn\t3::Exception( 'EXT:mask muss installiert sein, um die getRelations() Option zu nutzen.' );
		}
		return $data;
	}

	/**
	 * Rendert ein `tt_content`-Element als HTML
	 * ```
	 * \nn\t3::Content()->render( 1201 );
	 * \nn\t3::Content()->render( 1201, ['key'=>'value'] );
	 * ```
	 * Auch als ViewHelper vorhanden:
	 * ```
	 * {nnt3:contentElement(uid:123, data:feUser.data)}
	 * ```
	 * @return string
	 */
	public function render( $ttContentUid = null, $data = [] ) {
		if (!$ttContentUid) return '';
		$conf = [
			'tables' => 'tt_content',
			'source' => $ttContentUid,
			'dontCheckPid' => 1
		];
		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);
		$html = $objectManager->get(RecordsContentObject::class)->render($conf);

		// Wenn data-Array übergeben wurde, Ergebnis erneut über Fluid Standalone-View parsen.
		if ($data) {
			$html = \nn\t3::Template()->renderHtml( $html, $data );
		}
		return $html;
	}

	/**
	 * Lädt den Content für eine bestimmte Spalte (`colPos`) und Seite.
	 * Wird keine pageUid angegeben, verwendet er die aktuelle Seite.
	 * ```
	 * \nn\t3::Content()->column( 110 );
	 * \nn\t3::Content()->column( $colPos, $pageUid );
	 * ```
	 * Auch als ViewHelper vorhanden:
	 * ```
	 * {nnt3:content.column(colPos:110)}
	 * {nnt3:content.column(colPos:110, pid:99)}
	 * ```
	 * @return string
	 */
	public function column( $colPos, $pageUid = null ) {
		if (!$pageUid) $pageUid = \nn\t3::Page()->getPid();
		$conf = [
			'table' => 'tt_content',
			'select.' => [
				'orderBy' => 'sorting',
				'where' => 'colPos=' . intval($colPos),
				'pidInList' => intval($pageUid),
			],
		];
		$html = \nn\t3::Tsfe()->cObj()->cObjGetSingle('CONTENT', $conf);
		return $html;
	}

	/**
	 * Lädt die "rohen" `tt_content` Daten einer bestimmten Spalte (`colPos`).
	 * ```
	 * \nn\t3::Content()->columnData( 110 );
	 * \nn\t3::Content()->columnData( 110, true );
	 * \nn\t3::Content()->columnData( 110, true, 99 );
	 * ```
	 * Auch als ViewHelper vorhanden.
	 * `relations` steht im ViewHelper als default auf `TRUE`
	 * ```
	 * {nnt3:content.columnData(colPos:110)}
	 * {nnt3:content.columnData(colPos:110, pid:99, relations:0)}
	 * ```
	 * @return array
	 */
	public function columnData( $colPos, $addRelations = false, $pageUid = null ) {
		
		if (!$pageUid) $pageUid = \nn\t3::Page()->getPid();

		$queryBuilder = \nn\t3::Db()->getQueryBuilder('tt_content');		
		$data = $queryBuilder
			->select('*')
			->from('tt_content')
			->andWhere($queryBuilder->expr()->eq('colPos', $queryBuilder->createNamedParameter($colPos)))
			->andWhere($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pageUid)))
			->orderBy('sorting')
			->execute()
			->fetchAll();
		if (!$data) return [];

		if ($addRelations) {
			foreach ($data as $n=>$row) {
				$data[$n] = $this->addRelations( $row );
			}
		}

		return $data;
	}
}