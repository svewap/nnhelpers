
.. include:: ../../Includes.txt

.. _FrontendUserAuthentication:

==============================================
FrontendUserAuthentication
==============================================

\\nn\\t3::FrontendUserAuthentication()
----------------------------------------------

Frontend-User Methoden: Von Einloggen bis Passwort-Änderung

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::FrontendUserAuthentication()->login(``$username = '', $password = '', $startFeUserSession = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login eines FE-Users anhand der Usernamens und Passwortes

.. code-block:: php

	// Credentials überprüfen und feUser-Session starten
	\nn\t3::FrontendUserAuthentication()->login( '99grad', 'password' );
	
	// Nur überprüfen, keine feUser-Session aufbauen
	\nn\t3::FrontendUserAuthentication()->login( '99grad', 'password', false );

| ``@return array``

\\nn\\t3::FrontendUserAuthentication()->loginBySessionId(``$sessionId = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login eines FE-Users anhand einer Session-ID.

Die Session-ID entspricht dem TYPO3 Cookie ``fe_typo_user``. In der Regel gibt es für
jede Fe-User-Session einen Eintrag in der Tabelle ``fe_sessions``. Bis zu Typo3 v10 entsprach
die Spalte ``ses_id`` exakt dem Cookie-Wert.

Ab Typo3 v10 wird der Wert zusätzlich gehashed.

Siehe auch ``\nn\t3::Encrypt()->hashSessionId( $sessionId );``

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginBySessionId( $sessionId );

| ``@return array``

\\nn\\t3::FrontendUserAuthentication()->loginByUsername(``$username = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login eines FE-Users anhand der Usernamens

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginByUsername( '99grad' );

| ``@return array``

\\nn\\t3::FrontendUserAuthentication()->loginField(``$value = NULL, $fieldName = 'uid'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login eines FE-Users anhand eines beliebigen Feldes.
Kein Passwort erforderlich.

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginField( $value, $fieldName );

| ``@return array``

\\nn\\t3::FrontendUserAuthentication()->loginUid(``$uid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login eines FE-Users anhand einer fe_user.uid

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginUid( 1 );

| ``@return array``

\\nn\\t3::FrontendUserAuthentication()->prepareSession(``$usernameOrUid = NULL, $unhashedSessionId = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine neue FrontenUser-Session in der Tabelle ``fe_sessions`` anlegen.
Es kann wahlweise die ``fe_users.uid`` oder der ``fe_users.username`` übergeben werden.

Der User wird dabei nicht automatisch eingeloggt. Stattdessen wird nur eine gültige Session
in der Datenbank angelegt und vorbereitet, die Typo3 später zur Authentifizierung verwenden kann.

Gibt die Session-ID zurück.

Die Session-ID entspricht hierbei exakt dem Wert im ``fe_typo_user``-Cookie - aber nicht zwingend dem
Wert, der in ``fe_sessions.ses_id`` gespeichert wird. Der Wert in der Datenbank wird ab TYPO3 v11
gehashed.

.. code-block:: php

	$sessionId = \nn\t3::FrontendUserAuthentication()->prepareSession( 1 );
	$sessionId = \nn\t3::FrontendUserAuthentication()->prepareSession( 'david' );
	
	$hashInDatabase = \nn\t3::Encrypt()->hashSessionId( $sessionId );

Falls die Session mit einer existierenden SessionId erneut aufgebaut werden soll, kann als optionaler,
zweiter Parameter eine (nicht-gehashte) SessionId übergeben werden:

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->prepareSession( 1, 'meincookiewert' );
	\nn\t3::FrontendUserAuthentication()->prepareSession( 1, $_COOKIE['fe_typo_user'] );

| ``@return string``

\\nn\\t3::FrontendUserAuthentication()->setPassword(``$feUserUid = NULL, $password = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Passwort eines FE-Users ändern.

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->setPassword( 12, '123Passwort#$' );
	\nn\t3::FrontendUserAuthentication()->setPassword( $frontendUserModel, '123Passwort#$' );

| ``@return boolean``

