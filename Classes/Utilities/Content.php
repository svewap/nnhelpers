<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Frontend\ContentObject\RecordsContentObject;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 * Inhaltselemente und Inhalte einer Backend-Spalten (`colPos`) lesen und rendern
 */
class Content implements SingletonInterface {
  
	/**
	 * Lädt ein tt_content-Element als Array
	 * ```
	 * \nn\t3::Content()->get( 1201 );
	 * ```
	 * Laden von Relationen (`media`, `assets`, ...)
	 * ```
	 * \nn\t3::Content()->get( 1201, true );
	 * ```
	 * Element NICHT automatisch übersetzen, falls eine andere Sprache eingestellt wurde
	 * ```
	 * \nn\t3::Content()->get( 1201, false, false );
	 * ```
	 * Element in einer ANDEREN Sprache holen, als im Frontend eingestellt wurde.
	 * Berücksichtigt die Fallback-Chain der Sprache, die in der Site-Config eingestellt wurde
	 * ```
	 * \nn\t3::Content()->get( 1201, false, 2 );
	 * ```
	 * Element mit eigener Fallback-Chain holen. Ignoriert dabei vollständig die Chain, 
	 * die in der Site-Config definiert wurde.
	 * ```
	 * \nn\t3::Content()->get( 1201, false, [2,3,0] );
	 * ```
	 * @return array
	 */
    public function get( $ttContentUid = null, $getRelations = false, $localize = true ) 
	{
		if (!$ttContentUid) return [];

		// Datensatz in der Standard-Sprache holen
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
		$data = $queryBuilder
			->select('*')
			->from('tt_content')
			->andWhere($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($ttContentUid)))
			->execute()
			->fetch();
		if (!$data) return [];

		// Prüfen, ob der Datensatz übersetzt werden soll
		if ($localize !== false && $localize !== 0) {

			$currentLanguageUid = \nn\t3::Environment()->getLanguage();
			$fallbackChain = $localize === true ? $currentLanguageUid : $localize;
			$overlayMode = $localize === true ? '' : 'hideNonTranslated';
			
			if (is_numeric($fallbackChain)) {
				$fallbackChain = [$fallbackChain];
			}
			
			if ($pageRepository = \nn\t3::injectClass( PageRepository::class )) {
				foreach ($fallbackChain as $langUid) {
					if ($overlay = $pageRepository->getRecordOverlay('tt_content', $data, $langUid, $overlayMode)) {
						$data = $overlay;
						break;
					}
				}
			}
		}

		$data = $this->localize( 'tt_content', $data, $localize );

		if ($getRelations) {
			$data = $this->addRelations( $data );
		}

		return $data;
	}

	/**
	 * Daten lokalisieren / übersetzen.
	 * 
	 * Beispiele:
	 * 
	 * Daten übersetzen, dabei die aktuelle Sprache des Frontends verwenden.
	 * ```
	 * \nn\t3::Content()->localize( 'tt_content', $data );
	 * ```
	 * 
	 * Daten in einer ANDEREN Sprache holen, als im Frontend eingestellt wurde.
	 * Berücksichtigt die Fallback-Chain der Sprache, die in der Site-Config eingestellt wurde
	 * ```
	 * \nn\t3::Content()->localize( 'tt_content', $data, 2 );
	 * ```
	 * 
	 * Daten mit eigener Fallback-Chain holen. Ignoriert dabei vollständig die Chain, 
	 * die in der Site-Config definiert wurde.
	 * ```
	 * \nn\t3::Content()->localize( 'tt_content', $data, [3, 2, 0] );
	 * ```
	 * @param string $table 	Datenbank-Tabelle
	 * @param array $data 		Array mit den Daten der Standard-Sprache (languageUid = 0)
	 * @param mixed $localize	Angabe, wie übersetzt werden soll. Boolean, uid oder Array mit uids
	 * @return array
	 */
	public function localize( $table = 'tt_content', $data = [], $localize = true ) 
	{
		// `false` angegeben - oder Zielsprache ist Standardsprache? Dann nichts tun. 
		if ($localize === false || $localize === 0) {
			return $data;
		}

		$fallbackChain = \nn\t3::Environment()->getLanguageFallbackChain( $localize );
				
		if ($pageRepository = \nn\t3::injectClass( PageRepository::class )) {
			foreach ($fallbackChain as $langUid) {
				if ($overlay = $pageRepository->getRecordOverlay( $table, $data, $langUid, 'hideNonTranslated')) {
					$data = $overlay;
					break;
				}
			}
			if (count($fallbackChain) == 1 && !$overlay) {
				return [];
			}
		}

		return $data;
	}

	/**
	 * Lädt Relationen (`media`, `assets`, ...) zu einem `tt_content`-Data-Array. 
	 * Falls `EXT:mask` installiert ist, wird die entsprechende Methode aus mask genutzt.
	 * 
	 * ```
	 * \nn\t3::Content()->addRelations( $data );
	 * ```
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
			$falFields = \nn\t3::Tca()->getFalFields('tt_content');
			$fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
			foreach ($falFields as $field) {
				$data[$field] = $fileRepository->findByRelation('tt_content', $field, $data['uid']);
			}
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
		
		\nn\t3::Tsfe()->get();

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
	 * Mit `slide` werden die Inhaltselement der übergeordnete Seite geholt, falls auf der angegeben Seiten kein Inhaltselement in der Spalte existiert.
	 * 
	 * Inhalt der `colPos = 110` von der aktuellen Seite holen:
	 * ```
	 * \nn\t3::Content()->column( 110 );
	 * ```
	 * Inhalt der `colPos = 110` von der aktuellen Seite holen. Falls auf der aktuellen Seite kein Inhalt in der Spalte ist, den Inhalt aus der übergeordneten Seite verwenden:
	 * ``` 
	 * \nn\t3::Content()->column( 110, true );
	 * ```
	 * Inhalt der `colPos = 110` von der Seite mit id `99` holen:
	 * ```
	 * \nn\t3::Content()->column( 110, 99 );
	 * ```
	 * Inhalt der `colPos = 110` von der Seite mit der id `99` holen. Falls auf Seite `99` kein Inhalt in der Spalte ist, den Inhalt aus der übergeordneten Seite der Seite `99` verwenden:
	 * ``` 
	 * \nn\t3::Content()->column( 110, 99, true );
	 * ```
	 * 
	 * Auch als ViewHelper vorhanden:
	 * ```
	 * {nnt3:content.column(colPos:110)}
	 * {nnt3:content.column(colPos:110, slide:1)}
	 * {nnt3:content.column(colPos:110, pid:99)}
	 * {nnt3:content.column(colPos:110, pid:99, slide:1)}
	 * ```
	 * @return string
	 */
	public function column( $colPos, $pageUid = null, $slide = null ) {
		if ($slide === null && $pageUid === true) {
			$pageUid = null;
			$slide = true;
		}
		if (!$pageUid && !$slide) $pageUid = \nn\t3::Page()->getPid();
		$conf = [
			'table' => 'tt_content',
			'select.' => [
				'orderBy' => 'sorting',
				'where' => 'colPos=' . intval($colPos),
			],
		];
		if ($pageUid) {
			$conf['select.']['pidInList'] = intval($pageUid);
		}
		if ($slide) {
			$conf['slide'] = -1;
		}
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