<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\Menu\MenuContentObjectFactory;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\DataProcessing\MenuProcessor;

/**
 *
 */
class Menu implements SingletonInterface 
{
	/**
	 * Gibt ein Array mit hierarchischer Baum-Struktur der Navigation
	 * zurück. Kann zum Rendern eines Menüs genutzt werden.
	 * ```
	 * // Struktur für aktuelle Seiten-ID (pid) holen
	 * \nn\t3::Menu()->get();
	 * 
	 * // Struktur für Seite 123 holen
	 * \nn\t3::Menu()->get( 123 );
	 * ```
	 * @param int $rootPid
	 * @param array $config
	 * @return mixed
	 */
	public function get( $rootPid = null, $config = [] ) 
	{
        $cObj = \nn\t3::Tsfe()->cObj();
		$pid = $rootPid ?: \nn\t3::Tsfe()->getPid();

        $menuProcessorConfiguration = [
            'levels' 			=> 99,
            'entryLevel' 		=> $config['entryLevel'] ?? 0,
            'special' 			=> $config['type'] ?? 'directory',
            'special.' 			=> [
				'value' => $pid,
			],
            'includeNotInMenu' 	=> $config['showHiddenInMenu'] ?? 0,
            'excludeUidList' 	=> $config['excludePages'] ?? '',
            'as' 				=> 'children',
            'expandAll' 		=> 1,
            'includeSpacer' 	=> 1,
            'titleField' 		=> 'nav_title // title',
        ];
        
        $menuProcessor = GeneralUtility::makeInstance(MenuProcessor::class);
        $menuProcessor->setContentObjectRenderer($cObj);
		
        $result = $menuProcessor->process($cObj, [], $menuProcessorConfiguration, []);
		return $result;
	}

	/**
	 * Gibt einfaches Array mit der Rootline zur aktuellen Seite.
	 * Kann für BreadCrumb-Navigationen genutzt werden
	 * ```
	 * // rootline für aktuelle Seiten-ID (pid) holen
	 * \nn\t3::Menu()->getRootline();
	 * 
	 * // rootline für Seite 123 holen
	 * \nn\t3::Menu()->getRootline( 123 );
	 * ```
	 * @param int $rootPid
	 * @param array $config
	 * @return mixed
	 */
	public function getRootline( $rootPid = null, $config = [] ) 
	{
		$config['type'] = 'rootline';
		return $this->get( $rootPid, $config )['children'];
	}

}