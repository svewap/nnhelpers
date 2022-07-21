
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

\\nn\\t3::LL()->get(``$id = '', $extensionName = '', $args = [], $explode = '', $langKey = NULL, $altLangKey = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Localization für einen bestimmten Key holen.

Verwendet die Übersetzungen, die im ``xlf`` einer Extension angegeben sind.
Diese Dateien liegen standardmäßig unter ``EXT:extname/Resources/Private/Language/locallang.xlf``
bzw. ``EXT:extname/Resources/Private/Language/de.locallang.xlf`` für die jeweilige Übersetzung.

.. code-block:: php

	// Einfaches Beispiel:
	\nn\t3::LL()->get(''LLL:EXT:myext/Resources/Private/Language/locallang_db.xlf:my.identifier');
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress');
	
	// Argumente im String ersetzen: 'Nach der %s kommt die %s' oder `Vor der %2$s kommt die %1$s'
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress', ['eins', 'zwei']);
	
	// explode() des Ergebnisses an einem Trennzeichen
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress', null, ',');
	
	// In andere Sprache als aktuelle Frontend-Sprache übersetzen
	\nn\t3::LL()->get('tx_nnaddress_domain_model_entry', 'nnaddress', null, null, 'en');
	\nn\t3::LL()->get('LLL:EXT:myext/Resources/Private/Language/locallang_db.xlf:my.identifier', null, null, null, 'en');

| ``@param string $id``
| ``@param string $extensionName``
| ``@param array $args``
| ``@param string $explode``
| ``@param string $langKey``
| ``@param string $altLangKey``
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

