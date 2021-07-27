
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

