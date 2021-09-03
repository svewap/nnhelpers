
.. include:: ../../Includes.txt

.. _BackendUser:

==============================================
BackendUser
==============================================

\\nn\\t3::BackendUser()
----------------------------------------------

Methods to check in the frontend if a user is logged in to the Typo3 backend and has e.g. admin rights.
Methods to start a backend user if it does not exist (e.g. during a scheduler job).

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::BackendUser()->get();
"""""""""""""""""""""""""""""""""""""""""""""""

Gets the current backend user.
Corresponds to ``$GLOBALS['BE_USER']`` in earlier Typo3 versions.

.. code-block:: php

	\nn\t3::BackendUser()->get();

| ``@return \TYPO3\CMS\Backend\FrontendBackendUserAuthentication``

\\nn\\t3::BackendUser()->getSettings(``$moduleName = 'nnhelpers', $path = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets user-specific settings for the currently logged-in backend user.
See ``\nn\t3::BackendUser()->updateSettings()`` to save the data.

.. code-block:: php

	\nn\t3::BackendUser()->getSettings('myext'); // => ['wants'=>['drink'=>'coffee']]
	\nn\t3::BackendUser()->getSettings('myext', 'wants'); // => ['drink'=>'coffee']
	\nn\t3::BackendUser()->getSettings('myext', 'wants.drink'); // => 'coffee'

| ``@return mixed``

\\nn\\t3::BackendUser()->isAdmin();
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft whether the BE user is an admin.
Earlier: ``$GLOBALS['TSFE']->beUserLogin``

.. code-block:: php

	\nn\t3::BackendUser()->isAdmin();

| ``@return bool``

\\nn\\t3::BackendUser()->isLoggedIn();
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft whether a BE user is logged in.
Example: Show certain content in the frontend only if the user is logged in in the backend.
Früher: ``$GLOBALS['TSFE']->beUserLogin``

.. code-block:: php

	\nn\t3::BackendUser()->isLoggedIn();

| ``@return bool``

\\nn\\t3::BackendUser()->start();
"""""""""""""""""""""""""""""""""""""""""""""""

Start (fake) backend user.
Solves the problem that, for example, from the scheduler certain functions
like ``log()`` are not possible if there is no active BE user.

.. code-block:: php

	\nn\t3::BackendUser()->start();

| ``@return \TYPO3\CMS\Backend\FrontendBackendUserAuthentication``

\\nn\\t3::BackendUser()->updateSettings(``$moduleName = 'nnhelpers', $settings = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Saves user-specific settings for the currently logged in backend user.
These settings are also available to the user after logout/login.
See ``nn\t3::BackendUser()->getSettings('myext')`` to read out the data.

.. code-block:: php

	\nn\t3::BackendUser()->updateSettings('myext', ['wants'=>['drink'=>'coffee']]);

| ``@return array``

