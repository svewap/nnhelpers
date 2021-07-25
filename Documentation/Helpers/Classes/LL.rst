
.. include:: ../Includes.txt

.. _LL:

============
LL
============

\\nn\\t3::LL()
---------------

Wrapper for methods around the localization of Typo3

Overview of Methods
~~~~~~~~~~~~~~~~

\\nn\\t3::LL()->get(``$id = '', $extensionName = '', $args = [], $explode = ''``);
""""""""""""""""

Get localization for a key.
Key can be:

.. code-block:: php

	\nn\t3::LL()->get('LLL:EXT:nnaddress/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_entry');
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress');

| ``@return mixed``

\\nn\\t3::LL()->translate(``$srcText = '', $targetLanguageKey = 'EN', $sourceLanguageKey = 'DE'``);
""""""""""""""""

Übersetzt a text via DeepL.
An API key must be entered in the Extension Manager.
DeepL allows the ¨translation of up to 500,000 characters / month free of charge.

.. code-block:: php

	\nn\t3::LL()->translate( 'The horse doesn't eat cucumber salad' );
	\nn\t3::LL()->translate( 'The horse does not eat cucumber salad', 'EN' );
	\nn\t3::LL()->translate( 'The horse doesn't eat cucumber salad', 'EN', 'DE' );

| ``@return string``

