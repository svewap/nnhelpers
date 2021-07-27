
.. include:: ../../Includes.txt

.. _LL:

==============================================
LL
==============================================

\\nn\\t3::LL()
----------------------------------------------

Wrapper für Methoden rund um die Localization von Typo3

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::LL()->get(``$id = '', $extensionName = '', $args = [], $explode = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Localization für einen Key holen.
Key kann sein:

.. code-block:: php

	\nn\t3::LL()->get('LLL:EXT:nnaddress/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_entry');
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress');

| ``@return mixed``

\\nn\\t3::LL()->translate(``$srcText = '', $targetLanguageKey = 'EN', $sourceLanguageKey = 'DE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Übersetzt einen Text per DeepL.
Ein API-Key muss im Extension Manager eingetragen werden.
DeepL erlaubt die Übersetzung von bis zu 500.000 Zeichen / Monat kostenfrei.

.. code-block:: php

	\nn\t3::LL()->translate( 'Das Pferd isst keinen Gurkensalat' );
	\nn\t3::LL()->translate( 'Das Pferd isst keinen Gurkensalat', 'EN' );
	\nn\t3::LL()->translate( 'Das Pferd isst keinen Gurkensalat', 'EN', 'DE' );

| ``@return string``

