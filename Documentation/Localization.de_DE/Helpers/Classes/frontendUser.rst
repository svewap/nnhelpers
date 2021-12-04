
.. include:: ../../Includes.txt

.. _FrontendUser:

==============================================
FrontendUser
==============================================

\\nn\\t3::FrontendUser()
----------------------------------------------

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::FrontendUser()->get();
"""""""""""""""""""""""""""""""""""""""""""""""

Den aktuellen FE-User holen.
Alias zu ``\nn\t3::FrontendUser()->getCurrentUser();``

.. code-block:: php

	\nn\t3::FrontendUser()->get();

Existiert auch als ViewHelper:

.. code-block:: php

	{nnt3:frontendUser.get(key:'first_name')}
	{nnt3:frontendUser.get()->f:variable.set(name:'feUser')}

| ``@return array``

\\nn\\t3::FrontendUser()->getAvailableUserGroups(``$returnRowData = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Alle existierende User-Gruppen zurückgeben.
Gibt ein assoziatives Array zurück, key ist die ``uid``, value der ``title``.

.. code-block:: php

	\nn\t3::FrontendUser()->getAvailableUserGroups();

Alternativ kann mit ``true`` der komplette Datensatz für die Benutzergruppen
zurückgegeben werden:

.. code-block:: php

	\nn\t3::FrontendUser()->getAvailableUserGroups( true );

| ``@return array``

\\nn\\t3::FrontendUser()->getCookieName();
"""""""""""""""""""""""""""""""""""""""""""""""

Cookie-Name des Frontend-User-Cookies holen.
Üblicherweise ``fe_typo_user``, außer es wurde in der LocalConfiguration geändert.

.. code-block:: php

	\nn\t3::FrontendUser()->getCookieName();

return string

\\nn\\t3::FrontendUser()->getCurrentUser();
"""""""""""""""""""""""""""""""""""""""""""""""

Array mit den Daten des aktuellen FE-Users holen.

.. code-block:: php

	\nn\t3::FrontendUser()->getCurrentUser();

| ``@return array``

\\nn\\t3::FrontendUser()->getCurrentUserGroups(``$returnRowData = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Benutzergruppen des aktuellen FE-Users als Array holen.
Die uids der Benutzergruppen werden im zurückgegebenen Array als Key verwendet.

.. code-block:: php

	// Minimalversion: Per default gibt Typo3 nur title, uid und pid zurück
	\nn\t3::FrontendUser()->getCurrentUserGroups();          // [1 => ['title'=>'Gruppe A', 'uid' => 1, 'pid'=>5]]
	
	// Mit true kann der komplette Datensatz für die fe_user_group aus der DB gelesen werden
	\nn\t3::FrontendUser()->getCurrentUserGroups( true );    // [1 => [... alle Felder der DB] ]

| ``@return array``

\\nn\\t3::FrontendUser()->getCurrentUserUid();
"""""""""""""""""""""""""""""""""""""""""""""""

UID des aktuellen Frontend-Users holen

.. code-block:: php

	$uid = \nn\t3::FrontendUser()->getCurrentUserUid();

| ``@return int``

