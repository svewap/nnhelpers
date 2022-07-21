
.. include:: ../../Includes.txt

.. _Flexform:

==============================================
Flexform
==============================================

\\nn\\t3::Flexform()
----------------------------------------------

FlexForms laden und parsen

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Flexform()->getFalMedia(``$ttContentUid = NULL, $field = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lädt FAL-Media, die in direkt im FlexForm angegeben wurden

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

Holt das Flexform eines bestimmten Inhaltselementes als Array

.. code-block:: php

	\nn\t3::Flexform()->getFlexform( 1201 );

| ``@return array``

\\nn\\t3::Flexform()->insertCountries(``$config, $a = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Fügt Optionen aus TypoScript zur Auswahl in ein FlexForm oder TCA ein.

.. code-block:: php

	<config>
	    <type>select</type>
	    <items type="array"></items>
	    <itemsProcFunc>nn\t3\Flexform->insertCountries</itemsProcFunc>
	    <insertEmpty>1</insertEmpty>
	</config>

| ``@return array``

\\nn\\t3::Flexform()->insertOptions(``$config, $a = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Fügt Optionen aus TypoScript zur Auswahl in ein FlexForm oder TCA ein.

.. code-block:: php

	<config>
	    <type>select</type>
	    <items type="array"></items>
	    <itemsProcFunc>nn\t3\Flexform->insertOptions</itemsProcFunc>
	    <typoscriptPath>plugin.tx_extname.settings.templates</typoscriptPath>
	    <!-- Alternativ: Settings aus PageTSConfig laden: -->
	    <pageconfigPath>tx_extname.colors</pageconfigPath>
	    <insertEmpty>1</insertEmpty>
	    <hideKey>1</hideKey>
	</config>

Beim Typoscript sind verschiedene Arten des Aufbaus erlaubt:

.. code-block:: php

	plugin.tx_extname.settings.templates {
	    # Direkte key => label Paare
	    small = Small Design
	    # ... oder: Label im Subarray gesetzt
	    mid {
	        label = Mid Design
	    }
	    # ... oder: Key im Subarray gesetzt, praktisch z.B. für CSS-Klassen
	    10 {
	        label = Big Design
	        classes = big big-thing
	    }
	    # ... oder eine userFunc. Gibt eine der Varianten oben als Array zurück
	    30 {
	        userFunc = nn\t3\Flexform->getOptions
	    }
	}

Die Auswahl kann im TypoScript auf bestimmte Controller-Actions beschränkt werden.
In diesem Beispiel wird die Option "Gelb" nur angezeigt, wenn in der ``switchableControllerAction``
| ``Category->list`` gewählt wurde.

.. code-block:: php

	plugin.tx_extname.settings.templates {
	    yellow {
	        label = Gelb
	        controllerAction = Category->list,...
	    }
	}

| ``@return array``

\\nn\\t3::Flexform()->parse(``$xml = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Wandelt ein Flexform-XML in ein Array um

.. code-block:: php

	\nn\t3::Flexform()->parse('<?xml...>');

Existiert auch als ViewHelper:

.. code-block:: php

	{rawXmlString->nnt3:parse.flexForm()->f:debug()}

| ``@return array``

