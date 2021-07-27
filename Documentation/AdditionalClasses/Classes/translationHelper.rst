
.. include:: ../../Includes.txt

.. _TranslationHelper:

==============================================
TranslationHelper
==============================================

\\nn\\t3::TranslationHelper()
----------------------------------------------

Übersetzungsmanagement per Deep-L.

For this feature to be usable, a Deep-L api key must be stored in the extension manager of ``nnhelpers``
The key is free of charge and allows the Übersetzung of 500,000 characters per month.

.. code-block:: php

	// &Enable translator.
	$translationHelper = \nn\t3::injectClass( \Nng\Nnhelpers\Helpers\TranslationHelper::class );
	
	// &allow translation via Deep-L
	$translationHelper->setEnableApi( true );
	// set target language
	$translationHelper->setTargetLanguage( 'EN' );
	
	// Max. Allow maximum number of translations (for debugging)
	$translationHelper->setMaxTranslations( 2 );
	
	// path where to store / cache the l18n files
	$translationHelper->setL18nFolderpath( 'EXT:nnhelpers/Resources/Private/Language/' );
	
	// Üstart translation
	$text = $translationHelper->translate('my.example.key', 'This is the text to be ütranslated');

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::TranslationHelper()->createKeyHash(``$param = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Creates a unique hash from the key needed to identify a text.
Each text has the same key in all languages.

.. code-block:: php

	$translationHelper->createKeyHash( '12345' );
	$translationHelper->createKeyHash( ['my', 'key', 'array'] );

| ``@return string``

\\nn\\t3::TranslationHelper()->createTextHash(``$text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Creates a unique hash / checksum from the text.
The supplied text is always the base language. If the text in the base language changes, the method returns a different checksum.
This recognizes when a text needs to be retranslated. Pure üchanges to whitespaces and tags are ignored.

.. code-block:: php

	$translationHelper->createKeyHash( '12345' );
	$translationHelper->createKeyHash( ['my', 'key', 'array'] );

| ``@return string``

\\nn\\t3::TranslationHelper()->getEnableApi();
"""""""""""""""""""""""""""""""""""""""""""""""

Returns whether the API is enabled

.. code-block:: php

	$translationHelper->getEnableApi(); // default: false

| ``@return boolean``

\\nn\\t3::TranslationHelper()->getL18nFolderpath();
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the current folder where the &translation files are cached.
Default is ``typo3conf/l10n/nnhelpers/``

.. code-block:: php

	$translationHelper->getL18nFolderpath();

| ``@return string``

\\nn\\t3::TranslationHelper()->getL18nPath();
"""""""""""""""""""""""""""""""""""""""""""""""

Return the absolute path to the l18n cache file.
Default is ``typo3conf/l10n/nnhelpers/[LANG].autotranslated.json``

.. code-block:: php

	$translationHelper->getL18nPath();

| ``@return string``

\\nn\\t3::TranslationHelper()->getMaxTranslations();
"""""""""""""""""""""""""""""""""""""""""""""""

Gets the maximum number of &um;translations to be made per instance.

.. code-block:: php

	$translationHelper->getMaxTranslations(); // default: 0 = infinite

| ``@return integer``

\\nn\\t3::TranslationHelper()->getTargetLanguage();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the target language for the translation

.. code-block:: php

	$translationHelper->getTargetLanguage(); // Default: EN

| ``@return string``

\\nn\\t3::TranslationHelper()->loadL18nData();
"""""""""""""""""""""""""""""""""""""""""""""""

Load complete language file.

.. code-block:: php

	$translationHelper->loadL18nData();

| ``@return array``

\\nn\\t3::TranslationHelper()->saveL18nData(``$data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Save complete language file

.. code-block:: php

	$translationHelper->saveL18nData( $data );

| ``@return boolean``

\\nn\\t3::TranslationHelper()->setEnableApi(``$enableApi``);
"""""""""""""""""""""""""""""""""""""""""""""""

Enables / disables Ütranslation via Deep-L.

.. code-block:: php

	$translationHelper->setEnableApi( true ); // default: false

| ``@param boolean $enableApi``
| ``@return self``

\\nn\\t3::TranslationHelper()->setL18nFolderpath(``$l18nFolderpath``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sets the current folder where the ¨translation files are cached.
Idea is to ütranslate the ütranslated texts for backend modules only 1x and then store them in the extension folder.
From there they will be deployed to GIT.

Default is ``typo3conf/l10n/nnhelpers/``

.. code-block:: php

	$translationHelper->setL18nFolderpath('EXT:myext/Resources/Private/Language/');

| ``@param string $l``18nFolderpath Path to the folder containing the ¨translation files (JSON).
| ``@return self``

\\nn\\t3::TranslationHelper()->setMaxTranslations(``$maxTranslations``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sets the maximum number of translations to be done per instance.
Helps with debugging (so that the Deep-L quota is not exhausted by testing) and with timeouts when a lot of text needs to be translated.

.. code-block:: php

	$translationHelper->setMaxTranslations( 5 ); // Abort after 5 ¨translations

| ``@param $maxTranslations``
| ``@return self``

\\nn\\t3::TranslationHelper()->setTargetLanguage(``$targetLanguage``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sets the target language for the &um;translation

.. code-block:: php

	$translationHelper->setTargetLanguage( 'FR' );

| ``@param string $targetLanguage`` Target language of the ¨translation.
| ``@return self``

\\nn\\t3::TranslationHelper()->translate(``$key, $text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

&Translate a text.

.. code-block:: php

	$translationHelper = \nn\t3::injectClass( \Nng\Nnhelpers\Helpers\TranslationHelper::class );
	$translationHelper->setEnableApi( true );
	$translationHelper->setTargetLanguage( 'EN' );
	$text = $translationHelper->translate('my.example.key', 'This is the text to be ütranslated');

| ``@return string``

