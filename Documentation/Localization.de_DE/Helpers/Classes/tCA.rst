
.. include:: ../../Includes.txt

.. _TCA:

==============================================
TCA
==============================================

\\nn\\t3::TCA()
----------------------------------------------

Methoden für die Konfiguration und den Zugriff auf Felder im TCA.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::TCA()->addModuleOptionToPage(``$label, $identifier, $iconIdentifier = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

In den Seiteneigenschaften unter "Verhalten -> Enthält Erweiterung" eine Auswahl-Option hinzufügen.
Klassischerweise in ``Configuration/TCA/Overrides/pages.php`` genutzt, früher in ``ext_tables.php``

.. code-block:: php

	// In ext_localconf.php das Icon registrieren (16 x 16 px SVG)
	\nn\t3::Registry()->icon('icon-identifier', 'EXT:myext/Resources/Public/Icons/module.svg');
	
	// In Configuration/TCA/Overrides/pages.php
	\nn\t3::TCA()->addModuleOptionToPage('Beschreibung', 'identifier', 'icon-identifier');

| ``@return void``

\\nn\\t3::TCA()->createConfig(``$tablename = '', $basics = [], $custom = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Basis-Konfiguration für das TCA holen.
Das sind die Felder wie ``hidden``, ``starttime`` etc., die bei (fast) allen Tabellen immer gleich sind.

ALLE typischen Felder holen:

.. code-block:: php

	'columns' => \nn\t3::TCA()->createConfig(
	    'tx_myext_domain_model_entry', true,
	    ['title'=>...]
	)

Nur bestimmte Felder holen:

.. code-block:: php

	'columns' => \nn\t3::TCA()->createConfig(
	    'tx_myext_domain_model_entry',
	    ['sys_language_uid', 'l10n_parent', 'l10n_source', 'l10n_diffsource', 'hidden', 'cruser_id', 'pid', 'crdate', 'tstamp', 'sorting', 'starttime', 'endtime', 'fe_group'],
	    ['title'=>...]
	)

| ``@return array``

\\nn\\t3::TCA()->getColorPickerTCAConfig();
"""""""""""""""""""""""""""""""""""""""""""""""

Color Picker Konfiguration für das TCA holen.

.. code-block:: php

	'config' => \nn\t3::TCA()->getColorPickerTCAConfig(),

| ``@return array``

\\nn\\t3::TCA()->getColumn(``$tableName = '', $fieldName = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt Konfigurations-Array für ein Feld aus dem TCA.
Alias zu ``\nn\t3::Db()->getColumn()``

.. code-block:: php

	\nn\t3::TCA()->getColumn( 'pages', 'media' );

| ``@return array``

\\nn\\t3::TCA()->getColumns(``$tableName = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt Konfigurations-Array für eine Tabelle aus dem TCA.
Alias zu ``\nn\t3::Db()->getColumns()``

.. code-block:: php

	\nn\t3::TCA()->getColumns( 'pages' );

| ``@return array``

\\nn\\t3::TCA()->getConfig(``$path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine Konfiguration aus dem TCA holen für einen Pfad holen.
Liefert eine Referenz zu dem ``config``-Array des ensprechenden Feldes zurück.

.. code-block:: php

	\nn\t3::TCA()->getConfig('tt_content.columns.tx_mask_iconcollection');

| ``@return array``

\\nn\\t3::TCA()->getConfigForType(``$type = '', $override = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Default Konfiguration für verschiedene, typische ``types`` im ``TCA`` holen.
Dient als eine Art Alias, um die häufigst verwendeten ``config``-Arrays schneller
und kürzer schreiben zu können

.. code-block:: php

	\nn\t3::TCA()->getConfigForType( 'text' );           // => ['type'=>'text', 'rows'=>2, ...]
	\nn\t3::TCA()->getConfigForType( 'rte' );            // => ['type'=>'text', 'enableRichtext'=>'true', ...]
	\nn\t3::TCA()->getConfigForType( 'color' );          // => ['type'=>'input', 'renderType'=>'colorpicker', ...]
	\nn\t3::TCA()->getConfigForType( 'fal', 'image' );   // => ['type'=>'input', 'renderType'=>'colorpicker', ...]

Default-Konfigurationen können einfach überschrieben / erweitert werden:

.. code-block:: php

	\nn\t3::TCA()->getConfigForType( 'text', ['rows'=>5] );   // => ['type'=>'text', 'rows'=>5, ...]

Für jeden Typ lässt sich der am häufigsten überschriebene Wert im ``config``-Array auch
per Übergabe eines fixen Wertes statt eines ``override``-Arrays setzen:

.. code-block:: php

	\nn\t3::TCA()->getConfigForType( 'text', 10 );           // => ['rows'=>10, ...]
	\nn\t3::TCA()->getConfigForType( 'rte', 'myRteConfig' ); // => ['richtextConfiguration'=>'myRteConfig', ...]
	\nn\t3::TCA()->getConfigForType( 'color', '#ff6600' );   // => ['default'=>'#ff6600', ...]
	\nn\t3::TCA()->getConfigForType( 'fal', 'image' );       // => [ config für das Feld mit dem Key `image` ]

| ``@return array``

\\nn\\t3::TCA()->getFalFields(``$tableName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt alle Feldnamen aus dem TCA-Array, die eine SysFileReference-Relation haben.
Bei der Tabelle ``tt_content`` wären das z.B. ``assets``, ``media`` etc.

.. code-block:: php

	\nn\t3::TCA()->getColumns( 'pages' );    // => ['media', 'assets', 'image']

| ``@return array``

\\nn\\t3::TCA()->getFileFieldTCAConfig(``$fieldName = 'media', $override = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

FAL Konfiguration für das TCA holen.

Standard-Konfig inkl. Image-Cropper, Link und alternativer Bildtitel
Diese Einstellung ändert sich regelmäßig, was bei der Menge an Parametern
und deren wechselnden Position im Array eine ziemliche Zumutung ist.

https://bit.ly/2SUvASe

.. code-block:: php

	\nn\t3::TCA()->getFileFieldTCAConfig('media');
	\nn\t3::TCA()->getFileFieldTCAConfig('media', ['maxitems'=>1, 'fileExtensions'=>'jpg']);

Wird im TCA so eingesetzt:

.. code-block:: php

	'falprofileimage' => [
	    'config' => \nn\t3::TCA()->getFileFieldTCAConfig('falprofileimage', ['maxitems'=>1]),
	],

| ``@return array``

\\nn\\t3::TCA()->getRteTCAConfig();
"""""""""""""""""""""""""""""""""""""""""""""""

RTE Konfiguration für das TCA holen.

.. code-block:: php

	'config' => \nn\t3::TCA()->getRteTCAConfig(),

| ``@return array``

\\nn\\t3::TCA()->getSlugTCAConfig(``$fields = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Standard-Slug Konfiguration für das TCA holen.

.. code-block:: php

	'config' => \nn\t3::TCA()->getSlugTCAConfig( 'title' )
	'config' => \nn\t3::TCA()->getSlugTCAConfig( ['title', 'header'] )

| ``@param array|string $fields``
| ``@return array``

\\nn\\t3::TCA()->insertCountries(``$config, $a = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Fügt Liste der Länder in ein TCA ein.
Alias zu \nn\t3::Flexform->insertCountries( $config, $a = null );
Beschreibung und weitere Beispiele dort.

Beispiel im TCA:

.. code-block:: php

	'config' => [
	    'type' => 'select',
	    'itemsProcFunc' => 'nn\t3\Flexform->insertCountries',
	    'insertEmpty' => true,
	]

| ``@return array``

\\nn\\t3::TCA()->insertFlexform(``$path``);
"""""""""""""""""""""""""""""""""""""""""""""""

Fügt ein Flexform in ein TCA ein.

Beispiel im TCA:

.. code-block:: php

	'config' => \nn\t3::TCA()->insertFlexform('FILE:EXT:nnsite/Configuration/FlexForm/slickslider_options.xml');

| ``@return array``

\\nn\\t3::TCA()->insertOptions(``$config, $a = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Fügt Optionen aus TypoScript zur Auswahl in ein TCA ein.
Alias zu \nn\t3::Flexform->insertOptions( $config, $a = null );
Beschreibung und weitere Beispiele dort.

Beispiel im TCA:

.. code-block:: php

	'config' => [
	    'type' => 'select',
	    'itemsProcFunc' => 'nn\t3\Flexform->insertOptions',
	    'typoscriptPath' => 'plugin.tx_nnnewsroom.settings.templates',
	    //'pageconfigPath' => 'tx_nnnewsroom.colors',
	]

| ``@return array``

\\nn\\t3::TCA()->setConfig(``$path = '', $override = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine Konfiguration des TCA überschreiben, z.B. um ein ``mask``-Feld mit einem eigenen renderType zu
überschreiben oder Core-Einstellungen im TCA an den Tabellen ``pages`` oder ``tt_content`` zu ändern.

Folgendes Beispiel setzt/überschreibt im ``TCA`` das ``config``-Array unter:

.. code-block:: php

	$GLOBALS['TCA']['tt_content']['columns']['mycol']['config'][...]

.. code-block:: php

	\nn\t3::TCA()->setConfig('tt_content.columns.mycol', [
	    'renderType' => 'nnsiteIconCollection',
	    'iconconfig' => 'tx_nnsite.iconcollection',
	]);

Siehe auch ``\nn\t3::TCA()->setContentConfig()`` für eine Kurzfassung dieser Methode, wenn es um
die Tabelle ``tt_content`` geht und ``\nn\t3::TCA()->setPagesConfig()`` für die Tabelle ``pages``

| ``@return array``

\\nn\\t3::TCA()->setContentConfig(``$field = '', $override = [], $shortParams = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine Konfiguration des TCA für die Tabelle ``tt_content`` setzen oder überschreiben.

Diese Beispiel überschreibt im ``TCA`` das ``config``-Array der Tabelle ``tt_content`` für:

.. code-block:: php

	$GLOBALS['TCA']['tt_content']['columns']['title']['config'][...]

.. code-block:: php

	\nn\t3::TCA()->setContentConfig( 'header', 'text' );     // ['type'=>'text', 'rows'=>2]
	\nn\t3::TCA()->setContentConfig( 'header', 'text', 10 ); // ['type'=>'text', 'rows'=>10]
	\nn\t3::TCA()->setContentConfig( 'header', ['type'=>'text', 'rows'=>10] ); // ['type'=>'text', 'rows'=>10]

| ``@return array``

\\nn\\t3::TCA()->setPagesConfig(``$field = '', $override = [], $shortParams = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine Konfiguration des TCA für die Tabelle ``pages`` setzen oder überschreiben.

Diese Beispiel überschreibt im ``TCA`` das ``config``-Array der Tabelle ``pages`` für:

.. code-block:: php

	$GLOBALS['TCA']['pages']['columns']['title']['config'][...]

.. code-block:: php

	\nn\t3::TCA()->setPagesConfig( 'title', 'text' );            // ['type'=>'text', 'rows'=>2]
	\nn\t3::TCA()->setPagesConfig( 'title', 'text', 10 );        // ['type'=>'text', 'rows'=>10]
	\nn\t3::TCA()->setPagesConfig( 'title', ['type'=>'text', 'rows'=>2] ); // ['type'=>'text', 'rows'=>2]

| ``@return array``

