
.. include:: ../../Includes.txt

.. _TypoScript:

==============================================
TypoScript
==============================================

\\nn\\t3::TypoScript()
----------------------------------------------

Methods for parsing and converting TypoScript
.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::TypoScript()->addPageConfig(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

addPageConfig.
Alias to ``\nn\t3::Registry()->addPageConfig( $str );``

.. code-block:: php

	\nn\t3::TypoScript()->addPageConfig( 'test.was = 10' );
	\nn\t3::TypoScript()->addPageConfig( '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:extname/Configuration/TypoScript/page.txt">' );
	\nn\t3::TypoScript()->addPageConfig( '@import "EXT:extname/Configuration/TypoScript/page.ts"' );

| ``@return void``

\\nn\\t3::TypoScript()->convertToPlainArray(``$ts``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert TypoScript 'name.' syntax to normal array.
Makes it easier to access

.. code-block:: php

	\nn\t3::TypoScript()->convertToPlainArray(['example'=>'test', 'example.'=>'here']);

| ``@return array``

\\nn\\t3::TypoScript()->fromString(``$str = '', $overrideSetup = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a text into a TypoScript array

.. code-block:: php

	\nn\t3::TypoScript()->fromString( 'lib.test { example = 10 }' ); => ['lib'=>['test'=>['example'=>10]]
	\nn\t3::TypoScript()->fromString( 'lib.test { example = 10 }', $mergeSetup );

| ``@return array``

