
.. include:: ../../Includes.txt

.. _FrontendUserAuthentication:

==============================================
FrontendUserAuthentication
==============================================

\\nn\\t3::FrontendUserAuthentication()
----------------------------------------------

Front-end user methods: from logging in to password change

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::FrontendUserAuthentication()->login(``$username = '', $password = '', $startFeUserSession = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login of a FE user based on username and password

.. code-block:: php

	// Check credentials and start feUser session.
	\nn\t3::FrontendUserAuthentication()->login( '99grad', 'password' );
	
	// Check only, do not start feUser session
	\nn\t3::FrontendUserAuthentication()->login( '99grad', 'password', false );

| ``@return array``

\\nn\\t3::FrontendUserAuthentication()->loginBySessionId(``$sessionId = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login of a FE user using a session ID.

The session ID corresponds to the TYPO3 cookie ``fe_typo_user``. Usually there is one entry for each
each fe-user session there is an entry in the ``fe_sessions`` table. Up to Typo3 v10, the
the ``ses_id`` column corresponded exactly to the cookie value.

As of Typo3 v10, the value is hashed additionally.

See also ``\nn\t3::Encrypt()->hashSessionId( $sessionId );``

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginBySessionId( $sessionId );

| ``@return array``

\\nn\\t3::FrontendUserAuthentication()->loginByUsername(``$username = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login of a FE user based on the username

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginByUsername( '99grad' );

| ``@return array``

\\nn\\t3::FrontendUserAuthentication()->loginField(``$value = NULL, $fieldName = 'uid'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login a FE user using any field.
No password required.

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginField( $value, $fieldName );

| ``@return array``

\\nn\\t3::FrontendUserAuthentication()->loginUid(``$uid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Login of a FE user using a fe_user.uid

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->loginUid( 1 );

| ``@return array``

\\nn\\t3::FrontendUserAuthentication()->prepareSession(``$usernameOrUid = NULL, $unhashedSessionId = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Create a new FrontenUser session in the ``fe_sessions`` table.
You can either specify the ``fe_users.uid`` or the ``fe_users.username``

The user will not be logged in automatically. Instead, only a valid session is created and prepared in the database.
is created and prepared in the database, which Typo3 can use later for authentication.

Returns the session ID.

The session ID here corresponds exactly to the value in the ``fe_typo_user`` cookie - but not necessarily to the
value stored in ``fe_sessions.ses_id``. The value in the database is hashed as of TYPO3 v11.
hashed.

.. code-block:: php

	$sessionId = \nn\t3::FrontendUserAuthentication()->prepareSession( 1 );
	$sessionId = \nn\t3::FrontendUserAuthentication()->prepareSession( 'david' );
	
	$hashInDatabase = \nn\t3::Encrypt()->hashSessionId( $sessionId );

If the session is to be rebuilt with an existing SessionId, an optional,
(non-hashed) SessionId can be passed as an optional second parameter:

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->prepareSession( 1, 'mycookiewert' );
	\nn\t3::FrontendUserAuthentication()->prepareSession( 1, $_COOKIE['fe_typo_user'] );

| ``@return string``

\\nn\\t3::FrontendUserAuthentication()->setPassword(``$feUserUid = NULL, $password = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Change the password of a FE user

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->setPassword( 12, '123Password#$' );
	\nn\t3::FrontendUserAuthentication()->setPassword( $frontendUserModel, '123Password#$' );

| ``@return boolean``

