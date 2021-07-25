<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\ArrayUtility;

class FrontendUser implements SingletonInterface {

 	/**
	 * Den aktuellen FE-User holen.
	 * Alias zu `\nn\t3::FrontendUser()->getCurrentUser();`
	 * ```
	 * \nn\t3::FrontendUser()->get(); 
	 *  ```
	 * Existiert auch als ViewHelper:
	 * ```
	 * {nnt3:frontendUser.get(key:'first_name')}
 	 * {nnt3:frontendUser.get()->f:variable.set(name:'feUser')}
	 * ```
	 * @return User
	 */
	public function get() {
		return $this->getCurrentUser();
	}

	/**
	 * User-Gruppe des aktuellen FE-Users holen.
	 * ```
	 * \nn\t3::FrontendUser()->getCurrentUser(); 
	 * ```
	 * @return User
	 */
	public function getCurrentUser() {
		if (!$this->isLoggedIn()) return [];
		return $GLOBALS['TSFE']->fe_user->user ?? [];
	}
	
	/**
	 * ```
	 * \nn\t3::FrontendUser()->getCurrentUserGroups();			=> [1 => ['title'=>'Gruppe A', 'uid' => 1]] 
	 * \nn\t3::FrontendUser()->getCurrentUserGroups( true );	=> [1 => [... alle Felder der DB] ] 
	 * ```
	 * @return array
	 */
	public function getCurrentUserGroups( $returnRowData = false ) {
		if (!$this->isLoggedIn()) return [];
		$rawGroupData = $GLOBALS['TSFE']->fe_user->groupData;
		$groupDataByUid = [];
		foreach ($rawGroupData['uid'] as $i=>$uid) {
			$groupDataByUid[$uid] = [];
			if ($returnRowData) {
				$groupDataByUid[$uid] = \nn\t3::Db()->findByUid('fe_groups', $uid);
			}
			foreach ($rawGroupData as $field=>$arr) {
				$groupDataByUid[$uid][$field] = $arr[$i];
			}
		}
		return $groupDataByUid;
	}
	
	/**
	 * Prüft, ob der aktuelle fe-user innerhalb einer bestimmte Benutzergruppe ist.
	 * ```
	 * \nn\t3::FrontendUser()->isInUserGroup( 1 );
	 * \nn\t3::FrontendUser()->isInUserGroup( ObjectStorage<FrontendUserGroup> );
	 * \nn\t3::FrontendUser()->isInUserGroup( [FrontendUserGroup, FrontendUserGroup, ...] );
	 * \nn\t3::FrontendUser()->isInUserGroup( [['uid'=>1, ...], ['uid'=>2, ...]] );
	 * ```
	 * @return boolean
	 */
	public function isInUserGroup( $feGroups = null ) {
		if (!$this->isLoggedIn()) return false;
		$groupsByUid = $this->getCurrentUserGroups();
		$feGroupUids = [];
		if (is_int( $feGroups)) {
			$feGroupUids = [$feGroups];
		} else {
			foreach ($feGroups as $obj) {
				$uid = false;
				if (is_int($obj)) $uid = $obj;
				if (is_array($obj) && isset($obj['uid'])) $uid = $obj['uid'];
				if (method_exists($obj, 'getUid')) $uid = $obj->getUid();
				if ($uid) $feGroupUids[] = $uid;
			}
		}
		$matches = array_intersect( array_keys($groupsByUid), $feGroupUids );
		return count($matches) > 0;
	}
	
	/**
	 * Alle existierende User-Gruppen zurückgeben
	 * 
	 * @return array
	 */
	public function getAvailableUserGroups() {
		$userGroups = \nn\t3::Db()->findAll('fe_groups');
		return \nn\t3::Arrays( $userGroups )->key('uid')->pluck('title')->toArray();
	}

