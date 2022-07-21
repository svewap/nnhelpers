
.. include:: ../../Includes.txt

.. _Environment:

==============================================
Environment
==============================================

\\nn\\t3::Environment()
----------------------------------------------

Everything you need to know üabout the environment of the application.
From language ID of the user, the baseUrl to what extensions are at the start.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Environment()->extLoaded(``$extName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Check if extension is loaded

.. code-block:: php

	\nn\t3::Environment()->extLoaded('news');

\\nn\\t3::Environment()->extPath(``$extName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

get absolute path to an extension.
e.g. ``/var/www/website/ext/nnsite/``

.. code-block:: php

	\nn\t3::Environment()->extPath('extname');

| ``@return string``

\\nn\\t3::Environment()->extRelPath(``$extName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

get relative path (from current script) to an extension.
e.g. ``../typo3conf/ext/nnsite/``

.. code-block:: php

	\nn\t3::Environment()->extRelPath('extname');

| ``@return string``

\\nn\\t3::Environment()->getBaseURL();
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the baseUrl (``config.baseURL``), including http(s) protocol e.g. https://www.webseite.de/

.. code-block:: php

	\nn\t3::Environment()->getBaseURL();

| ``@return string``

\\nn\\t3::Environment()->getCookieDomain(``$loginType = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the cookie domain e.g. www.webseite.de

.. code-block:: php

	\nn\t3::Environment()->getCookieDomain()

| ``@return string``

\\nn\\t3::Environment()->getCountries(``$lang = 'de', $key = 'cn_iso_2'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get all available countries in the system

.. code-block:: php

	\nn\t3::Environment()->getCountries();

| ``@return array``

\\nn\\t3::Environment()->getCountryByIsocode(``$cn_iso_2 = NULL, $field = 'cn_iso_2'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get a country from the ``static_countries`` table.
by its country code (e.g. ``DE``)

.. code-block:: php

	\nn\t3::Environment()->getCountryByIsocode( 'DE' );
	\nn\t3::Environment()->getCountryByIsocode( 'DEU', 'cn_iso_3' );

| ``@return array``

\\nn\\t3::Environment()->getDefaultLanguage(``$returnKey = 'typo3Language'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the default language. In TYPO3 this is always the language with ID ``0``
The languages must be set in the YAML site configuration.

.. code-block:: php

	// 'en'
	\nn\t3::Environment()->getDefaultLanguage();
	
	// 'de-DE'
	\nn\t3::Environment()->getDefaultLanguage('hreflang');
	
	// ['title'=>'German', 'typo3Language'=>'de', ...]
	\nn\t3::Environment()->getDefaultLanguage( true );

| ``@param string|boolean $returnKey``
| ``@return string|array``

\\nn\\t3::Environment()->getDomain();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the domain e.g. www.webseite.de

.. code-block:: php

	\nn\t3::Environment()->getDomain();

| ``@return string``

\\nn\\t3::Environment()->getExtConf(``$ext = 'nnhelpers', $param = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get configuration from ``ext_conf_template.txt`` (backend, extension configuration)

.. code-block:: php

	\nn\t3::Environment()->getExtConf('nnhelpers', 'varname');

Also acts as a ViewHelper:

.. code-block:: php

	{nnt3:ts.extConf(path:'nnhelper')}
	{nnt3:ts.extConf(path:'nnhelper.varname')}
	{nnt3:ts.extConf(path:'nnhelper', key:'varname')}

| ``@return mixed``

\\nn\\t3::Environment()->getLanguage();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the current language (as a number) of the frontend.

.. code-block:: php

	\nn\t3::Environment()->getLanguage();

| ``@return int``

\\nn\\t3::Environment()->getLanguageFallbackChain(``$langUid = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns a list of languages to be used if, for example, a page or an element
e.g. a page or element does not exist in the desired language.

Important: The fallback chain will contain the current language or the language passed in $langUid
in the first position.
 Important: The fallback chain contains the current language in the first position.

.. code-block:: php

	// Use settings for current language (see Site-Config YAML).
	\nn\t3::Environment()->getLanguageFallbackChain(); // --> e.g. [0] or [1,0]
	
	// get settings for a specific language
	\nn\t3::Environment()->getLanguageFallbackChain( 1 );
	// --> [1,0] - if fallback is defined in site config and fallbackMode is set to "fallback".
	// --> [1] - if there is no fallback or the fallbackMode is set to "strict"

| ``@param string|boolean $returnKey``
| ``@return string|array``

\\nn\\t3::Environment()->getLanguageKey();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the current language (as an abbreviation like "de") in the frontend

.. code-block:: php

	\nn\t3::Environment()->getLanguageKey();

| ``@return string``

\\nn\\t3::Environment()->getLanguages(``$key = 'languageId', $value = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns a list of all defined languages.
The languages must be defined in the YAML site configuration.

.. code-block:: php

	// [['title'=>'German', 'typo3Language'=>'de', ....], ['title'=>'English', 'typo3Language'=>'en', ...]]
	\nn\t3::Environment()->getLanguages();
	
	// ['de'=>['title'=>'German', 'typo3Language'=>'de'], 'en'=>['title'=>'English', 'typo3Language'=>'en', ...]]
	\nn\t3::Environment()->getLanguages('iso-639-1');
	
	// ['de'=>0, 'en'=>1]
	\nn\t3::Environment()->getLanguages('typo3Language', 'languageId');
	
	// [0=>'de', 1=>'en']
	\nn\t3::Environment()->getLanguages('languageId', 'typo3Language');

| ``@param string $key``
| ``@param string $value``
| ``@return string|array``

\\nn\\t3::Environment()->getLocalConf(``$path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get configuration from ``LocalConfiguration.php``

.. code-block:: php

	\nn\t3::Environment()->getLocalConf('FE.cookieName');

| ``@return string``

\\nn\\t3::Environment()->getPathSite();
"""""""""""""""""""""""""""""""""""""""""""""""

Get absolute path to Typo3 root directory. e.g. ``/var/www/website/``

.. code-block:: php

	\nn\t3::Environment()->getPathSite()

früher: ``PATH_site``

\\nn\\t3::Environment()->getPostMaxSize();
"""""""""""""""""""""""""""""""""""""""""""""""

Return maximum upload size for files from the frontend.
This specification is the value set in php.ini and if necessary.
üvia the .htaccess überschrieben.

.. code-block:: php

	\nn\t3::Environment()->getPostMaxSize(); // e.g. '1048576' at 1MB

| ``@return integer``

\\nn\\t3::Environment()->getPsr4Prefixes();
"""""""""""""""""""""""""""""""""""""""""""""""

Return the list of PSR4 prefixes

This is an array with all the folders that need to be parsed by classes when TYPO3 autoloads / bootstraps.
by classes during the autoloading / bootstrap process. In a TYPO3 extension this is by default the folder ``Classes``
The list is generated by Composer/TYPO3.

The returned value is an array. Key is ``Vendor\Namespace\``, value is an array with paths to the folders,
which will be searched recursively for classes. It doesn't matter if TYPO3 is running in composer mode or not.
mode or not.

.. code-block:: php

	\nn\t3::Environment()->getPsr4Prefixes();

Example return:

.. code-block:: php

	[
	    'Nng\Nnhelpers\' => ['/path/to/composer/../../public/typo3conf/ext/nnhelpers/Classes', ...],
	    'Nng\Nnrestapi\' => ['/path/to/composer/../../public/typo3conf/ext/nnrestapi/Classes', ...]
	]

| ``@return array``

\\nn\\t3::Environment()->getRelPathSite();
"""""""""""""""""""""""""""""""""""""""""""""""

Get relative path to Typo3 root directory. e.g. ``../``

.. code-block:: php

	\nn\t3::Environment()->getRelPathSite()

| ``@return string``

\\nn\\t3::Environment()->getSite(``$request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the current ``site`` object.
This object can be used to access the configuration from the site YAML file, e.g. as of TYPO3 9.

In the context of a MiddleWare, the ``site`` may not yet be parsed / loaded.
In this case, the ``$request`` can be passed from the MiddleWare üto determine the site.

See also ``\nn\t3::Settings()->getSiteConfig()`` to read the site configuration.

.. code-block:: php

	\nn\t3::Environment()->getSite();
	\nn\t3::Environment()->getSite( $request );
	
	\nn\t3::Environment()->getSite()->getConfiguration();
	\nn\t3::Environment()->getSite()->getIdentifier();

| ``@return \TYPO3\CMS\Core\Site\Entity\Site``

\\nn\\t3::Environment()->getVarPath();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the absolute path to the ``/var`` directory of Typo3.

This directory stores temporäre cache files.
Depending on the version of Typo3 and the type of installation (composer or non-composer mode)
this directory can be found in different locations.

.. code-block:: php

	// /full/path/to/typo3temp/var/
	$path = \nn\t3::Environment()->getVarPath();

\\nn\\t3::Environment()->isBackend();
"""""""""""""""""""""""""""""""""""""""""""""""

Check if we are in the backend context

.. code-block:: php

	 \nn\t3::Environment()->isBackend();

| ``@return bool``

\\nn\\t3::Environment()->isFrontend();
"""""""""""""""""""""""""""""""""""""""""""""""

Check if we are in the frontend context

.. code-block:: php

	 \nn\t3::Environment()->isFrontend();

| ``@return bool``

\\nn\\t3::Environment()->isLocalhost();
"""""""""""""""""""""""""""""""""""""""""""""""

Check if installation is running on local server

.. code-block:: php

	\nn\t3::Environment()->isLocalhost()

| ``@return boolean``

\\nn\\t3::Environment()->t3Version();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the version of Typo3, as an integer, e.g. "8".
Alias to ``\nn\t3::t3Version()``

.. code-block:: php

	\nn\t3::Environment()->t3Version();
	
	if (\nn\t3::t3Version() >= 8) {
	    // only for >= Typo3 8 LTS
	}

| ``@return int``

