
.. include:: ../Includes.txt

.. _TCA:

============
TCA
============

\\nn\\t3::TCA()
---------------

Methods for configuring and accessing fields in the TCA.

Overview of Methods
~~~~~~~~~~~~~~~~

\\nn\\t3::TCA()->insertOptions(``$config, $a = NULL``);
""""""""""""""""

Inserts options from TypoScript into a TCA for selection.
Alias to \nn\t3::Flexform->insertOptions( $config, $a = null );
Description and more examples there.

Example in TCA:

.. code-block:: php

	'config' => [
	    'type' => 'select',
	    'itemsProcFunc' => 'nn\t3\Flexform->insertOptions',
	    'typoscriptPath' => 'plugin.tx_nnnewsroom.settings.templates',
	    //'pageconfigPath' => 'tx_nnnewsroom.colors',
	]

| ``@return array``

\\nn\\t3::TCA()->insertCountries(``$config, $a = NULL``);
""""""""""""""""

Inserts list of countries into a TCA.
Alias to \nn\t3::Flexform->insertCountries( $config, $a = null );
Description and more examples there.

Example in TCA:

.. code-block:: php

	'config' => [
	    'type' => 'select',
	    'itemsProcFunc' => 'nn\t3\Flexform->insertCountries',
	    'insertEmpty' => true,
	]

| ``@return array``

\\nn\\t3::TCA()->insertFlexform(``$path``);
""""""""""""""""

Inserts a flexform into a TCA.

Example in TCA:

.. code-block:: php

	'config' => \nn\t3::TCA()->insertFlexform('FILE:EXT:nnsite/Configuration/FlexForm/slickslider_options.xml');

| ``@return array``

\\nn\\t3::TCA()->getColumn(``$tableName = '', $fieldName = '', $useSchemaManager = false``);
""""""""""""""""

Gets configuration array for a field from the TCA.
Alias to ``\nn\t3::Db()->getColumn()``

.. code-block:: php

	\nn\t3::TCA()->getColumn( 'pages', 'media' );

| ``@return array``

\\nn\\t3::TCA()->getColumns(``$tableName = '', $useSchemaManager = false``);
""""""""""""""""

Gets configuration array for a table from the TCA.
Alias to ``\nn\t3::Db()->getColumns()``

.. code-block:: php

	\nn\t3::TCA()->getColumns( 'pages' );

| ``@return array``

\\nn\\t3::TCA()->getFileFieldTCAConfig(``$fieldName = 'media', $override = []``);
""""""""""""""""

Get FAL configuration for the TCA.

Default config including image cropper, link and alternative image title.
This setting changes regularly, which is not always possible given the amount of parameters and their changing position in the array.
and their changing position in the array.

https://bit.ly/2SUvASe

.. code-block:: php

	\nn\t3::TCA()->getFileFieldTCAConfig('media');
	\nn\t3::TCA()->getFileFieldTCAConfig('media', ['maxitems'=>1, 'fileExtensions'=>'jpg']);

Will be used in TCA like this:

.. code-block:: php

	'falprofileimage' => [
	    'config' => \nn\t3::TCA()->getFileFieldTCAConfig('falprofileimage', ['maxitems'=>1]),
	],

| ``@return array``

\\nn\\t3::TCA()->getRteTCAConfig();
""""""""""""""""

GetRTE configuration for the TCA.

.. code-block:: php

	'config' => \nn\t3::TCA()->getRteTCAConfig(),

| ``@return array``

\\nn\\t3::TCA()->getColorPickerTCAConfig();
""""""""""""""""

Get color picker configuration for the TCA.

.. code-block:: php

	'config' => \nn\t3::TCA()->getColorPickerTCAConfig(),

| ``@return array``

\\nn\\t3::TCA()->addModuleOptionToPage(``$label, $identifier, $iconIdentifier = ''``);
""""""""""""""""

In the page properties under "Behavior -> Contains extension" add a selection option.
Classically used in ``Configuration/TCA/Overrides/pages.php``, earlier in ``ext_tables.php``

.. code-block:: php

	// In ext_localconf.php register the icon (16 x 16 px SVG).
	\nn\t3::Registry()->icon('icon-identifier', 'EXT:myext/Resources/Public/Icons/module.svg');
	
	// In Configuration/TCA/Overrides/pages.php
	\nn\t3::TCA()->addModuleOptionToPage('description', 'identifier', 'icon-identifier');

| ``@return void``

