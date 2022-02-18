
.. include:: ../../Includes.txt

.. _Registry:

==============================================
Registry
==============================================

\\nn\\t3::Registry()
----------------------------------------------

Hilfreiche Methoden zum Registrieren von Extension-Komponenten wie Plugins,
Backend-Module, FlexForms etc.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Registry()->addPageConfig(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Page-Config hinzufügen

.. code-block:: php

	\nn\t3::Registry()->addPageConfig( 'test.was = 10' );
	\nn\t3::Registry()->addPageConfig( '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:extname/Configuration/TypoScript/page.txt">' );
	\nn\t3::Settings()->addPageConfig( '@import "EXT:extname/Configuration/TypoScript/page.ts"' );

| ``@return void``

\\nn\\t3::Registry()->clearCacheHook(``$classMethodPath = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Fügt einen Hook ein, der beim Klick auf "Cache löschen" ausgeführt wird.
Folgendes Script kommt in die ``ext_localconf.php`` der eigenen Extension:

.. code-block:: php

	\nn\t3::Registry()->clearCacheHook( \My\Ext\Path::class . '->myMethod' );

| ``@return void``

\\nn\\t3::Registry()->configurePlugin(``$vendorName = '', $pluginName = '', $cacheableActions = [], $uncacheableActions = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein Plugin konfigurieren.
In ``ext_localconf.php`` nutzen.

.. code-block:: php

	\nn\t3::Registry()->configurePlugin( 'Nng\Nncalendar', 'Nncalendar',
	    [\Nng\ExtName\Controller\MainController::class => 'index,list'],
	    [\Nng\ExtName\Controller\MainController::class => 'show']
	);

| ``@return void``

\\nn\\t3::Registry()->flexform(``$vendorName = '', $pluginName = '', $path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein Flexform für ein Plugin registrieren.

.. code-block:: php

	\nn\t3::Registry()->flexform( 'nncalendar', 'nncalendar', 'FILE:EXT:nnsite/Configuration/FlexForm/flexform.xml' );
	\nn\t3::Registry()->flexform( 'Nng\Nncalendar', 'nncalendar', 'FILE:EXT:nnsite/Configuration/FlexForm/flexform.xml' );

| ``@return void``

\\nn\\t3::Registry()->fluidNamespace(``$referenceNames = [], $namespaces = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Globalen Namespace für Fluid registrieren.
Meistens in ``ext_localconf.php`` genutzt.

.. code-block:: php

	\nn\t3::Registry()->fluidNamespace( 'nn', 'Nng\Nnsite\ViewHelpers' );
	\nn\t3::Registry()->fluidNamespace( ['nn', 'nng'], 'Nng\Nnsite\ViewHelpers' );
	\nn\t3::Registry()->fluidNamespace( ['nn', 'nng'], ['Nng\Nnsite\ViewHelpers', 'Other\Namespace\Fallback'] );

| ``@return void``

\\nn\\t3::Registry()->get(``$extName = '', $path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine Wert aus der Tabelle sys_registry holen.

.. code-block:: php

	\nn\t3::Registry()->get( 'nnsite', 'lastRun' );

| ``@return void``

\\nn\\t3::Registry()->getVendorExtensionName(``$combinedVendorPluginName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Plugin-Name generieren.
Abhängig von Typo3-Version wird der Plugin-Name mit oder ohne Vendor zurückgegeben.

.. code-block:: php

	    \nn\t3::Registry()->getVendorExtensionName( 'nncalendar' );      // => Nng.Nncalendar
	    \nn\t3::Registry()->getVendorExtensionName( 'Nng\Nncalendar' );      // => Nng.Nncalendar

| ``@return string``

\\nn\\t3::Registry()->icon(``$identifier = '', $path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein Icon registrieren. Klassischerweise in ext_tables.php genutzt.

.. code-block:: php

	\nn\t3::Registry()->icon('nncalendar-plugin', 'EXT:myextname/Resources/Public/Icons/wizicon.svg');

| ``@return void``

\\nn\\t3::Registry()->parseControllerActions(``$controllerActionList = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Liste mit ``'ControllerName' => 'action,list,show'`` parsen.
Immer den vollen Klassen-Pfad in der ``::class`` Schreibweise angeben.
Berücksichtigt, dass vor Typo3 10 nur der einfache Klassen-Name (z.B. ``Main``)
als Key verwendet wird.

.. code-block:: php

	\nn\t3::Registry()->parseControllerActions(
	    [\Nng\ExtName\Controller\MainController::class => 'index,list'],
	);

| ``@return array``

\\nn\\t3::Registry()->plugin(``$vendorName = '', $pluginName = '', $title = '', $icon = '', $tcaGroup = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein Plugin registrieren zur Auswahl über das Dropdown ``CType`` im Backend.
In ``Configuration/TCA/Overrides/tt_content.php`` nutzen – oder ``ext_tables.php`` (veraltet).

.. code-block:: php

	\nn\t3::Registry()->plugin( 'nncalendar', 'nncalendar', 'Kalender', 'EXT:pfad/zum/icon.svg' );
	\nn\t3::Registry()->plugin( 'Nng\Nncalendar', 'nncalendar', 'Kalender', 'EXT:pfad/zum/icon.svg' );

| ``@return void``

\\nn\\t3::Registry()->pluginGroup(``$vendorName = '', $groupLabel = '', $plugins = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Vereinfacht das Registrieren einer Liste von Plugins, die im ``list_type`` Dropdown zu einer
Gruppe zusammengefasst werden.

In ``Configuration/TCA/Overrides/tt_content.php`` nutzen:

.. code-block:: php

	\nn\t3::Registry()->pluginGroup(
	    'Nng\Myextname',
	    'LLL:EXT:myextname/Resources/Private/Language/locallang_db.xlf:pi_group_name',
	    [
	        'list' => [
	            'title'     => 'LLL:EXT:myextname/Resources/Private/Language/locallang_db.xlf:pi_list.name',
	            'icon'      => 'EXT:myextname/Resources/Public/Icons/Extension.svg',
	            'flexform'  => 'FILE:EXT:myextname/Configuration/FlexForm/list.xml',
	        ],
	        'show' => [
	            'title'     => 'LLL:EXT:myextname/Resources/Private/Language/locallang_db.xlf:pi_show.name',
	            'icon'      => 'EXT:myextname/Resources/Public/Icons/Extension.svg',
	            'flexform'  => 'FILE:EXT:myextname/Configuration/FlexForm/show.xml'
	        ],
	    ]
	);

| ``@return void``

\\nn\\t3::Registry()->rootLineFields(``$fields = [], $translate = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein Feld in der Tabelle pages registrieren, das auf Unterseiten vererbbar / geslided werden soll.
In der ``ext_localconf.php`` registrieren:

.. code-block:: php

	\nn\t3::Registry()->rootLineFields(['slidefield']);
	\nn\t3::Registry()->rootLineFields('slidefield');

Typoscript-Setup:

.. code-block:: php

	page.10 = FLUIDTEMPLATE
	page.10.variables {
	    footer = TEXT
	    footer {
	        data = levelfield:-1, footerelement, slide
	    }
	}

| ``@return void``

\\nn\\t3::Registry()->set(``$extName = '', $path = '', $settings = [], $clear = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einen Wert in der Tabelle sys_registry speichern.
Daten in dieser Tabelle bleiben über die Session hinaus erhalten.
Ein Scheduler-Job kann z.B. speichern, wann er das letzte Mal
ausgeführt wurde.

Arrays werden per default rekursiv zusammengeführt / gemerged:

.. code-block:: php

	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['eins'=>'1'] );
	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['zwei'=>'2'] );
	
	\nn\t3::Registry()->get( 'nnsite', 'lastRun' ); // => ['eins'=>1, 'zwei'=>2]

Mit ``true`` am Ende werden die vorherigen Werte gelöscht:

.. code-block:: php

	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['eins'=>'1'] );
	\nn\t3::Registry()->set( 'nnsite', 'lastRun', ['zwei'=>'2'], true );
	
	\nn\t3::Registry()->get( 'nnsite', 'lastRun' ); // => ['zwei'=>2]

| ``@return array``

