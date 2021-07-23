<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * Zugriff auf GET / POST Variablen, Filecontainer etc.
 */
class Request implements SingletonInterface {
   
	/**
	 * 	Merge aus $_GET und $_POST-Variablen
	 *	```
	 *	\nn\t3::Request()->GP();
	 *	```
	 * 	@return array
	 */
	public function GP ( $varName = null ) {
		$gp = [];
		ArrayUtility::mergeRecursiveWithOverrule($gp, GeneralUtility::_GET() ?: []);
		ArrayUtility::mergeRecursiveWithOverrule($gp, GeneralUtility::_POST() ?: []);
		if ($varName) {
			$val = \nn\t3::Settings()->getFromPath( $varName, $gp );
			return $val ?? null;
		}
		return $gp;
	}
	
	/**
	 * File-Uploads aus `$_FILES` holen und normalisieren.
	 * 
	 * Normalisiert folgende File-Upload-Varianten. 
	 * Enfernt leere Datei-Uploads aus dem Array.
	 * 
	 * ```
	 * <input name="image" type="file" />
	 * <input name="image[key]" type="file" />
	 * <input name="images[]" type="file" multiple="1" />
	 * <input name="images[key][]" type="file" multiple="1" />
	 * ````
	 *
	 * __Beispiele:__
	 * ALLE Datei-Infos aus `$_FILES`holen.
	 * ```
	 * \nn\t3::Request()->files();
	 * \nn\t3::Request()->files( true ); // Array erzwingen
	 * ```
	 * Datei-Infos aus `tx_nnfesubmit_nnfesubmit[...]` holen.
	 * ```
	 * \nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit');
	 * \nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit', true);	// Array erzwingen
	 * ```
	 * 
	 * Nur Dateien aus `tx_nnfesubmit_nnfesubmit[fal_media]` holen.
	 * ```
	 * \nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit.fal_media' );	
	 * \nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit.fal_media', true ); // Array erzwingen	
	 * ```
	 * @return array
	 */
	public function files( $path = null, $forceArray = false ) {
		if (!$_FILES) return [];
		
		if ($path === true) {
			$path = false;
			$forceArray = true;
		}

		$fileInfosByKey = [];

		// 'tx_nnfesubmit_nnfesubmit' => ['name' => ..., 'size' => ...] 
		foreach ($_FILES as $varName => $aspects) {

			if (!$fileInfosByKey[$varName]) {
				$fileInfosByKey[$varName] = [];
			}

			foreach ($aspects as $aspectKey => $vars) {

				// $aspectKey ist IMMER 'name' || 'tmp_name' || 'size' || 'error'
				if (!is_array($vars)) {
					
					// <input type="file" name="image" />
					if ($forceArray) {
						$fileInfosByKey[$varName][0][$aspectKey] = $vars;
					} else {
						$fileInfosByKey[$varName][$aspectKey] = $vars;
					}

				} else {

					foreach ($vars as $varKey => $varValue) {
						
						// <input type="file" name="images[]" multiple="1" />
						if (is_numeric($varKey)) {
							$fileInfosByKey[$varName][$varKey][$aspectKey] = $varValue;
						}

						if (!is_numeric($varKey)) {
							if (!is_array($varValue)) {
								// <input type="file" name="image[key]" />
								if ($forceArray) {
									$fileInfosByKey[$varName][$varKey][0][$aspectKey] = $varValue;
								} else {
									$fileInfosByKey[$varName][$varKey][$aspectKey] = $varValue;
								}
							} else {
								// <input type="file" name="images[key][]" multiple="1" />
								foreach ($varValue as $n=>$v) {
									$fileInfosByKey[$varName][$varKey][$n][$aspectKey] = $v;
								}
							}
						}
					}
				}
			}
		}

		// Leere Uploads entfernen
		foreach ($fileInfosByKey as $k=>$v) {
			if (isset($v['error']) && $v['error'] == UPLOAD_ERR_NO_FILE) {
				unset($fileInfosByKey[$k]);
			}
			if (is_array($v)) {
				foreach ($v as $k1=>$v1) {
					if (isset($v1['error']) && $v1['error'] == UPLOAD_ERR_NO_FILE) {
						unset($fileInfosByKey[$k][$k1]);
					}		
					if (is_array($v1)) {
						foreach ($v1 as $k2=>$v2) {
							if (isset($v2['error']) && $v2['error'] == UPLOAD_ERR_NO_FILE) {
								unset($fileInfosByKey[$k][$k1][$k2]);
							}		
						}
					}		
				}
			}
		}
		if (!$path) return $fileInfosByKey;
		return \nn\t3::Settings()->getFromPath( $path, $fileInfosByKey );
	}
	
	/**
	 * 	Request-URI zurückgeben. Im Prinzip die URL / der GET-String 
	 * 	in der Browser URL-Leiste, der in `$_SERVER['REQUEST_URI']`
	 * 	gespeichert wird.
	 *	```
	 *	\nn\t3::Request()->getUri();
	 *	```
	 * 	@return string
	 */
	public function getUri ( $varName = null ) {
		return GeneralUtility::getIndpEnv('REQUEST_URI');
	}

	/**
	 * Sendet einen POST Request (per CURL) an einen Server.
	 * ```
	 * \nn\t3::Request()->POST( 'https://...', ['a'=>'123'] );
	 * ```
	 * @return array
	 */
	public function POST( $url = '', $postData = [], $headers = [] ) {

		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData) );
		
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			return [
				'status' 	=> '-1',
				'error'		=> curl_error($ch),
			];
		}
		curl_close($ch);
		
		return [
			'status' => 200, 
			'content' => $result
		];
	}
}