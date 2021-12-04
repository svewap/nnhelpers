
.. include:: ../../Includes.txt

.. _Settings:

==============================================
Settings
==============================================

\\nn\\t3::Settings()
----------------------------------------------

Methoden, um den Zugriff auf TypoScript Setup, Constanten und PageTsConfig
zu vereinfachen.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Settings()->addPageConfig(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Page-Config hinzufügen
Alias zu ``\nn\t3::Registry()->addPageConfig( $str );``

.. code-block:: php

	\nn\t3::Settings()->addPageConfig( 'test.was = 10' );
	\nn\t3::Settings()->addPageConfig( '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:extname/Configuration/TypoScript/page.txt">' );
	\nn\t3::Settings()->addPageConfig( '@import "EXT:extname/Configuration/TypoScript/page.ts"' );

| ``@return void``

\\nn\\t3::Settings()->get(``$extensionName = '', $path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt das TypoScript-Setup und dort den Abschnitt "settings".
Werte aus dem FlexForm werden dabei nicht gemerged.
Alias zu ``\nn\t3::Settings()->getSettings()``.

.. code-block:: php

	\nn\t3::Settings()->get( 'nnsite' );
	\nn\t3::Settings()->get( 'nnsite', 'path.in.settings' );

| ``@return array``

\\nn\\t3::Settings()->getConstants(``$tsPath = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Array der TypoScript-Konstanten holen.

.. code-block:: php

	\nn\t3::Settings()->getConstants();
	\nn\t3::Settings()->getConstants('pfad.zur.konstante');

Existiert auch als ViewHelper:

.. code-block:: php

	{nnt3:ts.constants(path:'pfad.zur.konstante')}

| ``@return array``

\\nn\\t3::Settings()->getExtConf(``$extName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Extension-Konfiguration holen.
Kommen aus der ``LocalConfiguration.php``, werden über die Extension-Einstellungen
im Backend bzw. ``ext_conf_template.txt`` definiert

Früher: ``$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['your_extension_key']``

.. code-block:: php

	\nn\t3::Settings()->getExtConf( 'extname' );

| ``@return mixed``

\\nn\\t3::Settings()->getFromPath(``$tsPath = '', $setup = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Setup von einem gegebenen Pfad holen, z.B. 'plugin.tx_example.settings'

.. code-block:: php

	\nn\t3::Settings()->getFromPath('plugin.pfad');
	\nn\t3::Settings()->getFromPath('L', \nn\t3::Request()->GP());
	\nn\t3::Settings()->getFromPath('a.b', ['a'=>['b'=>1]]);

Existiert auch als ViewHelper:

.. code-block:: php

	{nnt3:ts.setup(path:'pfad.zur.setup')}

| ``@return array``

\\nn\\t3::Settings()->getFullTyposcript(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Das komplette TypoScript Setup holen, als einfaches Array - ohne "."-Syntax
Funktioniert sowohl im Frontend als auch Backend, mit und ohne übergebener pid

.. code-block:: php

	\nn\t3::Settings()->getFullTyposcript();
	\nn\t3::Settings()->getFullTyposcript( $pid );

| ``@return array``

\\nn\\t3::Settings()->getMergedSettings(``$extensionName = NULL, $ttContentUidOrSetupArray = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Merge aus TypoScript-Setup für ein Plugin und seinem Flexform holen.
Gibt das TypoScript-Array ab ``plugin.tx_extname.settings``... zurück.

Wichtig: $extensionName nur angeben, wenn das Setup einer FREMDEN Extension
geholt werden soll oder es keinen Controller-Context gibt, weil der
Aufruf aus dem Backend gemacht wird... sonst werden die FlexForm-Werte nicht berücksichtigt!

Im FlexForm ``<settings.flexform.varName>`` verwenden!
| ``<settings.flexform.varName>`` überschreibt dann ``settings.varName`` im TypoScript-Setup

| ``$ttContentUidOrSetupArray`` kann uid eines ``tt_content``-Inhaltselementes sein
oder ein einfaches Array zum Überschreiben der Werte aus dem TypoScript / FlexForm

.. code-block:: php

	\nn\t3::Settings()->getMergedSettings();
	\nn\t3::Settings()->getMergedSettings( 'nnsite' );
	\nn\t3::Settings()->getMergedSettings( $extensionName, $ttContentUidOrSetupArray );

| ``@return array``

\\nn\\t3::Settings()->getPageConfig(``$tsPath = '', $pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Page-Configuration holen

.. code-block:: php

	\nn\t3::Settings()->getPageConfig();
	\nn\t3::Settings()->getPageConfig('RTE.default.preset');
	\nn\t3::Settings()->getPageConfig( $tsPath, $pid );

Existiert auch als ViewHelper:

.. code-block:: php

	{nnt3:ts.page(path:'pfad.zur.pageconfig')}

| ``@return array``

\\nn\\t3::Settings()->getPlugin(``$extName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Das Setup für ein bestimmtes Plugin holen.

.. code-block:: php

	\nn\t3::Settings()->getPlugin('extname') ergibt TypoScript ab plugin.tx_extname...

Wichtig: $extensionName nur angeben, wenn das Setup einer FREMDEN Extension
geholt werden soll oder es keinen Controller-Context gibt, weil der Aufruf z.B.
aus dem Backend gemacht wird

| ``@return array``

\\nn\\t3::Settings()->getSettings(``$extensionName = '', $path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt das TypoScript-Setup und dort den Abschnitt "settings".
Werte aus dem FlexForm werden dabei nicht gemerged.

.. code-block:: php

	\nn\t3::Settings()->getSettings( 'nnsite' );
	\nn\t3::Settings()->getSettings( 'nnsite', 'example.path' );

| ``@return array``

\\nn\\t3::Settings()->getSiteConfig(``$request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Site-Konfiguration holen.
Das ist die Konfiguration, die ab TYPO3 9 in den YAML-Dateien im Ordner ``/sites`` definiert wurden.
Einige der Einstellungen sind auch über das Seitenmodul "Sites" einstellbar.

Im Kontext einer MiddleWare ist evtl. die ``site`` noch nicht geparsed / geladen.
In diesem Fall kann der ``$request`` aus der MiddleWare übergeben werden, um die Site zu ermitteln.

.. code-block:: php

	$config = \nn\t3::Settings()->getSiteConfig();
	$config = \nn\t3::Settings()->getSiteConfig( $request );

| ``@return array``

\\nn\\t3::Settings()->getStoragePid(``$extName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Aktuelle (ERSTE) StoragePid für das aktuelle Plugin holen.
Gespeichert im TypoScript-Setup der Extension unter
| ``plugin.tx_extname.persistence.storagePid`` bzw. im
FlexForm des Plugins auf der jeweiligen Seite.

WICHTIG: Merge mit gewählter StoragePID aus dem FlexForm
passiert nur, wenn ``$extName``leer gelassen wird.

.. code-block:: php

	\nn\t3::Settings()->getStoragePid();         // 123
	\nn\t3::Settings()->getStoragePid('nnsite'); // 466

| ``@return string``

\\nn\\t3::Settings()->getStoragePids(``$extName = NULL, $recursive = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

ALLE storagePids für das aktuelle Plugin holen.
Gespeichert als komma-separierte Liste im TypoScript-Setup der Extension unter
| ``plugin.tx_extname.persistence.storagePid`` bzw. im
FlexForm des Plugins auf der jeweiligen Seite.

WICHTIG: Merge mit gewählter StoragePID aus dem FlexForm
passiert nur, wenn ``$extName``leer gelassen wird.

.. code-block:: php

	\nn\t3::Settings()->getStoragePids();                    // [123, 466]
	\nn\t3::Settings()->getStoragePids('nnsite');            // [123, 466]

Auch die child-PageUids holen?
| ``true`` nimmt den Wert für "Rekursiv" aus dem FlexForm bzw. aus dem
TypoScript der Extension von ``plugin.tx_extname.persistence.recursive``

.. code-block:: php

	\nn\t3::Settings()->getStoragePids(true);                // [123, 466, 124, 467, 468]
	\nn\t3::Settings()->getStoragePids('nnsite', true);      // [123, 466, 124, 467, 468]

Alternativ kann für die Tiefe / Rekursion auch ein numerischer Wert
übergeben werden.

.. code-block:: php

	\nn\t3::Settings()->getStoragePids(2);               // [123, 466, 124, 467, 468]
	\nn\t3::Settings()->getStoragePids('nnsite', 2);     // [123, 466, 124, 467, 468]

| ``@return array``

\\nn\\t3::Settings()->getTyposcriptObject(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

TemplateService instanziieren, TypoScript-Config und Setup parsen.
Interne Funktion – nicht zur Verwendung gedacht.
| ``getFullTyposcript`` nutzen.

| ``@return object``

\\nn\\t3::Settings()->setExtConf(``$extName = '', $key = '', $value = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Extension-Konfiguration schreiben.
Schreibt eine Extension-Konfiguration in die ``LocalConfiguration.php``. Die Werte können bei
entsprechender Konfiguration in der ``ext_conf_template.txt`` auch über den Extension-Manager / die
Extension Konfiguration im Backend bearbeitet werden.

.. code-block:: php

	\nn\t3::Settings()->setExtConf( 'extname', 'key', 'value' );

| ``@return mixed``

