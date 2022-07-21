<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\ArrayUtility;

class FrontendUser implements SingletonInterface {

	/**
	 * lokaler Cache
	 */
	protected $cache = [];

 	/**
	 * Den aktuellen FE-User holen.
	 * Alias zu `\nn\t3::FrontendUser()->getCurrentUser();`
	 * ```
	 * \nn\t3::FrontendUser()->get(); 
	 * ```
	 * Existiert auch als ViewHelper:
	 * ```
	 * {nnt3:frontendUser.get(key:'first_name')}
 	 * {nnt3:frontendUser.get()->f:variable.set(name:'feUser')}
	 * ```
	 * @return array
	 */
	public function get() {
		return $this->getCurrentUser();
	}
 	
	/**
	 * Benutzergruppen des aktuellen FE-User holen.
	 * Alias zu `\nn\t3::FrontendUser()->getCurrentUserGroups();`
	 * ```
	 * // nur title, uid und pid der Gruppen laden
	 * \nn\t3::FrontendUser()->getGroups();
	 * // kompletten Datensatz der Gruppen laden
	 * \nn\t3::FrontendUser()->getGroups( true ); 
	 * ```
	 * @return array
	 */
	public function getGroups( $returnRowData = false ) {
		return $this->getCurrentUserGroups( $returnRowData );
	}

	/**
	 * Array mit den Daten des aktuellen FE-Users holen.
	 * ```
	 * \nn\t3::FrontendUser()->getCurrentUser(); 
	 * ```
	 * @return array
	 */
	public function getCurrentUser() {
		if (!$this->isLoggedIn()) return [];

		// Wenn wir ein Frontend haben, sind die fe_user-Daten global und vollständig im TSFE gespeichert
		if (\nn\t3::t3Version() < 9 || (($GLOBALS['TSFE'] ?? false) && $GLOBALS['TSFE']->fe_user)) {
			return $GLOBALS['TSFE']->fe_user->user ?? [];
		}

		// Ohne Frontend könnten wir uns z.B. in einer Middleware befinden. Nach AUTH sind die Daten evtl im Aspect.
		$context = GeneralUtility::makeInstance(Context::class);
		$userAspect = $context->getAspect('frontend.user');
		if (!$userAspect) return [];

		$usergroupUids = array_column($this->resolveUserGroups( $userAspect->get('groupIds') ), 'uid');

		// Daten zu Standard-Darstellung normalisieren
		return [
			'uid'			=> $userAspect->get('id'),
			'username'		=> $userAspect->get('username'),
			'usergroup'		=> join(',', $usergroupUids)
		] ?? [];
	}
	
	/**
	 * Wandelt ein Array oder eine kommaseparierte Liste mit Benutzergrupen-UIDs in 
	 * `fe_user_groups`-Daten aus der Datenbank auf. Prüft auf geerbte Untergruppe.
	 * ```
	 * \nn\t3::FrontendUser()->resolveUserGroups( [1,2,3] );
	 * \nn\t3::FrontendUser()->resolveUserGroups( '1,2,3' );
	 * ```
	 * @return array
	 */
	public function resolveUserGroups( $arr = [], $ignoreUids = [] ) {

		$arr = \nn\t3::Arrays( $arr )->intExplode();
		if (!$arr) return [];

		if (\nn\t3::t3Version() > 9) {
			return GeneralUtility::makeInstance(\TYPO3\CMS\Core\Authentication\GroupResolver::class)->resolveGroupsForUser(['usergroup'=>join(',', $arr)], 'fe_groups');
		}
		
		$allGroupsByUid = $this->getAvailableUserGroups( true );
		$allGroups = array_intersect_key( $allGroupsByUid, array_flip($arr) );
		
		$allSubGroups = \nn\t3::Arrays( join(',', array_column( $allGroups, 'subgroup') ) )->intExplode();

		$additionalGroups = array_diff( $allSubGroups, $ignoreUids  );
		$ignoreUids = array_merge( $ignoreUids, array_keys($allGroups), $additionalGroups );

		if (!$additionalGroups) {
			return $allGroups;
		}

		$resolvedSubGroups = $this->resolveUserGroups( $additionalGroups, array_keys($ignoreUids) );
		$allGroups = array_merge( $resolvedSubGroups, $allGroups );

		return $allGroups;
	}

