
.. include:: ../../Includes.txt

.. _Page:

==============================================
Page
==============================================

\\nn\\t3::Page()
----------------------------------------------

All about the ``pages`` table.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Page()->addCssFile(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Insert CSS file into <head>.
See ``\nn\t3::Page()->addHeader()`` for simpler version.

.. code-block:: php

	\nn\t3::Page()->addCss( 'path/to/style.css' );

| ``@return void``

\\nn\\t3::Page()->addCssLibrary(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

insert CSS library into <head>

.. code-block:: php

	\nn\t3::Page()->addCssLibrary( 'path/to/style.css' );

| ``@return void``

\\nn\\t3::Page()->addFooter(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Append CSS or JS or HTML code to footer.
Decide for yourself which method of PageRender to use.

.. code-block:: php

	\nn\t3::Page()->addFooter( 'fileadmin/style.css' );
	\nn\t3::Page()->addFooter( ['fileadmin/style.css', 'js/script.js'] );
	\nn\t3::Page()->addFooter( 'js/script.js' );
	\nn\t3::Page()->addFooter( '<script>....</script>' );

| ``@return void``

\\nn\\t3::Page()->addFooterData(``$html = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Insert HTML code before end of <body>.
See ``\nn\t3::Page()->addFooter()`` for simpler version.

.. code-block:: php

	\nn\t3::Page()->addFooterData( '<script src="..."></script>' );

| ``@return void``

\\nn\\t3::Page()->addHeader(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Append CSS or JS or HTML code to footer.
Decide for yourself which method of PageRender to use.

.. code-block:: php

	\nn\t3::Page()->addHeader( 'fileadmin/style.css' );
	\nn\t3::Page()->addHeader( ['fileadmin/style.css', 'js/script.js'] );
	\nn\t3::Page()->addHeader( 'js/script.js' );
	\nn\t3::Page()->addHeader( '<script>....</script>' );

| ``@return void``

\\nn\\t3::Page()->addHeaderData(``$html = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sneak HTML code into <head>.
See ``\nn\t3::Page()->addHeader()`` for simpler version.

.. code-block:: php

	\nn\t3::Page()->addHeaderData( '<script src="..."></script>' );

| ``@return void``

\\nn\\t3::Page()->addJsFile(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sneak JS file into <head>.
See ``\nn\t3::Page()->addHeader()`` for simpler version.

.. code-block:: php

	\nn\t3::Page()->addJsFile( 'path/to/file.js' );

| ``@return void``

\\nn\\t3::Page()->addJsFooterFile(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Insert JS file at the end of the <body>.
See ``\nn\t3::Page()->addJsFooterFile()`` for simpler version.

.. code-block:: php

	\nn\t3::Page()->addJsFooterFile( 'path/to/file.js' );

| ``@return void``

\\nn\\t3::Page()->addJsFooterLibrary(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Insert JS library at the end of <body>

.. code-block:: php

	\nn\t3::Page()->addJsFooterLibrary( 'path/to/file.js' );

| ``@return void``

\\nn\\t3::Page()->addJsLibrary(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Insert JS library into <head> 

.. code-block:: php

	\nn\t3::Page()->addJsLibrary( 'path/to/file.js' );

| ``@return void``

\\nn\\t3::Page()->clearCache(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Clear page cache of one (or more) pages

.. code-block:: php

	\nn\t3::Page()->clearCache( $pid );
	\nn\t3::Page()->clearCache( [1,2,3] );
	\nn\t3::Page()->clearCache();

| ``@return void``

\\nn\\t3::Page()->get(``$uid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get data of a page (from table "pages")

.. code-block:: php

	\nn\t3::Page()->get( $uid );

| ``@return array``

\\nn\\t3::Page()->getAbsLink(``$pidOrParams = NULL, $params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Generate an absolute link to a page

.. code-block:: php

	\nn\t3::Page()->getAbsLink( $pid );
	\nn\t3::Page()->getAbsLink( $pid, ['type'=>'232322'] );
	\nn\t3::Page()->getAbsLink( ['type'=>'232322'] );

| ``@return string``

\\nn\\t3::Page()->getActionLink(``$pid = NULL, $extensionName = '', $pluginName = '', $controllerName = '', $actionName = '', $params = [], $absolute = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get link to an action/controller

.. code-block:: php

	\nn\t3::Page()->getActionLink( $pid, $extName, $pluginName, $controllerName, $actionName, $args );

Example for the news extension:

.. code-block:: php

	$newsArticleUid = 45;
	$newsDetailPid = 123;
	\nn\t3::Page()->getActionLink( $newsDetailPid, 'news', 'pi1', 'News', 'detail', ['news'=>$newsArticleUid]);

| ``@return string``

\\nn\\t3::Page()->getChildPids(``$parentPid = [], $recursive = 999``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get list of child uids of one or more pages.

.. code-block:: php

	\nn\t3::Page()->getChildPids( 123, 1 );
	\nn\t3::Page()->getChildPids( [123, 124], 99 );

| ``@return array``

\\nn\\t3::Page()->getData(``$pids = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get data of a page (table ``pages``).

.. code-block:: php

	// data of the current page.
	\nn\t3::Page()->getData();
	
	// get data of the page with pid = 123
	\nn\t3::Page()->getData( 123 );
	
	// get data of the pages with pids = 123 and 456. Key of the array = pid
	\nn\t3::Page()->getData( [123, 456] );

| ``@return array``

\\nn\\t3::Page()->getField(``$key, $slide = false, $override = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get single field from page-data.
The value can be inherited from üparent pages via ``slide = true``.

(!) Important:
Custom fields must be defined as rootLine in ``ext_localconf.php``!
See also ``\nn\t3::Registry()->rootLineFields(['key', '...']);``

.. code-block:: php

	\nn\t3::Page()->getField('layout');
	\nn\t3::Page()->getField('backend_layout_next_level', true, 'backend_layout');

Exisits also as ViewHelper:

.. code-block:: php

	{nnt3:page.data(key:'uid')}
	{nnt3:page.data(key:'media', slide:1)}
	{nnt3:page.data(key:'backend_layout_next_level', slide:1, override:'backend_layout')}

| ``@return mixed``

\\nn\\t3::Page()->getLink(``$pidOrParams = NULL, $params = [], $absolute = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Generate a simple link to a page in the frontend.

Works in any context - both from a backend module or scheduler/CLI job, and in the frontend context, e.g. in the controller or a ViewHelper.
Absolute URLs are generated from the backend context into the frontend. The URLs are encoded as readable URLs - the slug path or RealURL are taken into account.

.. code-block:: php

	\nn\t3::Page()->getLink( $pid );
	\nn\t3::Page()->getLink( $pid, $params );
	\nn\t3::Page()->getLink( $params );
	\nn\t3::Page()->getLink( $pid, true );
	\nn\t3::Page()->getLink( $pid, $params, true );
	\nn\t3::Page()->getLink( 'david@99grad.de' )

Example of generating a link to a controller:

Tip: see also ``getActionLink()`` for a short version!

.. code-block:: php

	$newsDetailPid = 123;
	$newsArticleUid = 45;
	
	$link = \nn\t3::Page()->getLink($newsDetailPid, [
	    'tx_news_pi1' => [
	        'action' => 'detail',
	        'controller' => 'news',
	        'news' => $newsArticleUid,
	    ]
	]);

| ``@return string``

\\nn\\t3::Page()->getPageRenderer();
"""""""""""""""""""""""""""""""""""""""""""""""

GetPageRenderer

.. code-block:: php

	\nn\t3::Page()->getPageRenderer();

| ``@return PageRenderer``

\\nn\\t3::Page()->getPid(``$fallback = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the current page's PID.
In the frontend: the current ``TSFE->id``
In the backend: the page that was selected in the page tree.
Without context: the pid of the site root

.. code-block:: php

	\nn\t3::Page()->getPid();
	\nn\t3::Page()->getPid( $fallbackPid );

| ``@return int``

\\nn\\t3::Page()->getPidFromRequest();
"""""""""""""""""""""""""""""""""""""""""""""""

Get PID from request string, e.g. in backend modules.
Hacky. ToDo: check if there is a better method.

.. code-block:: php

	\nn\t3::Page()->getPidFromRequest();

| ``@return int``

\\nn\\t3::Page()->getRootline(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

GetRootline for given PID

.. code-block:: php

	\nn\t3::Page()->getRootline();

| ``@return array``

\\nn\\t3::Page()->getSiteRoot(``$returnAll = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the PID of the site root(s).
Corresponds to the page in the backend that has the "globe" as an icon.
(in the page properties "use as start of web page")

.. code-block:: php

	\nn\t3::Page()->getSiteRoot();

| ``@return int``

\\nn\\t3::Page()->getSubpages(``$pid = NULL, $includeHidden = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get menü for given PID

.. code-block:: php

	\nn\t3::Page()->getSubpages();
	\nn\t3::Page()->getSubpages( $pid );
	\nn\t3::Page()->getSubpages( $pid, true ); // Also fetch hidden pages

| ``@return array``

\\nn\\t3::Page()->getTitle();
"""""""""""""""""""""""""""""""""""""""""""""""

Get current page title (without suffix)

.. code-block:: php

	\nn\t3::Page()->getTitle();

| ``@return string``

\\nn\\t3::Page()->hasSubpages(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Checks whether a page has submenus

.. code-block:: php

	\nn\t3::Page()->hasSubpages();

| ``@return boolean``

\\nn\\t3::Page()->setTitle(``$title = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Change PageTitle (<title>tag).
Does not work if EXT:advancedtitle is enabled!

.. code-block:: php

	\nn\t3::Page()->setTitle('YEAH!');

Also available as a ViewHelper:

.. code-block:: php

	{nnt3:page.title(title:'Yeah')}
	{entry.title->nnt3:page.title()}

| ``@return void``

