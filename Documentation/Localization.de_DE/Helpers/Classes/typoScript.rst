
.. include:: ../../Includes.txt

.. _TypoScript:

==============================================
TypoScript
==============================================

\\nn\\t3::TypoScript()
----------------------------------------------

Methoden zum Parsen und Konvertieren von TypoScript

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::TypoScript()->addPageConfig(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Page-Config hinzufügen
Alias zu ``\nn\t3::Registry()->addPageConfig( $str );``

.. code-block:: php

	\nn\t3::TypoScript()->addPageConfig( 'test.was = 10' );
	\nn\t3::TypoScript()->addPageConfig( '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:extname/Configuration/TypoScript/page.txt">' );
	\nn\t3::TypoScript()->addPageConfig( '@import "EXT:extname/Configuration/TypoScript/page.ts"' );

| ``@return void``

\\nn\\t3::TypoScript()->convertToPlainArray(``$ts``);
"""""""""""""""""""""""""""""""""""""""""""""""

TypoScript 'name.'-Syntax in normales Array umwandeln.
Erleichtert den Zugriff

.. code-block:: php

	\nn\t3::TypoScript()->convertToPlainArray(['example'=>'test', 'example.'=>'here']);

| ``@return array``

\\nn\\t3::TypoScript()->fromString(``$str = '', $overrideSetup = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Wandelt einen Text in ein TypoScript-Array um.

.. code-block:: php

	\nn\t3::TypoScript()->fromString( 'lib.test { beispiel = 10 }' );    => ['lib'=>['test'=>['beispiel'=>10]]]
	\nn\t3::TypoScript()->fromString( 'lib.test { beispiel = 10 }', $mergeSetup );

| ``@return array``