	/**
	 * Benutzergruppen des aktuellen FE-Users als Array holen.
	 * Die uids der Benutzergruppen werden im zurückgegebenen Array als Key verwendet. 
	 * ```
	 * // Minimalversion: Per default gibt Typo3 nur title, uid und pid zurück
	 * \nn\t3::FrontendUser()->getCurrentUserGroups();			// [1 => ['title'=>'Gruppe A', 'uid' => 1, 'pid'=>5]] 
	 * 
	 * // Mit true kann der komplette Datensatz für die fe_user_group aus der DB gelesen werden
	 * \nn\t3::FrontendUser()->getCurrentUserGroups( true );	// [1 => [... alle Felder der DB] ] 
	 * ```
	 * @return array
	 */
	public function getCurrentUserGroups( $returnRowData = false ) {
		if (!$this->isLoggedIn()) return [];

		if (($GLOBALS['TSFE'] ?? false) && $GLOBALS['TSFE']->fe_user) {

			// Wenn wir ein Frontend haben...
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

		} else if (\nn\t3::t3Version() >= 9) {

			// ... oder in einem Kontext ohne Frontend sind (z.B. einer Middleware)
			$context = GeneralUtility::makeInstance(Context::class);
			$userAspect = $context->getAspect('frontend.user');
			if (!$userAspect) return [];
			$userGroups = $this->resolveUserGroups($userAspect->get('groupIds'));
			if ($returnRowData) {
				return \nn\t3::Arrays($userGroups)->key('uid')->toArray() ?: [];
			} else {
				return \nn\t3::Arrays($userGroups)->key('uid')->pluck(['uid', 'title', 'pid'])->toArray();
			}
		}

		return [];
	}
	
	/**
	 * Prüft, ob der aktuelle Frontend-User innerhalb einer bestimmte Benutzergruppe ist.
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
				if (is_numeric($obj)) $uid = $obj;
				if (is_array($obj) && isset($obj['uid'])) $uid = $obj['uid'];
				if (is_object($obj) && method_exists($obj, 'getUid')) $uid = $obj->getUid();
				if ($uid) $feGroupUids[] = $uid;
			}
		}
		$matches = array_intersect( array_keys($groupsByUid), $feGroupUids );
		return count($matches) > 0;
	}
	
	/**
	 * Alle existierende User-Gruppen zurückgeben.
	 * Gibt ein assoziatives Array zurück, key ist die `uid`, value der `title`.
	 * ```
	 * \nn\t3::FrontendUser()->getAvailableUserGroups();
	 * ```
	 * Alternativ kann mit `true` der komplette Datensatz für die Benutzergruppen 
	 * zurückgegeben werden: 
	 * ```
	 * \nn\t3::FrontendUser()->getAvailableUserGroups( true );
	 * ```
	 * @return array
	 */
	public function getAvailableUserGroups( $returnRowData = false ) {

		if (!($userGroupsByUid = $this->cache['userGroupsByUid'] ?? false)) {
			$userGroups = \nn\t3::Db()->findAll('fe_groups');			
			$userGroupsByUid = \nn\t3::Arrays( $userGroups )->key('uid');
			$userGroupsByUid = $this->cache['userGroupsByUid'] = $userGroupsByUid->toArray();
		}

		if ($returnRowData) {
			return $userGroupsByUid;
		}
		
		return \nn\t3::Arrays($userGroupsByUid)->pluck('title')->toArray();
	}

	/**
	 * Prüft, ob der User aktuell als FE-User eingeloggt ist.
	 * Früher: isset($GLOBALS['TSFE']) && $GLOBALS['TSFE']->loginUser
	 * ```
	 * \nn\t3::FrontendUser()->isLoggedIn();
	 * ```
	 * @return boolean
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
	 * ```
	 * $uid = \nn\t3::FrontendUser()->getCurrentUserUid();
	 * ```
	 * @return int
	 */
	public function getCurrentUserUid(){
		if (!($user = $this->getCurrentUser())) return null;
		return $user['uid'];
	}

