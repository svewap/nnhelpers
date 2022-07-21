
.. include:: ../../Includes.txt

.. _TCA:

==============================================
TCA
==============================================

\\nn\\t3::TCA()
----------------------------------------------

Methods for configuring and accessing fields in the TCA.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::TCA()->addModuleOptionToPage(``$label, $identifier, $iconIdentifier = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

In the page properties under "Behavior -> Contains extension" add a selection option.
Classically used in ``Configuration/TCA/Overrides/pages.php``, earlier in ``ext_tables.php``

.. code-block:: php

	// In ext_localconf.php register the icon (16 x 16 px SVG).
	\nn\t3::Registry()->icon('icon-identifier', 'EXT:myext/Resources/Public/Icons/module.svg');
	
	// In Configuration/TCA/Overrides/pages.php
	\nn\t3::TCA()->addModuleOptionToPage('description', 'identifier', 'icon-identifier');

| ``@return void``

\\nn\\t3::TCA()->createConfig(``$tablename = '', $basics = [], $custom = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get basic configuration for the TCA.
These are the fields like ``hidden``, ``starttime`` etc., which are always the same for (almost) all tables.

Get ALL typical fields:

.. code-block:: php

	'columns' => \nn\t3::TCA()->createConfig(
	    'tx_myext_domain_model_entry', true,
	    ['title'=>...]
	)

Get only specific fields:

.. code-block:: php

	'columns' => \nn\t3::TCA()->createConfig(
	    'tx_myext_domain_model_entry',
	    ['sys_language_uid', 'l10n_parent', 'l10n_source', 'l10n_diffsource', 'hidden', 'cruser_id', 'pid', 'crdate', 'tstamp', 'sorting', 'starttime', 'endtime', 'fe_group'],
	    ['title'=>...]
	)

| ``@return array``

\\nn\\t3::TCA()->getColorPickerTCAConfig();
"""""""""""""""""""""""""""""""""""""""""""""""

Get color picker configuration for the TCA.

.. code-block:: php

	'config' => \nn\t3::TCA()->getColorPickerTCAConfig(),

| ``@return array``

\\nn\\t3::TCA()->getColumn(``$tableName = '', $fieldName = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets configuration array for a field from the TCA.
Alias to ``\nn\t3::Db()->getColumn()``

.. code-block:: php

	\nn\t3::TCA()->getColumn( 'pages', 'media' );

| ``@return array``

\\nn\\t3::TCA()->getColumns(``$tableName = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets configuration array für a table from the TCA.
Alias to ``\nn\t3::Db()->getColumns()``

.. code-block:: php

	\nn\t3::TCA()->getColumns( 'pages' );

| ``@return array``

\\nn\\t3::TCA()->getConfig(``$path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get a configuration from the TCA for a path.
Returns a reference to the ``config`` array of the corresponding field.

.. code-block:: php

	\nn\t3::TCA()->getConfig('tt_content.columns.tx_mask_iconcollection');

| ``@return array``

\\nn\\t3::TCA()->getConfigForType(``$type = '', $override = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get default configuration for various typical ``types`` in ``TCA``
Serves as an alias of sorts to make the most commonly used ``config`` arrays faster
and shorter to write

.. code-block:: php

	\nn\t3::TCA()->getConfigForType( 'text' ); // => ['type'=>'text', 'rows'=>2, ...]
	\nn\t3::TCA()->getConfigForType( 'rte' ); // => ['type'=>'text', 'enableRichtext'=>'true', ...]
	\nn\t3::TCA()->getConfigForType( 'color' ); // => ['type'=>'input', 'renderType'=>'colorpicker', ...]
	\nn\t3::TCA()->getConfigForType( 'fal', 'image' ); // => ['type'=>'input', 'renderType'=>'colorpicker', ...]

Default configurations can be easily üoverridden / extended:

.. code-block:: php

	\nn\t3::TCA()->getConfigForType( 'text', ['rows'=>5] ); // => ['type'=>'text', 'rows'=>5, ...]

For each type, the most frequently üoverwritten value in the ``config`` array can also be
by passing a fixed value instead of an ``override`` array:

.. code-block:: php

	\nn\t3::TCA()->getConfigForType( 'text', 10 ); // => ['rows'=>10, ...]
	\nn\t3::TCA()->getConfigForType( 'rte', 'myRteConfig' ); // => ['richtextConfiguration'=>'myRteConfig', ...]
	\nn\t3::TCA()->getConfigForType( 'color', '#ff6600' ); // => ['default'=>'#ff6600', ...]
	\nn\t3::TCA()->getConfigForType( 'fal', 'image' ); // => [ config für the field with key `image` ]

| ``@return array``

\\nn\\t3::TCA()->getFalFields(``$tableName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets all field names from the TCA array that have a SysFileReference relation.
For example, for the ``tt_content`` table, this would be ``assets``, ``media`` etc.

.. code-block:: php

	\nn\t3::TCA()->getColumns( 'pages' ); // => ['media', 'assets', 'image']

| ``@return array``

\\nn\\t3::TCA()->getFileFieldTCAConfig(``$fieldName = 'media', $override = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

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
"""""""""""""""""""""""""""""""""""""""""""""""

GetRTE configuration for the TCA.

.. code-block:: php

	'config' => \nn\t3::TCA()->getRteTCAConfig(),

| ``@return array``

\\nn\\t3::TCA()->getSlugTCAConfig(``$fields = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get default slug configuration for the TCA.

.. code-block:: php

	'config' => \nn\t3::TCA()->getSlugTCAConfig( 'title' )
	'config' => \nn\t3::TCA()->getSlugTCAConfig( ['title', 'header'] )

| ``@param array|string $fields``
| ``@return array``

\\nn\\t3::TCA()->insertCountries(``$config, $a = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

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
"""""""""""""""""""""""""""""""""""""""""""""""

Inserts a flexform into a TCA.

Example in TCA:

.. code-block:: php

	'config' => \nn\t3::TCA()->insertFlexform('FILE:EXT:nnsite/Configuration/FlexForm/slickslider_options.xml');

| ``@return array``

\\nn\\t3::TCA()->insertOptions(``$config, $a = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

\\nn\\t3::TCA()->setConfig(``$path = '', $override = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

A configuration of the TCA üoverride, e.g., to add a custom renderType to a ``mask`` field.
üoverwrite or to change core settings in the TCA on the ``pages`` or ``tt_content`` tables.

The following example sets/ürewrites in the ``TCA`` the ``config`` array at:

.. code-block:: php

	$GLOBALS['TCA']['tt_content']['columns']['mycol']['config'][...]

.. code-block:: php

	\nn\t3::TCA()->setConfig('tt_content.columns.mycol', [
	    'renderType' => 'nnsiteIconCollection',
	    'iconconfig' => 'tx_nnsite.iconcollection',
	]);

See also ``\nn\t3::TCA()->setContentConfig()`` for a short version of this method when it comes to
the ``tt_content`` table, and ``nn\t3::TCA()->setPagesConfig()`` for the ``pages``
 table.
| ``@return array``

\\nn\\t3::TCA()->setContentConfig(``$field = '', $override = [], $shortParams = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Set or üoverwrite a configuration of the TCA for the ``tt_content`` table.

This example ürewrites in the ``TCA`` the ``config`` array of the table ``tt_content`` für:

.. code-block:: php

	$GLOBALS['TCA']['tt_content']['columns']['title']['config'][...]

.. code-block:: php

	\nn\t3::TCA()->setContentConfig( 'header', 'text' ); // ['type'=>'text', 'rows'=>2]
	\nn\t3::TCA()->setContentConfig( 'header', 'text', 10 ); // ['type'=>'text', 'rows'=>10]
	\nn\t3::TCA()->setContentConfig( 'header', ['type'=>'text', 'rows'=>10] ); // ['type'=>'text', 'rows'=>10]

| ``@return array``

\\nn\\t3::TCA()->setPagesConfig(``$field = '', $override = [], $shortParams = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Set or üoverwrite a configuration of the TCA for the ``pages`` table.

This example ürewrites in the ``TCA`` the ``config`` array of the ``pages`` table für:

.. code-block:: php

	$GLOBALS['TCA']['pages']['columns']['title']['config'][...]

.. code-block:: php

	\nn\t3::TCA()->setPagesConfig( 'title', 'text' ); // ['type'=>'text', 'rows'=>2]
	\nn\t3::TCA()->setPagesConfig( 'title', 'text', 10 ); // ['type'=>'text', 'rows'=>10]
	\nn\t3::TCA()->setPagesConfig( 'title', ['type'=>'text', 'rows'=>2] ); // ['type'=>'text', 'rows'=>2]

| ``@return array``

