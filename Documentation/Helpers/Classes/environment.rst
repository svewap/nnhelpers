
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

\\nn\\t3::Environment()->getLanguageKey();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the current language (as an abbreviation like "de") in the frontend

.. code-block:: php

	\nn\t3::Environment()->getLanguageKey();

| ``@return string``

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