	/**
	 * Check if the user is logged
	 * vorher: isset($GLOBALS['TSFE']) && $GLOBALS['TSFE']->loginUser
	 * @return bool
	 */
	public function isLoggedIn() {

		if (\nn\t3::t3Version() < 9) {
			if (!isset($GLOBALS['TSFE'])) return false;
			return $GLOBALS['TSFE']->loginUser || ($GLOBALS['TSFE']->fe_user && $GLOBALS['TSFE']->fe_user->user['uid']);
		}

		// Context `frontend.user.isLoggedIn` scheint in Middleware nicht zu gehen. Fallback auf TSFE. 
		$loginUserFromTsfe = (isset($GLOBALS['TSFE']) && isset($GLOBALS['TSFE']->fe_user) && isset($GLOBALS['TSFE']->fe_user->user['uid']));

		$context = GeneralUtility::makeInstance(Context::class);
		return $context->getPropertyFromAspect('frontend.user', 'isLoggedIn') || $loginUserFromTsfe;
	}

	/**
	 * UID des aktuellen Frontend-Users holen
	 * @return int
	 */
	public function getCurrentUserUid(){
		if (!($user = $this->getCurrentUser())) return null;
		return $user['uid'];
	}

	/**
	 * Session-ID des aktuellen Frontend-Users holen
	 * @return string
	 */
	public function getSessionId(){
		return $GLOBALS['TSFE']->fe_user ? $GLOBALS['TSFE']->fe_user->id : null;
	}

	/**
	 * Get language uid of current user
	 * @return int
	 */
	public function getLanguage(){
		return \nn\t3::Environment()->getLanguage();
	}

	/**
	 * Check if the logged in user has a specific role
	 * @param $role
	 * @return bool
	 */
	public function hasRole($roleUid){
		if (!$this->isLoggedIn()) return false;
		$userGroupsByUid = $this->getCurrentUserGroups();
		return $userGroupsByUid[$roleUid] ?? false;
	}

	/**
	 * User manuell einloggen.
	 * ab v10: Alias zu `\nn\t3::FrontendUserAuthentication()->loginByUsername( $username );`
	 * ```
	 * \nn\t3::FrontendUser()->login('99grad');
	 * \nn\t3::FrontendUser()->login('99grad', 'password');
	 * ```
	 * @param $username
	 * @param $password
	 * @throws \ReflectionException
	 */
	public function login( $username, $password = null )
	{
		if (\nn\t3::t3Version() < 10) {

			if ($password) {
				$user = \nn\t3::Db()->findByValues( 'fe_users', ['username'=>$username] );

				if (!$user) return [];
				if (count($user) > 1) return [];
				if (!\nn\t3::Encrypt()->checkPassword($password, $user[0]['password'])) {
					return [];
				}
			}

			$GLOBALS['TSFE']->fe_user->checkPid = '';
			$info = $GLOBALS['TSFE']->fe_user->getAuthInfoArray();
			$user = $GLOBALS['TSFE']->fe_user->fetchUserRecord($info['db_user'], $username);
			$loginData = array('uname' => $username, 'uident' => $user['password'], 'status' => 'login');
			if (!$user) return [];

			$GLOBALS['TSFE']->fe_user->forceSetCookie = TRUE;
			$GLOBALS['TSFE']->fe_user->createUserSession($user);
			$GLOBALS['TSFE']->fe_user->user = $user;

			$reflection = new \ReflectionClass($GLOBALS['TSFE']->fe_user);
			$setSessionCookieMethod = $reflection->getMethod('setSessionCookie');
			$setSessionCookieMethod->setAccessible(TRUE);
			$setSessionCookieMethod->invoke($GLOBALS['TSFE']->fe_user);

//			$GLOBALS['TSFE']->fe_user->user = $GLOBALS['TSFE']->fe_user->fetchUserSession();
			$session_data = $GLOBALS['TSFE']->fe_user->fetchUserSession();
			$loginSuccess = $GLOBALS['TSFE']->fe_user->compareUident($user, $loginData);

			$cookieName = \nn\t3::Environment()->getLocalConf('FE.cookieName');
			$cookieDomain = \nn\t3::Environment()->getCookieDomain();
			$cookiePath = $cookieDomain ? '/' : GeneralUtility::getIndpEnv('TYPO3_SITE_PATH');

			setcookie($cookieName, $session_data['ses_id'], time() + (86400 * 30), $cookiePath, $cookieDomain);
			setcookie('nc_staticfilecache', 'fe_typo_user_logged_in', time() + (86400 * 30), "/");
			
			// $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['postUserLookUp'][]
			
			$GLOBALS['TSFE']->fe_user->setKey('ses', $cookieName, $user);
			$GLOBALS['TSFE']->fe_user->fetchGroupData();
	
		} else {
			$user = \nn\t3::FrontendUserAuthentication()->loginByUsername( $username );
		}
		
		return $user ?: [];
	}
	
