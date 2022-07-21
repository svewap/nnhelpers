
.. include:: ../../Includes.txt

.. _Page:

==============================================
Page
==============================================

\\nn\\t3::Page()
----------------------------------------------

Alles rund um die ``pages`` Tabelle.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Page()->addCssFile(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

CSS-Datei in ``<head>`` einschleusen
Siehe ``\nn\t3::Page()->addHeader()`` für einfachere Version.

.. code-block:: php

	\nn\t3::Page()->addCss( 'path/to/style.css' );

| ``@return void``

\\nn\\t3::Page()->addCssLibrary(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

CSS-Library in ``<head>`` einschleusen

.. code-block:: php

	\nn\t3::Page()->addCssLibrary( 'path/to/style.css' );

| ``@return void``

\\nn\\t3::Page()->addFooter(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

CSS oder JS oder HTML-Code an Footer anhängen.
Entscheidet selbst, welche Methode des PageRenderes zu verwenden ist.

.. code-block:: php

	\nn\t3::Page()->addFooter( 'fileadmin/style.css' );
	\nn\t3::Page()->addFooter( ['fileadmin/style.css', 'js/script.js'] );
	\nn\t3::Page()->addFooter( 'js/script.js' );
	\nn\t3::Page()->addFooter( '<script>....</script>' );

| ``@return void``

\\nn\\t3::Page()->addFooterData(``$html = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

HTML-Code vor Ende der ``<body>`` einschleusen
Siehe ``\nn\t3::Page()->addFooter()`` für einfachere Version.

.. code-block:: php

	\nn\t3::Page()->addFooterData( '<script src="..."></script>' );

| ``@return void``

\\nn\\t3::Page()->addHeader(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

CSS oder JS oder HTML-Code an Footer anhängen.
Entscheidet selbst, welche Methode des PageRenderes zu verwenden ist.

.. code-block:: php

	\nn\t3::Page()->addHeader( 'fileadmin/style.css' );
	\nn\t3::Page()->addHeader( ['fileadmin/style.css', 'js/script.js'] );
	\nn\t3::Page()->addHeader( 'js/script.js' );
	\nn\t3::Page()->addHeader( '<script>....</script>' );

| ``@return void``

\\nn\\t3::Page()->addHeaderData(``$html = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

HTML-Code in ``<head>`` einschleusen
Siehe ``\nn\t3::Page()->addHeader()`` für einfachere Version.

.. code-block:: php

	\nn\t3::Page()->addHeaderData( '<script src="..."></script>' );

| ``@return void``

\\nn\\t3::Page()->addJsFile(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

JS-Datei in ``<head>`` einschleusen
Siehe ``\nn\t3::Page()->addHeader()`` für einfachere Version.

.. code-block:: php

	\nn\t3::Page()->addJsFile( 'path/to/file.js' );

| ``@return void``

\\nn\\t3::Page()->addJsFooterFile(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

JS-Datei am Ende der ``<body>`` einschleusen
Siehe ``\nn\t3::Page()->addJsFooterFile()`` für einfachere Version.

.. code-block:: php

	\nn\t3::Page()->addJsFooterFile( 'path/to/file.js' );

| ``@return void``

\\nn\\t3::Page()->addJsFooterLibrary(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

JS-Library am Ende der ``<body>`` einschleusen

.. code-block:: php

	\nn\t3::Page()->addJsFooterLibrary( 'path/to/file.js' );

| ``@return void``

\\nn\\t3::Page()->addJsLibrary(``$path, $compress = false, $atTop = false, $wrap = false, $concat = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

JS-Library in ``<head>`` einschleusen.

.. code-block:: php

	\nn\t3::Page()->addJsLibrary( 'path/to/file.js' );

| ``@return void``

\\nn\\t3::Page()->clearCache(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Seiten-Cache einer (oder mehrerer) Seiten löschen

.. code-block:: php

	\nn\t3::Page()->clearCache( $pid );
	\nn\t3::Page()->clearCache( [1,2,3] );
	\nn\t3::Page()->clearCache();

| ``@return void``

\\nn\\t3::Page()->get(``$uid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Daten einer Seiten holen (aus Tabelle "pages")

.. code-block:: php

	\nn\t3::Page()->get( $uid );

| ``@return array``

\\nn\\t3::Page()->getAbsLink(``$pidOrParams = NULL, $params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einen absoluten Link zu einer Seite generieren

.. code-block:: php

	\nn\t3::Page()->getAbsLink( $pid );
	\nn\t3::Page()->getAbsLink( $pid, ['type'=>'232322'] );
	\nn\t3::Page()->getAbsLink( ['type'=>'232322'] );

| ``@return string``

\\nn\\t3::Page()->getActionLink(``$pid = NULL, $extensionName = '', $pluginName = '', $controllerName = '', $actionName = '', $params = [], $absolute = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Link zu einer Action / Controller holen

.. code-block:: php

	\nn\t3::Page()->getActionLink( $pid, $extName, $pluginName, $controllerName, $actionName, $args );

Beispiel für die News-Extension:

.. code-block:: php

	$newsArticleUid = 45;
	$newsDetailPid = 123;
	\nn\t3::Page()->getActionLink( $newsDetailPid, 'news', 'pi1', 'News', 'detail', ['news'=>$newsArticleUid]);

| ``@return string``

\\nn\\t3::Page()->getChildPids(``$parentPid = [], $recursive = 999``);
"""""""""""""""""""""""""""""""""""""""""""""""

Liste der Child-Uids einer oder mehrerer Seiten holen.

.. code-block:: php

	\nn\t3::Page()->getChildPids( 123, 1 );
	\nn\t3::Page()->getChildPids( [123, 124], 99 );

| ``@return array``

\\nn\\t3::Page()->getData(``$pids = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Daten einer Seiten holen (Tabelle ``pages``).

.. code-block:: php

	// data der aktuellen Seite
	\nn\t3::Page()->getData();
	
	// data der Seite mit pid = 123 holen
	\nn\t3::Page()->getData( 123 );
	
	// data der Seiten mit pids = 123 und 456 holen. Key des Arrays = pid
	\nn\t3::Page()->getData( [123, 456] );

| ``@return array``

\\nn\\t3::Page()->getField(``$key, $slide = false, $override = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einzelnes Feld aus page-Data holen.
Der Wert kann per ``slide = true`` von übergeordneten Seiten geerbt werden.

(!) Wichtig:
Eigene Felder müssen in der ``ext_localconf.php`` als rootLine definiert werden!
Siehe auch ``\nn\t3::Registry()->rootLineFields(['key', '...']);``

.. code-block:: php

	\nn\t3::Page()->getField('layout');
	\nn\t3::Page()->getField('backend_layout_next_level', true, 'backend_layout');

Exisitiert auch als ViewHelper:

.. code-block:: php

	{nnt3:page.data(key:'uid')}
	{nnt3:page.data(key:'media', slide:1)}
	{nnt3:page.data(key:'backend_layout_next_level', slide:1, override:'backend_layout')}

| ``@return mixed``

\\nn\\t3::Page()->getLink(``$pidOrParams = NULL, $params = [], $absolute = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einen einfachen Link zu einer Seite im Frontend generieren.

Funktioniert in jedem Kontext - sowohl aus einem Backend-Modul oder Scheduler/CLI-Job heraus, als auch im Frontend-Kontext, z.B. im Controller oder einem ViewHelper.
Aus dem Backend-Kontext werden absolute URLs ins Frontend generiert. Die URLs werden als lesbare URLs kodiert - der Slug-Pfad bzw. RealURL werden berücksichtigt.

.. code-block:: php

	\nn\t3::Page()->getLink( $pid );
	\nn\t3::Page()->getLink( $pid, $params );
	\nn\t3::Page()->getLink( $params );
	\nn\t3::Page()->getLink( $pid, true );
	\nn\t3::Page()->getLink( $pid, $params, true );
	\nn\t3::Page()->getLink( 'david@99grad.de' )

Beispiel zum Generieren eines Links an einen Controller:

Tipp: siehe auch ``\nn\t3::Page()->getActionLink()`` für eine Kurzversion!

.. code-block:: php

	$newsDetailPid = 123;
	$newsArticleUid = 45;
	
	$link = \nn\t3::Page()->getLink($newsDetailPid, [
	    'tx_news_pi1' => [
	        'action'        => 'detail',
	        'controller'    => 'News',
	        'news'          => $newsArticleUid,
	    ]
	]);

| ``@return string``

\\nn\\t3::Page()->getPageRenderer();
"""""""""""""""""""""""""""""""""""""""""""""""

Page-Renderer holen

.. code-block:: php

	\nn\t3::Page()->getPageRenderer();

| ``@return PageRenderer``

\\nn\\t3::Page()->getPid(``$fallback = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

PID der aktuellen Seite holen.
Im Frontend: Die aktuelle ``TSFE->id``
Im Backend: Die Seite, die im Seitenbaum ausgewählt wurde
Ohne Context: Die pid der site-Root

.. code-block:: php

	\nn\t3::Page()->getPid();
	\nn\t3::Page()->getPid( $fallbackPid );

| ``@return int``

\\nn\\t3::Page()->getPidFromRequest();
"""""""""""""""""""""""""""""""""""""""""""""""

PID aus Request-String holen, z.B. in Backend Modulen.
Hacky. ToDo: Prüfen, ob es eine bessere Methode gibt.

.. code-block:: php

	\nn\t3::Page()->getPidFromRequest();

| ``@return int``

\\nn\\t3::Page()->getRootline(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Rootline für gegebene PID holen

.. code-block:: php

	\nn\t3::Page()->getRootline();

| ``@return array``

\\nn\\t3::Page()->getSiteRoot(``$returnAll = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

PID der Site-Root(s) holen.
Entspricht der Seite im Backend, die die "Weltkugel" als Symbol hat
(in den Seiteneigenschaften "als Anfang der Webseite nutzen")

.. code-block:: php

	\nn\t3::Page()->getSiteRoot();

| ``@return int``

\\nn\\t3::Page()->getSubpages(``$pid = NULL, $includeHidden = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Menü für gegebene PID holen

.. code-block:: php

	\nn\t3::Page()->getSubpages();
	\nn\t3::Page()->getSubpages( $pid );
	\nn\t3::Page()->getSubpages( $pid, true );   // Auch versteckte Seiten holen

| ``@return array``

\\nn\\t3::Page()->getTitle();
"""""""""""""""""""""""""""""""""""""""""""""""

Aktuellen Page-Title (ohne Suffix) holen

.. code-block:: php

	\nn\t3::Page()->getTitle();

| ``@return string``

\\nn\\t3::Page()->hasSubpages(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob eine Seite Untermenüs hat

.. code-block:: php

	\nn\t3::Page()->hasSubpages();

| ``@return boolean``

\\nn\\t3::Page()->setTitle(``$title = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

PageTitle (<title>-Tag) ändern
Funktioniert nicht, wenn EXT:advancedtitle aktiviert ist!

.. code-block:: php

	\nn\t3::Page()->setTitle('YEAH!');

Auch als ViewHelper vorhanden:

.. code-block:: php

	{nnt3:page.title(title:'Yeah')}
	{entry.title->nnt3:page.title()}

| ``@return void``

