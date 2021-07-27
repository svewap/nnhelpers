
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

Login of a FE user using a session ID

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

\\nn\\t3::FrontendUserAuthentication()->setPassword(``$feUserUid = NULL, $password = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Change the password of a FE user

.. code-block:: php

	\nn\t3::FrontendUserAuthentication()->setPassword( 12, '123Password#$' );
	\nn\t3::FrontendUserAuthentication()->setPassword( $frontendUserModel, '123Password#$' );

| ``@return boolean``

