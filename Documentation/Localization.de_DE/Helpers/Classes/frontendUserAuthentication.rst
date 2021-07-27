
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

Login eines FE-Users anhand einer Session-ID

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

\\nn\\t3::FrontendUserAuthentication()->setPassword(``$feUserUid = NULL, $password = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Passwort eines FE-Users ändern.

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->setPassword( 12, '123Passwort#$' );
	\nn\t3::FrontendUserAuthentication()->setPassword( $frontendUserModel, '123Passwort#$' );

| ``@return boolean``

