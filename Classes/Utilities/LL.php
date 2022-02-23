<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Wrapper für Methoden rund um die Localization von Typo3
 */
class LL implements SingletonInterface {
   
	/**
	 * Localization für einen bestimmten Key holen.
	 * 
	 * Verwendet die Übersetzungen, die im `xlf` einer Extension angegeben sind.
	 * Diese Dateien liegen standardmäßig unter `EXT:extname/Resources/Private/Language/locallang.xlf`
	 * bzw. `EXT:extname/Resources/Private/Language/de.locallang.xlf` für die jeweilige Übersetzung.
	 * 
	 * ```
	 * // Einfaches Beispiel:
	 * \nn\t3::LL()->get(''LLL:EXT:myext/Resources/Private/Language/locallang_db.xlf:my.identifier');
	 * \nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress');
	 * 
	 * // Argumente im String ersetzen: 'Nach der %s kommt die %s' oder `Vor der %2$s kommt die %1$s'
	 * \nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress', ['eins', 'zwei']);
	 * 
	 * // explode() des Ergebnisses an einem Trennzeichen
	 * \nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress', null, ',');
	 * 
	 * // In andere Sprache als aktuelle Frontend-Sprache übersetzen
	 * \nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress', null, null, 'en');
	 * \nn\t3::LL()->get('LLL:EXT:myext/Resources/Private/Language/locallang_db.xlf:my.identifier', null, null, null, 'en');
	 * ```
	 * 
	 * @param string $id
	 * @param string $extensionName
	 * @param array $args
	 * @param string $explode
	 * @param string $langKey
	 * @param string $altLangKey
	 * @return mixed
	 */
	public function get( $id = '',  $extensionName = '', $args = [], $explode = '', $langKey = null, $altLangKey = null ) {
		$value = LocalizationUtility::translate($id, $extensionName, $args, $langKey, $altLangKey);
		if (!$explode) return $value;
		return GeneralUtility::trimExplode(($explode === true ? ',' : $explode), $value);
	}

	/**
	 * Übersetzt einen Text per DeepL.
	 * Ein API-Key muss im Extension Manager eingetragen werden.
	 * DeepL erlaubt die Übersetzung von bis zu 500.000 Zeichen / Monat kostenfrei.
	 * ```
	 * \nn\t3::LL()->translate( 'Das Pferd isst keinen Gurkensalat' );
	 * \nn\t3::LL()->translate( 'Das Pferd isst keinen Gurkensalat', 'EN' );
	 * \nn\t3::LL()->translate( 'Das Pferd isst keinen Gurkensalat', 'EN', 'DE' );
	 * ```
	 * @return string
	 */
	public function translate( $srcText = '', $targetLanguageKey = 'EN', $sourceLanguageKey = 'DE' ) {
		
		$deeplConfig = \nn\t3::Environment()->getExtConf('nnhelpers');

		if (!$deeplConfig['deeplApiKey'] || !$deeplConfig['deeplApiUrl']) {
			return 'Bitte API Key und URL für DeepL im Extension-Manager angeben';
		}

		$srcText = \nn\t3::Convert($srcText)->toUTF8();

		$result = \nn\t3::Request()->POST( $deeplConfig['deeplApiUrl'], [
			'auth_key'		=> $deeplConfig['deeplApiKey'],
			'text'			=> "\n<LL>\n" . $srcText . "\n</LL>",
			'source_lang'	=> strtoupper($sourceLanguageKey),
			'target_lang'	=> strtoupper($targetLanguageKey),
		]);

		if ($result['status'] != 200) {
			return "Fehler bei POST-Query an {$deeplConfig['deeplApiUrl']} [{$result['status']}, {$result['error']}]";
		}

		$json = json_decode( $result['content'], true ) ?: ['error' => 'JSON leer'];

		if (!$json || !isset($json['translations'][0]['text'])) {
			return "Fehler bei Übersetzung.";
		}

		$text = $json['translations'][0]['text'] ?? '';
		$text = trim(str_replace(['<LL>', '</LL>'], '', $text));
		$text = str_replace( ">.\n", ">\n", $text);
		return $text;
	}
}