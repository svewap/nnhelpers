<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;

/**
 * Methoden für die Konfiguration und den Zugriff auf Felder im TCA.
 */
class TCA implements SingletonInterface {

	/**
	 * 	Fügt Optionen aus TypoScript zur Auswahl in ein TCA ein.
	 * 	Alias zu \nn\t3::Flexform->insertOptions( $config, $a = null );
	 * 	Beschreibung und weitere Beispiele dort.
	 * 
	 * 	Beispiel im TCA:
	 *	```
	 *	'config' => [
	 *		'type' => 'select',
	 *		'itemsProcFunc' => 'nn\t3\Flexform->insertOptions',
	 *		'typoscriptPath' => 'plugin.tx_nnnewsroom.settings.templates',
	 *		//'pageconfigPath' => 'tx_nnnewsroom.colors',
	 *	]
	 *	```
	 * 	@return array
	 */
	public function insertOptions ( $config, $a = null ) {
		return \nn\t3::Flexform()->insertOptions( $config, $a );
	}

	/**
	 * Fügt Liste der Länder in ein TCA ein.
	 * Alias zu \nn\t3::Flexform->insertCountries( $config, $a = null );
	 * Beschreibung und weitere Beispiele dort.
	 * 
	 * Beispiel im TCA:
	 * ```
	 * 'config' => [
	 * 	'type' => 'select',
	 * 	'itemsProcFunc' => 'nn\t3\Flexform->insertCountries',
	 * 	'insertEmpty' => true,
	 * ]
	 * ```
	 * @return array
	 */
	public function insertCountries( $config, $a = null ) {
		return \nn\t3::Flexform()->insertCountries( $config, $a );
	}
	
	/**
	 * Fügt ein Flexform in ein TCA ein.
	 * 
	 * Beispiel im TCA:
	 * ```
	 * 'config' => \nn\t3::TCA()->insertFlexform('FILE:EXT:nnsite/Configuration/FlexForm/slickslider_options.xml');
	 * ```
	 * @return array
	 */
	public function insertFlexform( $path ) {
		return [
			'type' 	=> 'flex',
			'ds' 	=> ['default' => $path],
		];
	}

	/**
	 *	Holt Konfigurations-Array für ein Feld aus dem TCA.
	 *	Alias zu `\nn\t3::Db()->getColumn()`
	 *	```
	 *	\nn\t3::TCA()->getColumn( 'pages', 'media' );
	 *	```
	 *	@return array
	 */
	public function getColumn( $tableName = '', $fieldName = '', $useSchemaManager = false) {
		return \nn\t3::Db()->getColumn( $tableName, $fieldName, $useSchemaManager );
	}

	/**
	 *	Holt Konfigurations-Array für eine Tabelle aus dem TCA.
	 *	Alias zu `\nn\t3::Db()->getColumns()`
	 *	```
	 *	\nn\t3::TCA()->getColumns( 'pages' );
	 *	```
	 *	@return array
	 */
	public function getColumns( $tableName = '', $useSchemaManager = false) {
		return \nn\t3::Db()->getColumns( $tableName, $useSchemaManager );
	}