\\nn\\t3::FrontendUser()->getGroups(``$returnRowData = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Benutzergruppen des aktuellen FE-User holen.
Alias zu ``\nn\t3::FrontendUser()->getCurrentUserGroups();``

.. code-block:: php

	// nur title, uid und pid der Gruppen laden
	\nn\t3::FrontendUser()->getGroups();
	// kompletten Datensatz der Gruppen laden
	\nn\t3::FrontendUser()->getGroups( true );

| ``@return array``

\\nn\\t3::FrontendUser()->getLanguage();
"""""""""""""""""""""""""""""""""""""""""""""""

Sprach-UID des aktuellen Users holen

.. code-block:: php

	$languageUid = \nn\t3::FrontendUser()->getLanguage();

| ``@return int``

\\nn\\t3::FrontendUser()->getSessionData(``$key = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Session-Data für FE-User holen

.. code-block:: php

	\nn\t3::FrontendUser()->getSessionData('shop')

| ``@return mixed``

\\nn\\t3::FrontendUser()->getSessionId();
"""""""""""""""""""""""""""""""""""""""""""""""

Session-ID des aktuellen Frontend-Users holen

.. code-block:: php

	$sessionId = \nn\t3::FrontendUser()->getSessionId();

| ``@return string``

\\nn\\t3::FrontendUser()->hasRole(``$roleUid``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob der User eine bestimmte Rolle hat.

.. code-block:: php

	\nn\t3::FrontendUser()->hasRole( $roleUid );

| ``@param $role``
| ``@return bool``

\\nn\\t3::FrontendUser()->isInUserGroup(``$feGroups = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob der aktuelle Frontend-User innerhalb einer bestimmte Benutzergruppe ist.

.. code-block:: php

	\nn\t3::FrontendUser()->isInUserGroup( 1 );
	\nn\t3::FrontendUser()->isInUserGroup( ObjectStorage<FrontendUserGroup> );
	\nn\t3::FrontendUser()->isInUserGroup( [FrontendUserGroup, FrontendUserGroup, ...] );
	\nn\t3::FrontendUser()->isInUserGroup( [['uid'=>1, ...], ['uid'=>2, ...]] );

| ``@return boolean``

\\nn\\t3::FrontendUser()->isLoggedIn();
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob der User aktuell als FE-User eingeloggt ist.
Früher: isset($GLOBALS['TSFE']) && $GLOBALS['TSFE']->loginUser

.. code-block:: php

	\nn\t3::FrontendUser()->isLoggedIn();

| ``@return boolean``

\\nn\\t3::FrontendUser()->login(``$username, $password = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

User manuell einloggen.
ab v10: Alias zu ``\nn\t3::FrontendUserAuthentication()->loginByUsername( $username );``

.. code-block:: php

	\nn\t3::FrontendUser()->login('99grad');
	\nn\t3::FrontendUser()->login('99grad', 'password');

| ``@param $username``
| ``@param $password``
@throws \ReflectionException

\\nn\\t3::FrontendUser()->logout();
"""""""""""""""""""""""""""""""""""""""""""""""

Aktuellen FE-USer manuell ausloggen

.. code-block:: php

	\nn\t3::FrontendUser()->logout();

| ``@return void``

\\nn\\t3::FrontendUser()->removeCookie();
"""""""""""""""""""""""""""""""""""""""""""""""

Aktuellen ``fe_typo_user``-Cookie manuell löschen

.. code-block:: php

	\nn\t3::FrontendUser()->removeCookie()

| ``@return void``

\\nn\\t3::FrontendUser()->resolveUserGroups(``$arr = [], $ignoreUids = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Wandelt ein Array oder eine kommaseparierte Liste mit Benutzergrupen-UIDs in
| ``fe_user_groups``-Daten aus der Datenbank auf. Prüft auf geerbte Untergruppe.

.. code-block:: php

	\nn\t3::FrontendUser()->resolveUserGroups( [1,2,3] );
	\nn\t3::FrontendUser()->resolveUserGroups( '1,2,3' );

| ``@return array``

\\nn\\t3::FrontendUser()->setCookie(``$sessionId = NULL, $request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Den ``fe_typo_user``-Cookie manuell setzen.

Wird keine ``sessionID`` übergeben, sucht Typo3 selbst nach der Session-ID des FE-Users.

Bei Aufruf dieser Methode aus einer MiddleWare sollte der ``Request`` mit übergeben werden.
Dadurch kann z.B. der globale ``$_COOKIE``-Wert und der ``cookieParams.fe_typo_user`` im Request
vor Authentifizierung über ``typo3/cms-frontend/authentication`` in einer eigenen MiddleWare
gesetzt werden. Hilfreich, falls eine Crossdomain-Authentifizierung erforderlich ist (z.B.
per Json Web Token / JWT).

.. code-block:: php

	\nn\t3::FrontendUser()->setCookie();
	\nn\t3::FrontendUser()->setCookie( $sessionId );
	\nn\t3::FrontendUser()->setCookie( $sessionId, $request );

| ``@return void``

\\nn\\t3::FrontendUser()->setPassword(``$feUserUid = NULL, $password = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Passwort eines FE-Users ändern.
Alias zu ``\nn\t3::FrontendUserAuthentication()->setPassword()``.

.. code-block:: php

	\nn\t3::FrontendUser()->setPassword( 12, '123passwort$#' );
	\nn\t3::FrontendUser()->setPassword( $frontendUserModel, '123Passwort#$' );

| ``@return boolean``

\\nn\\t3::FrontendUser()->setSessionData(``$key = NULL, $val = NULL, $merge = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Session-Data für FE-User setzen

.. code-block:: php

	// Session-data für `shop` mit neuen Daten mergen (bereits existierende keys in `shop` werden nicht gelöscht)
	\nn\t3::FrontendUser()->setSessionData('shop', ['a'=>1]));
	
	// Session-data für `shop` überschreiben (`a` aus dem Beispiel oben wird gelöscht)
	\nn\t3::FrontendUser()->setSessionData('shop', ['b'=>1], false));

| ``@return mixed``