	/**
	 * Aktuellen FE-USer manuell ausloggen
	 * @return void
	 */
	public function logout() {
		if (!$this->isLoggedIn()) return false;
		$GLOBALS['TSFE']->fe_user->logoff();
		$this->removeCookie();
		// ToDo: Replace with Signal/Slot when deprecated
		if ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['logout_confirmed']) {
			$_params = array();
			foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['logout_confirmed'] as $_funcRef) {
				if ($_funcRef) GeneralUtility::callUserFunction($_funcRef, $_params, $this);
			}
		}
	}

	/**
	 * Passwort eines FE-Users ändern.
	 * Alias zu `\nn\t3::FrontendUserAuthentication()->setPassword()`.
	 * ```
	 * \nn\t3::FrontendUser()->setPassword( 12, '123passwort$#' );
	 * \nn\t3::FrontendUser()->setPassword( $frontendUserModel, '123Passwort#$' );
	 * ```
	 * @return boolean
	 */
	public function setPassword( $feUserUid = null, $password = null ) {
		return \nn\t3::FrontendUserAuthentication()->setPassword( $feUserUid, $password );
	}

	/**
	 * Aktuellen fe_typo_user-Cookie manuell löschen
	 * ```
	 * \nn\t3::FrontendUser()->removeCookie()
	 * ```
	 * @return void
	 */
	public function removeCookie() {
		$cookieDomain = \nn\t3::Environment()->getCookieDomain();
		$cookiePath = $cookieDomain ? '/' : GeneralUtility::getIndpEnv('TYPO3_SITE_PATH');
		$cookieName = \nn\t3::Environment()->getLocalConf('FE.cookieName');
		setcookie($cookieName, null, -1, $cookiePath, $cookieDomain);
		unset($_COOKIE[$cookieName]);
	}

	/**
	 * Session-Data für FE-User holen
	 * ```
	 * \nn\t3::FrontendUser()->getSessionData('shop')
	 * ```
	 * @return mixed
	 */
	public function getSessionData( $key = null ) {
		if (!$GLOBALS['TSFE'] || !$GLOBALS['TSFE']->fe_user) {
			return $key ? '' : [];
		}
		return $GLOBALS['TSFE']->fe_user->getKey( 'ses', $key ) ?: [];
	}

	/**
	 * Session-Data für FE-User setzen
	 * ```
	 * // Session-data für `shop` mit neuen Daten mergen (bereits existierende keys in `shop` werden nicht gelöscht)
	 * \nn\t3::FrontendUser()->setSessionData('shop', ['a'=>1]));
	 * 
	 * // Session-data für `shop` überschreiben (`a` aus dem Beispiel oben wird gelöscht)
	 * \nn\t3::FrontendUser()->setSessionData('shop', ['b'=>1], false));
	 * ```
	 * @return mixed
	 */
	public function setSessionData( $key = null, $val = null, $merge = true ) {
		$sessionData = $merge ? $this->getSessionData( $key ) : [];
		if (is_array($val)) {
			ArrayUtility::mergeRecursiveWithOverrule( $sessionData, $val );
		} else {
			$sessionData = $val;
		}
		//\nn\t3::debug( $GLOBALS['TSFE']->fe_user );
		$GLOBALS['TSFE']->fe_user->setKey( 'ses', $key, $sessionData );
		$GLOBALS['TSFE']->fe_user->storeSessionData();
		return $sessionData;
	}

}