	/**
	 * FAL Konfiguration für das TCA holen.
	 *
	 * Standard-Konfig inkl. Image-Cropper, Link und alternativer Bildtitel
	 * Diese Einstellung ändert sich regelmäßig, was bei der Menge an Parametern
	 * und deren wechselnden Position im Array eine ziemliche Zumutung ist.
	 *
	 * https://bit.ly/2SUvASe
	 *
	 * ```
	 * \nn\t3::TCA()->getFileFieldTCAConfig('media');
	 * \nn\t3::TCA()->getFileFieldTCAConfig('media', ['maxitems'=>1, 'fileExtensions'=>'jpg']);
	 * ```
	 *
	 * Wird im TCA so eingesetzt:
	 * ```
	 * 'falprofileimage' => [
     * 	'config' => \nn\t3::TCA()->getFileFieldTCAConfig('falprofileimage', ['maxitems'=>1]),
     * ],
	 * ```
	 * @return array	
	 */
	public function getFileFieldTCAConfig( $fieldName = 'media', $override = [] ) {

		// Vereinfachte Übergabe der Optionen
		$options = array_merge([
			'maxitems' => 999,
			'fileExtensions' => $GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext']
		], $override);

		// Für Typo3 7 und 8 wird das Feld 'foreign_types' verwendet
		if (\nn\t3::t3Version() < 9) {

			$showItem = '
				--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
				--palette--;;filePalette';
			$config = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig( $fieldName,
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:media.addFileReference'
                    ],
                    'foreign_types' => [
                        '0' => ['showitem' => $showItem],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => ['showitem' => $showItem],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => ['showitem' => $showItem],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => ['showitem' => $showItem],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => ['showitem' => $showItem],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => ['showitem' => $showItem]
                    ],
                    'maxitems' => $options['maxitems']
				], $options['fileExtensions']);
				
		}

		// Für Typo3 9+ verwendet nur noch das Feld 'overrideChildTca'	
		if (\nn\t3::t3Version() >= 9) {

			$showItem = '
				--palette--;;imageoverlayPalette,
				--palette--;;filePalette';
			$config = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig( $fieldName, [
				'appearance' => [
					'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/Database.xlf:tt_content.asset_references.addFileReference'
				],
				'overrideChildTca' => [
					'types' => [
						'0' => ['showitem' => $showItem],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => ['showitem' => $showItem],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => ['showitem' => $showItem],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => ['showitem' => $showItem],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => ['showitem' => $showItem],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => ['showitem' => $showItem]
					],
				],
				'maxitems' => $options['maxitems'],
				'behaviour' => [
					'allowLanguageSynchronization' => true
				],
			], $options['fileExtensions']);
		}

		return $config;

	}


	/**
	 * RTE Konfiguration für das TCA holen.
	 * ```
	 * 'config' => \nn\t3::TCA()->getRteTCAConfig(),
	 * ```
	 * @return array
	 */
	public function getRteTCAConfig() {
		if (\nn\t3::t3Version() < 8) {
			return [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'enableRichtext' => true,
				'wizards' => [
					'RTE' => [
						'notNewRecords' => 1,
						'RTEonly' => 1,
						'type' => 'script',
						'title' => 'Full screen Rich Text Editing',
						'icon' => 'actions-wizard-rte',
						'module' => [
							'name' => 'wizard_rte',
						],
					],
				],
			];
		}
		return [
			'type' => 'text',
			'enableRichtext' => true,
		];
	}
 
	/**
	 * Color Picker Konfiguration für das TCA holen.
	 * ```
	 * 'config' => \nn\t3::TCA()->getColorPickerTCAConfig(),
	 * ```
	 * @return array
	 */
	public function getColorPickerTCAConfig() {
		if (\nn\t3::t3Version() < 8) {
			return [
				'type' => 'input',
				'eval' => 'trim',
				'wizards' => [
				'colorChoice' => [
						'type' => 'colorbox',
						'title' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tx_examples_haiku.colorPick',
						'module' => [
							'name' => 'wizard_colorpicker',
						],
						'JSopenParams' => 'height=600,width=380,status=0,menubar=0,scrollbars=1',
						//'exampleImg' => 'EXT:examples/res/images/japanese_garden.jpg',
					]
				]
			];
		}
		return [
			'type' => 'input',
			'renderType' => 'colorpicker',
			'size' => 10,
		];
	}

	
	/**
	 * In den Seiteneigenschaften unter "Verhalten -> Enthält Erweiterung" eine Auswahl-Option hinzufügen.
	 * Klassischerweise in `Configuration/TCA/Overrides/pages.php` genutzt, früher in `ext_tables.php`
	 * 
	 * ```
	 * // In ext_localconf.php das Icon registrieren (16 x 16 px SVG)
	 * \nn\t3::Registry()->icon('icon-identifier', 'EXT:myext/Resources/Public/Icons/module.svg');
	 * 
	 * // In Configuration/TCA/Overrides/pages.php
	 * \nn\t3::TCA()->addModuleOptionToPage('Beschreibung', 'identifier', 'icon-identifier');
	 * ```
	 * 
	 * @return void
	 */
	public function addModuleOptionToPage( $label, $identifier, $iconIdentifier = '') {

		// Auswahl-Option hinzufügen
		$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
			0 => $label,
			1 => $identifier,
			2 => $iconIdentifier
		];

		// Icon im Seitenbaum verwenden
		if ($iconIdentifier) {
			$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-'.$identifier] = $iconIdentifier;
		}
	}

}