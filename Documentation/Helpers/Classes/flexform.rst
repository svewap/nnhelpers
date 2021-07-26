
.. include:: ../../Includes.txt

.. _Flexform:

==============================================
Flexform
==============================================

\\nn\\t3::Flexform()
----------------------------------------------

Load and parse FlexForms

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Flexform()->getFalMedia(``$ttContentUid = NULL, $field = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lädt FAL media specified in directly in the FlexForm

.. code-block:: php

	\nn\t3::Flexform()->getFalMedia( 'falmedia' );
	\nn\t3::Flexform()->getFalMedia( 'settings.falmedia' );
	\nn\t3::Flexform()->getFalMedia( 1201, 'falmedia' );

.. code-block:: php

	$cObjData = \nn\t3::Tsfe()->cObjData();
	$falMedia = \nn\t3::Flexform()->getFalMedia( $cObjData['uid'], 'falmedia' );

| ``@return array``

\\nn\\t3::Flexform()->getFlexform(``$ttContentUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets the flexform of a given content element as an array

.. code-block:: php

	\nn\t3::Flexform()->getFlexform( 1201 );

| ``@return array``

\\nn\\t3::Flexform()->insertCountries(``$config, $a = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Inserts options from TypoScript into a FlexForm or TCA for selection.

.. code-block:: php

	<config>
	    <type>select</type>
	    <items type="array"></items>
	    <itemsProcFunc>nn\t3\Flexform>insertCountries</itemsProcFunc>
	    <insertEmpty>1</insertEmpty>
	</config>

| ``@return array``

\\nn\\t3::Flexform()->insertOptions(``$config, $a = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Inserts options from TypoScript into a FlexForm or TCA for selection.

.. code-block:: php

	<config>
	    <type>select</type>
	    <items type="array"></items>
	    <itemsProcFunc>nn\t3\Flexform->insertOptions</itemsProcFunc>
	    <typoscriptPath>plugin.tx_extname.settings.templates</typoscriptPath>
	    <!-- Alternatively: Load settings from PageTSConfig: -->
	    <pageconfigPath>tx_extname.colors</pageconfigPath>
	    <insertEmpty>1</insertEmpty>
	    <hideKey>1</hideKey>
	</config>

With typoscript, several types of construction are allowed:

.. code-block:: php

	plugin.tx_extname.settings.templates {
	    # direct key => label pairs.
	    small = small design
	    # ... or: label set in subarray.
	    mid {
	        label = Mid Design
	    }
	    # ... or: Key set in subarray, practical e.g. for CSS classes
	    10 {
	        label = Big Design
	        classes = big big-thing
	    }
	    # ... or a userFunc. Returns one of the variants above as an array
	    20 {
	        userFunc = nn\t3\Flexform->getOptions
	    }
	}

The selection can be limited to specific controller actions in the TypoScript.
In this example, the "Yellow" option is only displayed if in the ``switchableControllerAction``
| ``Category->list`` has been selected.

.. code-block:: php

	plugin.tx_extname.settings.templates {
	    yellow {
	        label = yellow
	        controllerAction = Category->list,...
	    }
	}

| ``@return array``

\\nn\\t3::Flexform()->parse(``$xml = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a flexform XML to an array

.. code-block:: php

	\nn\t3::Flexform()->parse('<?xml...>');

Also acts as a ViewHelper:

.. code-block:: php

	{rawXmlString->nnt3:parse.flexForm()->f:debug()}

| ``@return array``

