
.. include:: ../../Includes.txt

.. _LL:

==============================================
LL
==============================================

\\nn\\t3::LL()
----------------------------------------------

Wrapper for methods around the localization of Typo3

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::LL()->get(``$id = '', $extensionName = '', $args = [], $explode = '', $langKey = NULL, $altLangKey = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get localization for a specific key

Uses the translations specified in the ``xlf`` of an extension.
These files are located by default in ``EXT:extname/Resources/Private/Language/locallang.xlf``
or ``EXT:extname/Resources/Private/Language/en.locallang.xlf`` for the respective translation.

.. code-block:: php

	// Simple example:
	\nn\t3::LL()->get(''LLL:EXT:myext/Resources/Private/Language/locallang_db.xlf:my.identifier');
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress');
	
	// Replace arguments in string: 'After the %s comes the %s' or 'Before the %2$s comes the %1$s'.
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress', ['one', 'two']);
	
	// explode() the result at a separator character
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress', null, ',');
	
	// Translate to a language other than the current frontend language.
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress', null, null, 'en');
	\nn\t3::LL()->get('LLL:EXT:myext/Resources/Private/Language/locallang_db.xlf:my.identifier', null, null, 'en');

| ``@param string $id``
| ``@param string $extensionName``
| ``@param array $args``
| ``@param string $explode``
| ``@param string $langKey``
| ``@param string $altLangKey``
| ``@return mixed``

\\nn\\t3::LL()->translate(``$srcText = '', $targetLanguageKey = 'EN', $sourceLanguageKey = 'DE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Übersetzt a text via DeepL.
An API key must be entered in the Extension Manager.
DeepL allows the ¨translation of up to 500,000 characters / month for free.

.. code-block:: php

	\nn\t3::LL()->translate( 'The horse doesn't eat cucumber salad' );
	\nn\t3::LL()->translate( 'The horse does not eat cucumber salad', 'EN' );
	\nn\t3::LL()->translate( 'The horse doesn't eat cucumber salad', 'EN', 'DE' );

| ``@return string``

