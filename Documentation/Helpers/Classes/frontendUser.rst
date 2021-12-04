
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

Get the current FE user.
Alias to ``\nn\t3::FrontendUser()->getCurrentUser();``

.. code-block:: php

	\nn\t3::FrontendUser()->get();

Also acts as a ViewHelper:

.. code-block:: php

	{nnt3:frontendUser.get(key:'first_name')}
	{nnt3:frontendUser.get()->f:variable.set(name:'feUser')}

| ``@return array``

\\nn\\t3::FrontendUser()->getAvailableUserGroups(``$returnRowData = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Return all existing user groups.
Returns an associative array, key is the ``uid``, value is the ``title``.

.. code-block:: php

	\nn\t3::FrontendUser()->getAvailableUserGroups();

Alternatively, you can use ``true`` to return the complete dataset for the user groups.
can be returned:

.. code-block:: php

	\nn\t3::FrontendUser()->getAvailableUserGroups( true );

| ``@return array``

\\nn\\t3::FrontendUser()->getCookieName();
"""""""""""""""""""""""""""""""""""""""""""""""

Get cookie name of frontend user cookie.
Usually ``fe_typo_user``, unless it has been changed in the LocalConfiguration.

.. code-block:: php

	\nn\t3::FrontendUser()->getCookieName();

return string

\\nn\\t3::FrontendUser()->getCurrentUser();
"""""""""""""""""""""""""""""""""""""""""""""""

Get array with the data of the current FE user.

.. code-block:: php

	\nn\t3::FrontendUser()->getCurrentUser();

| ``@return array``

\\nn\\t3::FrontendUser()->getCurrentUserGroups(``$returnRowData = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get user groups of the current FE user as an array.
The uids of the usergroups are used as keys in the returned array.

.. code-block:: php

	// Minimal version: By default Typo3 returns only title, uid and pid.
	\nn\t3::FrontendUser()->getCurrentUserGroups(); // [1 => ['title'=>'Group A', 'uid' => 1, 'pid'=>5]]
	
	// With true the complete dataset für the fe_user_group can be read from the DB
	\nn\t3::FrontendUser()->getCurrentUserGroups( true ); // [1 => [... all fields of the DB] ]

| ``@return array``

\\nn\\t3::FrontendUser()->getCurrentUserUid();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the UID of the current frontend user

.. code-block:: php

	$uid = \nn\t3::FrontendUser()->getCurrentUserUid();

| ``@return int``

\\nn\\t3::FrontendUser()->getGroups(``$returnRowData = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get user groups of the current FE user.
Alias to ``nn\t3::FrontendUser()->getCurrentUserGroups();``

.. code-block:: php

	// load only title, uid and pid of the groups.
	\nn\t3::FrontendUser()->getGroups();
	// load the complete record of the groups
	\nn\t3::FrontendUser()->getGroups( true );

| ``@return array``

\\nn\\t3::FrontendUser()->getLanguage();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the language UID of the current user

.. code-block:: php

	$languageUid = \nn\t3::FrontendUser()->getLanguage();

| ``@return int``

\\nn\\t3::FrontendUser()->getSessionData(``$key = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get session data for FE users

.. code-block:: php

	\nn\t3::FrontendUser()->getSessionData('shop')

| ``@return mixed``

\\nn\\t3::FrontendUser()->getSessionId();
"""""""""""""""""""""""""""""""""""""""""""""""

Get session id of current frontend user

.. code-block:: php

	$sessionId = \nn\t3::FrontendUser()->getSessionId();

| ``@return string``

\\nn\\t3::FrontendUser()->hasRole(``$roleUid``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft whether the user has a specific role.

.. code-block:: php

	\nn\t3::FrontendUser()->hasRole( $roleUid );

| ``@param $role``
| ``@return bool``

\\nn\\t3::FrontendUser()->isInUserGroup(``$feGroups = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Checks if the current frontend user is within a specific user group.

.. code-block:: php

	\nn\t3::FrontendUser()->isInUserGroup( 1 );
	\nn\t3::FrontendUser()->isInUserGroup( ObjectStorage<FrontendUserGroup> );
	\nn\t3::FrontendUser()->isInUserGroup( [FrontendUserGroup, FrontendUserGroup, ...] );
	\nn\t3::FrontendUser()->isInUserGroup( [['uid'=>1, ...], ['uid'=>2, ...]] );

| ``@return boolean``

\\nn\\t3::FrontendUser()->isLoggedIn();
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft whether the user is currently logged in as a FE user.
Früher: isset($GLOBALS['TSFE']) && $GLOBALS['TSFE']->loginUser

.. code-block:: php

	\nn\t3::FrontendUser()->isLoggedIn();

| ``@return boolean``

\\nn\\t3::FrontendUser()->login(``$username, $password = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Logging in user manually.
As of v10: alias to ``\nn\t3::FrontendUserAuthentication()->loginByUsername( $username );``

.. code-block:: php

	\nn\t3::FrontendUser()->login('99grad');
	\nn\t3::FrontendUser()->login('99degrees', 'password');

| ``@param $username``
| ``@param $password``
@throws \ReflectionException

\\nn\\t3::FrontendUser()->logout();
"""""""""""""""""""""""""""""""""""""""""""""""

Manually log out current FE-USer

.. code-block:: php

	\nn\t3::FrontendUser()->logout();

| ``@return void``

\\nn\\t3::FrontendUser()->removeCookie();
"""""""""""""""""""""""""""""""""""""""""""""""

Manually delete the current fe_typo_user cookie

.. code-block:: php

	\nn\t3::FrontendUser()->removeCookie()

| ``@return void``

\\nn\\t3::FrontendUser()->resolveUserGroups(``$arr = [], $ignoreUids = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts an array or comma-separated list of user group UIDs to.
| ``fe_user_groups`` data from the database. Prüft on inherited subgroup.

.. code-block:: php

	\nn\t3::FrontendUser()->resolveUserGroups( [1,2,3] );
	\nn\t3::FrontendUser()->resolveUserGroups( '1,2,3' );

| ``@return array``

\\nn\\t3::FrontendUser()->setCookie(``$sessionId = NULL, $request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Set the ``fe_typo_user`` cookie manually.

If no ``sessionID`` is passed, Typo3 itself searches for the session ID of the FE user.

When calling this method from a MiddleWare, the ``request`` should be passed with ü.
This allows, for example, the global ``$_COOKIE`` value and the ``cookieParams.fe_typo_user`` to be passed in the request
before authentication via ``typo3/cms-frontend/authentication`` in a separate middleware.
must be set. Helpful if crossdomain authentication is required (e.g.
Per Json Web Token / JWT).

.. code-block:: php

	\nn\t3::FrontendUser()->setCookie();
	\nn\t3::FrontendUser()->setCookie( $sessionId );
	\nn\t3::FrontendUser()->setCookie( $sessionId, $request );

| ``@return void``

\\nn\\t3::FrontendUser()->setPassword(``$feUserUid = NULL, $password = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Change the password of a FE user.
Alias to ``\nn\t3::FrontendUserAuthentication()->setPassword()``.

.. code-block:: php

	\nn\t3::FrontendUser()->setPassword( 12, '123password$#' );
	\nn\t3::FrontendUser()->setPassword( $frontendUserModel, '123password#$' );

| ``@return boolean``

\\nn\\t3::FrontendUser()->setSessionData(``$key = NULL, $val = NULL, $merge = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Set session-data for FE-user

.. code-block:: php

	// Merge session-data for `shop` with new data (already existing keys in `shop` will not be deleted).
	\nn\t3::FrontendUser()->setSessionData('shop', ['a'=>1]));
	
	// overwrite session-data for `shop` (`a` from the example above will be deleted)
	\nn\t3::FrontendUser()->setSessionData('shop', ['b'=>1], false));

| ``@return mixed``

