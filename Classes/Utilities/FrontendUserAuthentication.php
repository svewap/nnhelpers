<?php
namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\UserAspect;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Frontend-User Methoden: Von Einloggen bis Passwort-Änderung
 */
class FrontendUserAuthentication extends \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication {

	/**
     * @var string
     */
	public $id = '';

	/**
     * @var bool
     */
	public $checkPid = false;
	
	
	/**
	 * Login eines FE-Users anhand der Usernamens und Passwortes
	 * ```
	 * // Credentials überprüfen und feUser-Session starten
	 * \nn\t3::FrontendUserAuthentication()->login( '99grad', 'password' );
	 * 
	 * // Nur überprüfen, keine feUser-Session aufbauen
	 * \nn\t3::FrontendUserAuthentication()->login( '99grad', 'password', false );
	 * ```
	 * @return array
	 */
	public function login( $username = '', $password = '', $startFeUserSession = true ) {

		if (!trim($password) || !trim($username)) return [];

		$user = \nn\t3::Db()->findByValues( 'fe_users', ['username'=>$username] );
		if (!$user) return [];
		if (count($user) > 1) return [];

		$user = array_pop($user);
		if (!\nn\t3::Encrypt()->checkPassword($password, $user['password'])) {
			return [];
		}

		if (!$startFeUserSession) return $feUser;

		$info = $this->getAuthInfoArray();
		$info['db_user']['username_column'] = 'username';

		$feUser = $this->setSession( $user );
		return $feUser;
	}
	
	
	/**
	 * Login eines FE-Users anhand eines beliebigen Feldes.
	 * Kein Passwort erforderlich.
	 * ```
	 * \nn\t3::FrontendUserAuthentication()->loginField( $value, $fieldName );
	 * ```
	 * @return array
	 */
	public function loginField( $value = null, $fieldName = 'uid') {

		if (!$value) return [];

		$user = \nn\t3::Db()->findByValues( 'fe_users', [$fieldName => $value] );
		if (!$user) return [];
		if (!count($user) > 1) return [];
		
		$user = array_pop($user);

		$info = $this->getAuthInfoArray();
		$info['db_user']['username_column'] = 'username';

		$feUser = $this->setSession( $user );
		return $feUser;
	}
	
	/**
	 * 	Login eines FE-Users anhand einer fe_user.uid
	 *	```
	 *	\nn\t3::FrontendUserAuthentication()->loginUid( 1 );
	 *	```
	 * 	@return array
	 */
	public function loginUid( $uid = null ) {

		$uid = intval($uid);
		if (!$uid) return [];

		$user = \nn\t3::Db()->findByUid( 'fe_users', $uid );
		if (!$user) return [];

		$info = $this->getAuthInfoArray();
		$info['db_user']['username_column'] = 'username';

		$feUser = $this->setSession( $user );
		return $feUser;
	}
	
	
	/**
	 * 	Login eines FE-Users anhand einer Session-ID
	 *	```
	 *	\nn\t3::FrontendUserAuthentication()->loginBySessionId( $sessionId );
	 *	```
	 * 	@return array
	 */
	public function loginBySessionId( $sessionId = '' ) {
		if (!trim($sessionId)) return [];
		$session = \nn\t3::Db()->findOneByValues( 'fe_sessions', ['ses_id'=>$sessionId] );
		if (!$session) return [];
		if ($feUserUid = $session['ses_userid']) {
			return $this->loginUid( $feUserUid );
		}
		return [];
	}


	/**
	 * 	Login eines FE-Users anhand der Usernamens
	 *	```
	 *	\nn\t3::FrontendUserAuthentication()->loginByUsername( '99grad' );
	 *	```
	 * 	@return array
	 */
	public function loginByUsername( $username = '' ) {

		if (!trim($username)) return [];

		$user = \nn\t3::Db()->findByValues( 'fe_users', ['username'=>$username] );
		if (!$user) return [];
		if (count($user) > 1) return [];
		$user = $user[0];

		$info = $this->getAuthInfoArray();
		$info['db_user']['username_column'] = 'username';
		//$info['db_user']['username_column'] = 'email';

		$feUser = $this->setSession( $user );
		return $feUser;
	}


	/**
	 * 	Session-Data setzen, Gruppen-Daten holen
	 * 	@return void
	 */
	private function setSession($user_db) {

		$cookieName = \nn\t3::Environment()->getLocalConf('FE.cookieName') ?: 'fe_typo_user';
		
		if (!$GLOBALS['TSFE'] && \nn\t3::t3Version() >= 9) {
			$frontendUser = GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication::class);
			$frontendUser->start();
			$session = $frontendUser->createUserSession( $user_db );
			$sessionId = $session->getIdentifier();
			\nn\t3::FrontendUser()->setCookie( $sessionId );
			return $user_db;
		}

		$GLOBALS['TSFE']->fe_user->createUserSession($user_db);
		$GLOBALS['TSFE']->fe_user->user = $user_db;
		$GLOBALS['TSFE']->fe_user->setKey('ses', $cookieName, $user_db);
		$GLOBALS['TSFE']->fe_user->fetchGroupData();
		
		$session_data = $GLOBALS['TSFE']->fe_user->fetchUserSession();
		$sessionId = $session_data['ses_id'] ?? '';

		if (\nn\t3::t3Version() > 8) {
			$context = \nn\t3::injectClass(Context::class);
			$alternativeGroups = [];
			$userAspect = GeneralUtility::makeInstance(UserAspect::class, $GLOBALS['TSFE']->fe_user, $alternativeGroups);
			$context->setAspect('frontend.user', $userAspect);
		}

		if (\nn\t3::t3Version() >= 11) {
			$sessionId = $GLOBALS['TSFE']->fe_user->userSession->getIdentifier();
		}

		\nn\t3::FrontendUser()->setCookie( $sessionId );

		return $GLOBALS['TSFE']->fe_user->user;
	}
	
	/**
	 * Passwort eines FE-Users ändern.
	 * ```
	 * \nn\t3::FrontendUserAuthentication()->setPassword( 12, '123Passwort#$' );
	 * \nn\t3::FrontendUserAuthentication()->setPassword( $frontendUserModel, '123Passwort#$' );
	 * ```
	 * @return boolean
	 */
	public function setPassword( $feUserUid = null, $password = null ) {
		
		if (!$password || !$feUserUid) return false;
		if (!is_numeric($feUserUid)) $feUserUid = \nn\t3::Obj()->get( $feUserUid, 'uid' );

		$saltedPassword = \nn\t3::Encrypt()->password( $password );
		\nn\t3::Db()->update( 'fe_users', [
			'password' => $saltedPassword,
			'pwchanged' => time(),
		], $feUserUid);
		
		return true;
	}
}