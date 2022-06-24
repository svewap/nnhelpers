
.. include:: ../../Includes.txt

.. _Settings:

==============================================
Settings
==============================================

\\nn\\t3::Settings()
----------------------------------------------

Methods to simplify access to TypoScript setup, constants, and PageTsConfig.
simplify.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Settings()->addPageConfig(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

addPageConfig.
Alias to ``\nn\t3::Registry()->addPageConfig( $str );``

.. code-block:: php

	\nn\t3::Settings()->addPageConfig( 'test.was = 10' );
	\nn\t3::Settings()->addPageConfig( '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:extname/Configuration/TypoScript/page.txt">' );
	\nn\t3::Settings()->addPageConfig( '@import "EXT:extname/Configuration/TypoScript/page.ts"' );

| ``@return void``

\\nn\\t3::Settings()->get(``$extensionName = '', $path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets the TypoScript setup and there the "settings" section.
Values from the FlexForm will not be remembered in the process.
Alias to ``\nn\t3::Settings()->getSettings()``.

.. code-block:: php

	\nn\t3::Settings()->get( 'nnsite' );
	\nn\t3::Settings()->get( 'nnsite', 'path.in.settings' );

| ``@return array``

\\nn\\t3::Settings()->getConstants(``$tsPath = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get array of TypoScript constants.

.. code-block:: php

	\nn\t3::Settings()->getConstants();
	\nn\t3::Settings()->getConstants('path.to.constant');

Also acts as a ViewHelper:

.. code-block:: php

	{nnt3:ts.constants(path:'path.to.constant')}

| ``@return array``

\\nn\\t3::Settings()->getExtConf(``$extName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get Extension Configuration.
Coming from the ``LocalConfiguration.php``, are üdefined via the extension settings
defined in the backend or ext_conf_template.txt

Früher: ``$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['your_extension_key']``

.. code-block:: php

	\nn\t3::Settings()->getExtConf( 'extname' );

| ``@return mixed``

\\nn\\t3::Settings()->getFromPath(``$tsPath = '', $setup = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get setup from a given path, e.g. 'plugin.tx_example.settings'

.. code-block:: php

	\nn\t3::Settings()->getFromPath('plugin.path');
	\nn\t3::Settings()->getFromPath('L', \nn\t3::Request()->GP());
	\nn\t3::Settings()->getFromPath('a.b', ['a'=>['b'=>1]]);

Also acts as a ViewHelper:

.. code-block:: php

	{nnt3:ts.setup(path:'path.zur.setup')}

| ``@return array``

\\nn\\t3::Settings()->getFullTyposcript(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the complete TypoScript setup, as a simple array - without "." syntax.
Works in both frontend and backend, with and without übergebener pid

.. code-block:: php

	\nn\t3::Settings()->getFullTyposcript();
	\nn\t3::Settings()->getFullTyposcript( $pid );

| ``@return array``

\\nn\\t3::Settings()->getMergedSettings(``$extensionName = NULL, $ttContentUidOrSetupArray = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get merge from TypoScript setup für a plugin and its flexform.
Returns the TypoScript array ``plugin.tx_extname.settings``... 

Important: specify $extensionName only if the setup of a FREMEND extension is to be
should be fetched or there is no controller context, because the
Call is made from the backend... otherwise the FlexForm values will not be taken into account!

In the FlexForm use ``<settings.flexform.varName>``!
| ``<settings.flexform.varName>`` üthen overwrite ``settings.varName`` in the TypoScript setup

| ``$ttContentUidOrSetupArray`` can be uid of a ``tt_content`` content element.
or a simple array to üoverwrite the values from the TypoScript / FlexForm

.. code-block:: php

	\nn\t3::Settings()->getMergedSettings();
	\nn\t3::Settings()->getMergedSettings( 'nnsite' );
	\nn\t3::Settings()->getMergedSettings( $extensionName, $ttContentUidOrSetupArray );

| ``@return array``

\\nn\\t3::Settings()->getPageConfig(``$tsPath = '', $pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

GetPageConfig

.. code-block:: php

	\nn\t3::Settings()->getPageConfig();
	\nn\t3::Settings()->getPageConfig('RTE.default.preset');
	\nn\t3::Settings()->getPageConfig( $tsPath, $pid );

Also acts as a ViewHelper:

.. code-block:: php

	{nnt3:ts.page(path:'path.zur.pageconfig')}

| ``@return array``

\\nn\\t3::Settings()->getPlugin(``$extName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the setup for a specific plugin.

.. code-block:: php

	\nn\t3::Settings()->getPlugin('extname') returns TypoScript from plugin.tx_extname...

Important: specify $extensionName only if the setup of a FREME extension
should be fetched or there is no controller context because the call is made e.g.
is made from the backend

| ``@return array``

\\nn\\t3::Settings()->getSettings(``$extensionName = '', $path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the TypoScript setup and there the "settings" section.
Values from the FlexForm will not be remembered.

.. code-block:: php

	\nn\t3::Settings()->getSettings( 'nnsite' );
	\nn\t3::Settings()->getSettings( 'nnsite', 'example.path' );

| ``@return array``

\\nn\\t3::Settings()->getSiteConfig(``$request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get site configuration.
This is the configuration defined in the YAML files in the ``/sites`` folder as of TYPO3 9.
Some of the settings are also üadjustable via the "Sites" page module.

In the context of a MiddleWare, the ``site`` may not yet be parsed/loaded.
In this case, the ``$request`` from the MiddleWare can be übergeben to determine the site.

.. code-block:: php

	$config = \nn\t3::Settings()->getSiteConfig();
	$config = \nn\t3::Settings()->getSiteConfig( $request );

| ``@return array``

\\nn\\t3::Settings()->getStoragePid(``$extName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get current (FIRST) StoragePid for the current plugin.
Stored in the extension's TypoScript setup under.
| ``plugin.tx_extname.persistence.storagePid`` or in the
FlexForm of the plugin on the respective page.

IMPORTANT: Merge with selected StoragePID from the FlexForm.
only happens if ``$extName`` is left blank.

.. code-block:: php

	\nn\t3::Settings()->getStoragePid(); // 123
	\nn\t3::Settings()->getStoragePid('nnsite'); // 466

| ``@return string``

\\nn\\t3::Settings()->getStoragePids(``$extName = NULL, $recursive = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get ALL storagePids for the current plugin.
Stored as a comma-separated list in the extension's TypoScript setup at.
| ``plugin.tx_extname.persistence.storagePid`` or in the
FlexForm of the plugin on the respective page.

IMPORTANT: Merge with selected StoragePID from the FlexForm.
only happens if ``$extName`` is left blank.

.. code-block:: php

	\nn\t3::Settings()->getStoragePids(); // [123, 466]
	\nn\t3::Settings()->getStoragePids('nnsite'); // [123, 466]

Get the child pageUids too?
| ``true`` takes the value für "Recursive" from the FlexForm or from the
TypoScript of the extension from ``plugin.tx_extname.persistence.recursive``

.. code-block:: php

	 \nn\t3::Settings()->getStoragePids(true); // [123, 466, 124, 467, 468]
	\nnnnt3::Settings()->getStoragePids('nnsite', true); // [123, 466, 124, 467, 468]

Alternatively, a numeric value can be passed for the depth / recursion.

.. code-block:: php

	\nn\t3::Settings()->getStoragePids(2); // [123, 466, 124, 467, 468]
	\nnnnt3::Settings()->getStoragePids('nnsite', 2); // [123, 466, 124, 467, 468]

| ``@return array``

\\nn\\t3::Settings()->getTyposcriptObject(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Instantiate TemplateService, parse TypoScript config and setup.
Internal function – not intended to be used.
Use ``getFullTyposcript``.

| ``@return object``
.

\\nn\\t3::Settings()->setExtConf(``$extName = '', $key = '', $value = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Write Extension Configuration.
Writes an extension configuration to ``LocalConfiguration.php``. The values can be used with an
the values can be edited in the ``ext_conf_template.txt`` via the extension manager / extension configuration in the backend.
Extension Configuration in the backend.

.. code-block:: php

	\nn\t3::Settings()->setExtConf( 'extname', 'key', 'value' );

| ``@return mixed``

