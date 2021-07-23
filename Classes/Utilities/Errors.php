<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Exception;

/**
 * Fehler und Exceptions ausgeben
 */
class Errors implements SingletonInterface {
   
	/**
	 *	Eine Typo3-Exception werfen mit Backtrace
	 * 	@return int
	 */
    public function Exception ( $message, $code = null ) {
		if (!$code) $code = time();
		throw new Exception( $message, $code );
	}

}