	/**
	 * Session-ID des aktuellen Frontend-Users holen
	 * ```
	 * $sessionId = \nn\t3::FrontendUser()->getSessionId();
	 * ```
	 * @return string
	 */
	public function getSessionId(){
		if ($sessionId = $GLOBALS['TSFE']->fe_user ? $GLOBALS['TSFE']->fe_user->id : null) {
			return $sessionId;
		}
		return $_COOKIE[$this->getCookieName()] ?? null;
	}

	/**
	 * Sprach-UID des aktuellen Users holen
	 * ```
	 * $languageUid = \nn\t3::FrontendUser()->getLanguage();
	 * ```
	 * @return int
	 */
	public function getLanguage(){
		return \nn\t3::Environment()->getLanguage();
	}

	/**
	 * Prüft, ob der User eine bestimmte Rolle hat.
	 * ```
	 * \nn\t3::FrontendUser()->hasRole( $roleUid );
	 * ```
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
			$this->setCookie( $session_data['ses_id'] );

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
	 * ```
	 * \nn\t3::FrontendUser()->logout();
	 * ```
	 * @return void
	 */
	public function logout() {
		if (!$this->isLoggedIn()) return false;
		
		// In der MiddleWare ist der FE-User evtl. noch nicht initialisiert...
		if ($TSFE = \nn\t3::Tsfe()->get()) {
			if ($TSFE->fe_user && $TSFE->fe_user->logoff) {
				$TSFE->fe_user->logoff();
			}	
		}

		// Session-Daten aus Tabelle `fe_sessions` löschen
		if ($sessionManager = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Session\SessionManager::class)) {
			$sessionBackend = $sessionManager->getSessionBackend('FE');
			$sessionBackend->remove( $this->getSessionId() );	
		}

		// ... aber Cookie löschen geht immer!
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
	 * Cookie-Name des Frontend-User-Cookies holen.
	 * Üblicherweise `fe_typo_user`, außer es wurde in der LocalConfiguration geändert.
	 * ```
	 * \nn\t3::FrontendUser()->getCookieName();
	 * ```
	 * return string
	 */
	public function getCookieName() {
		if ($cookieName = $GLOBALS['TYPO3_CONF_VARS']['FE']['cookieName'] ?? false) {
			return $cookieName;
		}
		return \nn\t3::Environment()->getLocalConf('FE.cookieName');
	}

	/**
	 * Aktuellen `fe_typo_user`-Cookie manuell löschen
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
	 * Den `fe_typo_user`-Cookie manuell setzen.
	 * 
	 * Wird keine `sessionID` übergeben, sucht Typo3 selbst nach der Session-ID des FE-Users.
	 * 
	 * Bei Aufruf dieser Methode aus einer MiddleWare sollte der `Request` mit übergeben werden.
	 * Dadurch kann z.B. der globale `$_COOKIE`-Wert und der `cookieParams.fe_typo_user` im Request 
	 * vor Authentifizierung über `typo3/cms-frontend/authentication` in einer eigenen MiddleWare
	 * gesetzt werden. Hilfreich, falls eine Crossdomain-Authentifizierung erforderlich ist (z.B.
	 * per Json Web Token / JWT).
	 * 
	 * ```
	 * \nn\t3::FrontendUser()->setCookie();
	 * \nn\t3::FrontendUser()->setCookie( $sessionId );
	 * \nn\t3::FrontendUser()->setCookie( $sessionId, $request );
	 * ```
	 * @return void
	 */
	public function setCookie( $sessionId = null, &$request = null ) {
		if (!$sessionId) $sessionId = $this->getSessionId();
		
		$cookieName = \nn\t3::Environment()->getLocalConf('FE.cookieName');
		$cookieDomain = \nn\t3::Environment()->getCookieDomain();
		$cookiePath = $cookieDomain ? '/' : GeneralUtility::getIndpEnv('TYPO3_SITE_PATH');

		$_COOKIE[$cookieName] = $sessionId;
		setcookie($cookieName, $sessionId, time() + (86400 * 30), $cookiePath, $cookieDomain);

		if (\nn\t3::t3Version() < 9) return;

		if (!$request) {
			$request = $GLOBALS['TYPO3_REQUEST'] ?? false;
		}
		if ($request) {
			$cookies = $request->getCookieParams();
			$cookies[$cookieName] = $sessionId;
			$request = $request->withCookieParams( $cookies );	
		}		
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