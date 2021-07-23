<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;

/**
 * Verschlüsseln und Hashen von Passworten
 */
class Encrypt implements SingletonInterface {
   
	/**
	 * Einfaches Hashing, z.B. beim Check einer uid gegen ein Hash.
	 * 
	 * ```
	 * \nn\t3::Encrypt()->hash( $uid );
	 * ```
	 * Existiert auch als ViewHelper:
	 * ```
	 * {something->nnt3:encrypt.hash()}
	 * ```
	 * @return string
	 */
	public function hash( $string = '' ) {
		$salt = \nn\t3::Environment()->getLocalConf('BE.installToolPassword');
		return preg_replace('/[^a-zA-Z0-9]/', '', base64_encode( sha1("{$string}-{$salt}", true )));
	}

	/**
	 *	Hashing eines Passwortes nach Typo3-Prinzip.
	 *	Anwendung: Passwort eines fe_users in der Datenbank überschreiben
	 *	```
	 *	\nn\t3::Encrypt()->password('99grad');
	 *	```
	 * 	@return string
	 */
    public function password ( $clearTextPassword = '', $context = 'FE' ) {
		if (\nn\t3::t3Version() < 9) {
			if (\TYPO3\CMS\Saltedpasswords\Utility\SaltedPasswordsUtility::isUsageEnabled('FE')) {
				$objSalt = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::getSaltingInstance(NULL);
				if (is_object($objSalt)) {
					$saltedPassword = $objSalt->getHashedPassword($clearTextPassword);
				}
			}
		} else {
			$hashInstance = GeneralUtility::makeInstance(PasswordHashFactory::class)->getDefaultHashInstance( $context );
			$saltedPassword = $hashInstance->getHashedPassword( $clearTextPassword );
		}
		return $saltedPassword;
	}

	/**
	 *	Prüft, ob Hash eines Passwortes und ein Passwort übereinstimmen.
	 *	Anwendung: Passwort-Hash eines fe_users in der Datenbank mit übergebenem Passwort
	 *	vergleichen.
	 *	```
	 *	\nn\t3::Encrypt()->checkPassword('99grad', '$1$wtnFi81H$mco6DrrtdeqiziRJyisdK1.');
	 *	```
	 * 	@return boolean
	 */
	public function checkPassword ( $password = '', $passwordHash = null ) {
		if (\nn\t3::t3Version() < 9) {
			$saltingObject = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::getSaltingInstance($passwordHash, 'FE');
			if (is_object($saltingObject)) {
				return $saltingObject->checkPassword($password, $passwordHash) ? true : false;
			} elseif ($passwordHash == md5($password)) {
				return true;
			}
			return false;
		} else {

			// siehe localConfiguration.php [FE][passwordHashing][className], default für Typo3 > 9 ist \TYPO3\CMS\Core\Crypto\PasswordHashing\BcryptPasswordHash
			$hashInstance = GeneralUtility::makeInstance(PasswordHashFactory::class)->getDefaultHashInstance('FE');
			$result = $hashInstance->checkPassword($password, $passwordHash);
			if ($result) return true;

			// Fallback für Passworte, die nach Update auf Typo3 9 noch den md5-Hash verwenden
			$hashInstance = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Crypto\PasswordHashing\Md5PasswordHash::class);
			$result = $hashInstance->checkPassword($password, $passwordHash);
			return $result;
		}
	}
	
	/**
	 *	Prüft, ob angegebenes Passwort noch nicht gehashed wurde.
	 *	Fallback für Typo3 v8. Kann in Typo3 > v9 entfernt werden.
	 *	```
	 *	\nn\t3::Encrypt()->isSaltedHash('$1$wtnFi81H$mco6DrrtdeqiziRJyisdK1.');
	 *	```
	 *	@return bool
	 */
	protected function isSaltedHash($password) {
		$isSaltedHash = FALSE;
		if (strlen($password) > 2 && (GeneralUtility::isFirstPartOfStr($password, 'C$') || GeneralUtility::isFirstPartOfStr($password, 'M$'))) {
			$isSaltedHash = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::determineSaltingHashingMethod(substr($password, 1));
		}
		if (!$isSaltedHash) {
			$isSaltedHash = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::determineSaltingHashingMethod($password);
		}
		return $isSaltedHash;
	}

}