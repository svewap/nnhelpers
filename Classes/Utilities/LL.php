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
	 * Localization für einen Key holen.
	 * Key kann sein:
	 * ```
	 * \nn\t3::LL()->get('LLL:EXT:nnaddress/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_entry');
	 * \nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress');
	 * ```
	 * @return mixed
	 */
	public function get( $id = '',  $extensionName = '', $args = [], $explode = '' ) {
		$value = LocalizationUtility::translate($id, $extensionName, $args );
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