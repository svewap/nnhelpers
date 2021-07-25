
.. include:: ../Includes.txt

.. _Registry:

============
Registry
============

\\nn\\t3::Registry()
---------------

Helpful methods to register extension components like plugins,
Backend Modules, FlexForms etc.

Overview of Methods
~~~~~~~~~~~~~~~~

\\nn\\t3::Registry()->plugin(``$vendorName = '', $pluginName = '', $title = '', $icon = ''``);
""""""""""""""""

Register a plugin to select – using the ``CType`` dropdown in the backend.
In ``Configuration/TCA/Overrides/tt_content.php`` use – or ``ext_tables.php`` (deprecated).

.. code-block:: php

	\nn\t3::Registry()->plugin( 'nncalendar', 'nncalendar', 'Calendar', 'EXT:path/to/icon.svg' );
	\nn\t3::Registry()->plugin( 'Nng\Nncalendar', 'nncalendar', 'Calendar', 'EXT:path/to/icon.svg' );

| ``@return void``

\\nn\\t3::Registry()->flexform(``$vendorName = '', $pluginName = '', $path = ''``);
""""""""""""""""

Register a flexform for a plugin.

.. code-block:: php

	\nn\t3::Registry()->flexform( 'nncalendar', 'nncalendar', 'FILE:EXT:nnsite/Configuration/FlexForm/flexform.xml' );
	\nn\t3::Registry()->flexform( 'Nng\Nncalendar', 'nncalendar', 'FILE:EXT:nnsite/Configuration/FlexForm/flexform.xml' );

| ``@return void``

\\nn\\t3::Registry()->getVendorExtensionName(``$combinedVendorPluginName = ''``);
""""""""""""""""

Generate plugin name.
Depending on Typo3 version, the plugin name will be returned with or without vendor.

.. code-block:: php

	 \nn\t3::Registry()->getVendorExtensionName( 'nncalendar' ); // => Nng.Nncalendar
	    \nn\t3::Registry()->getVendorExtensionName( 'Nng\Nncalendar' ); // => Nng.Nncalendar

| ``@return string``

\\nn\\t3::Registry()->parseControllerActions(``$controllerActionList = []``);
""""""""""""""""

Parse list with ``'ControllerName' => 'action,list,show'``
Always specify the full class path in ``::class`` notation.
Take into account that before Typo3 10, only the simple class name (e.g. ``Main``)
is used as the key.

.. code-block:: php

	\nn\t3::Registry()->parseControllerActions(
	    [\Nng\ExtName\Controller\MainController::class => 'index,list'],
	);

| ``@return array``

\\nn\\t3::Registry()->configurePlugin(``$vendorName = '', $pluginName = '', $cacheableActions = [], $uncacheableActions = []``);
""""""""""""""""

Configuring a plugin.
Use in ``ext_localconf.php``.

.. code-block:: php

	\nn\t3::Registry()->configurePlugin( 'Nng\Nncalendar', 'Nncalendar',
	    [\Nng\ExtName\Controller\MainController::class => 'index,list'],
	    [\Nng\ExtName\Controller\MainController::class => 'show']
	);

| ``@return void``

\\nn\\t3::Registry()->rootLineFields(``$fields = [], $translate = true``);
""""""""""""""""

Register a field in the pages table to be inherited/slided to subpages.
In the ``ext_localconf.php`` register:

.. code-block:: php

	\nn\t3::Registry()->rootLineFields(['slidefield']);
	\nn\t3::Registry()->rootLineFields('slidefield');

Typoscript setup:

.. code-block:: php

	page.10 = FLUIDTEMPLATE
	page.10.variables {
	    footer = TEXT
	    footer {
	        data = levelfield:-1, footerelement, slide
	    }
	}

| ``@return void``

\\nn\\t3::Registry()->fluidNamespace(``$referenceNames = [], $namespaces = []``);
""""""""""""""""

Register global namespace for fluid.
Mostly used in ``ext_localconf.php``.

.. code-block:: php

	\nn\t3::Registry()->fluidNamespace( 'nn', 'Nng\Nnsite\ViewHelpers' );
	\nn\t3::Registry()->fluidNamespace( ['nn', 'nng'], 'Nng\Nnsite\ViewHelpers' );
	\nn\t3::Registry()->fluidNamespace( ['nn', 'nng'], ['Nng\Nnsite\ViewHelpers', 'Other\Namespace\Fallback'] );

| ``@return void``

\\nn\\t3::Registry()->icon(``$identifier = '', $path = ''``);
""""""""""""""""

Register an icon. Classically used in ext_tables.php.

.. code-block:: php

	\nn\t3::Registry()->icon('nncalendar-plugin', 'EXT:myextname/Resources/Public/Icons/wizicon.svg');

| ``@return void``

\\nn\\t3::Registry()->get(``$extName = '', $path = ''``);
""""""""""""""""

Get a value from the sys_registry table.

.. code-block:: php

	\nn\t3::Registry()->get( 'nnsite', 'lastRun' );

| ``@return void``

\\nn\\t3::Registry()->set(``$extName = '', $path = '', $settings = []``);
""""""""""""""""

Save a value in the sys_registry table.
Data in this table is retained übeyond the session.
For example, a scheduler job can store the last time it was executed.
it was executed.

.. code-block:: php

	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['test'=>'ok'] );

| ``@return void``

\\nn\\t3::Registry()->addPageConfig(``$str = ''``);
""""""""""""""""

addPageConfig

.. code-block:: php

	\nn\t3::Registry()->addPageConfig( 'test.was = 10' );
	\nn\t3::Registry()->addPageConfig( '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:extname/Configuration/TypoScript/page.txt">' );
	\nn\t3::Settings()->addPageConfig( '@import "EXT:extname/Configuration/TypoScript/page.ts"' );

| ``@return void``

