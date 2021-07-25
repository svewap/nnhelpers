
.. include:: ../Includes.txt

.. _FrontendUser:

============
FrontendUser
============

\\nn\\t3::FrontendUser()
---------------

Overview of Methods
~~~~~~~~~~~~~~~~

\\nn\\t3::FrontendUser()->get();
""""""""""""""""

Get the current FE user.
Alias to ``\nn\t3::FrontendUser()->getCurrentUser();``

.. code-block:: php

	\nn\t3::FrontendUser()->get();

Also acts as a ViewHelper:

.. code-block:: php

	{nnt3:frontendUser.get(key:'first_name')}
	{nnt3:frontendUser.get()->f:variable.set(name:'feUser')}

| ``@return User``

\\nn\\t3::FrontendUser()->getCurrentUser();
""""""""""""""""

Get user group of current FE user;

.. code-block:: php

	\nn\t3::FrontendUser()->getCurrentUser();

| ``@return User``

\\nn\\t3::FrontendUser()->getCurrentUserGroups(``$returnRowData = false``);
""""""""""""""""

.. code-block:: php

	\nn\t3::FrontendUser()->getCurrentUserGroups(); => [1 => ['title'=>'Group A', 'uid' => 1]]
	\nn\t3::FrontendUser()->getCurrentUserGroups( true ); => [1 => [... all fields of the DB] ]

| ``@return array``

\\nn\\t3::FrontendUser()->isInUserGroup(``$feGroups = NULL``);
""""""""""""""""

Prüft whether the current fe-user is within a specified user group.

.. code-block:: php

	\nn\t3::FrontendUser()->isInUserGroup( 1 );
	\nn\t3::FrontendUser()->isInUserGroup( ObjectStorage<FrontendUserGroup> );
	\nn\t3::FrontendUser()->isInUserGroup( [FrontendUserGroup, FrontendUserGroup, ...] );
	\nn\t3::FrontendUser()->isInUserGroup( [['uid'=>1, ...], ['uid'=>2, ...]] );

| ``@return boolean``

\\nn\\t3::FrontendUser()->getAvailableUserGroups();
""""""""""""""""

return all existing user groups

| ``@return array``

\\nn\\t3::FrontendUser()->isLoggedIn();
""""""""""""""""

Check if the user is logged in.
before: isset($GLOBALS['TSFE']) && $GLOBALS['TSFE']->loginUser
| ``@return bool``

\\nn\\t3::FrontendUser()->getCurrentUserUid();
""""""""""""""""

Get the UID of the current frontend user.
| ``@return int``

\\nn\\t3::FrontendUser()->getSessionId();
""""""""""""""""

Get the session ID of the current frontend user.
| ``@return string``

\\nn\\t3::FrontendUser()->getLanguage();
""""""""""""""""

Get language uid of current user
| ``@return int``

\\nn\\t3::FrontendUser()->hasRole(``$roleUid``);
""""""""""""""""

Check if the logged in user has a specific role
| ``@param $role``
| ``@return bool``

\\nn\\t3::FrontendUser()->login(``$username, $password = NULL``);
""""""""""""""""

Logging in user manually.
As of v10: alias to ``\nn\t3::FrontendUserAuthentication()->loginByUsername( $username );``

.. code-block:: php

	\nn\t3::FrontendUser()->login('99grad');
	\nn\t3::FrontendUser()->login('99degrees', 'password');

| ``@param $username``
| ``@param $password``
@throws \ReflectionException

\\nn\\t3::FrontendUser()->logout();
""""""""""""""""

Manually log out current FE-USer.
| ``@return void``

\\nn\\t3::FrontendUser()->setPassword(``$feUserUid = NULL, $password = NULL``);
""""""""""""""""

Change the password of a FE user.
Alias to ``\nn\t3::FrontendUserAuthentication()->setPassword()``.

.. code-block:: php

	\nn\t3::FrontendUser()->setPassword( 12, '123password$#' );
	\nn\t3::FrontendUser()->setPassword( $frontendUserModel, '123password#$' );

| ``@return boolean``

\\nn\\t3::FrontendUser()->removeCookie();
""""""""""""""""

Manually delete the current fe_typo_user cookie

.. code-block:: php

	\nn\t3::FrontendUser()->removeCookie()

| ``@return void``

\\nn\\t3::FrontendUser()->getSessionData(``$key = NULL``);
""""""""""""""""

Get session data for FE users

.. code-block:: php

	\nn\t3::FrontendUser()->getSessionData('shop')

| ``@return mixed``

\\nn\\t3::FrontendUser()->setSessionData(``$key = NULL, $val = NULL, $merge = true``);
""""""""""""""""

Set session-data for FE-user

.. code-block:: php

	// Merge session-data for `shop` with new data (already existing keys in `shop` will not be deleted).
	\nn\t3::FrontendUser()->setSessionData('shop', ['a'=>1]));
	
	// overwrite session-data for `shop` (`a` from the example above will be deleted)
	\nn\t3::FrontendUser()->setSessionData('shop', ['b'=>1], false));

| ``@return mixed``

