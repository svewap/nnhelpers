
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

Inserts options from TypoScript into a FlexForm or TCA for selection

.. code-block:: php

	
	    select
	    
	    nn\t3\Flexform->insertOptions
	    plugin.tx_extname.settings.templates
	    
	    tx_extname.colors
	    1
	    1
	

With typoscript, different types of structure are allowed:

.. code-block:: php

	plugin.tx_extname.settings.templates {
	    # direct key => label pairs
	    small = small design
	    # ... or: label set in subarray.
	    mid {
	        label = Mid Design
	    }
	    # ... or: key set in subarray, practical e.g. for CSS classes
	    10 {
	        label = big design
	        classes = big big-thing
	    }
	    # ... or a userFunc. Returns one of the variants above as an array
	    30 {
	        userFunc = nn\t3\Flexform->getOptions
	    }
	}

The selection can be limited to specific controller actions in the TypoScript.
In this example, the "Yellow" option will only be displayed if in the ``switchableControllerAction``
| ``Category->list`` was selected.

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

