
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\TranslateViewHelper:

=======================================
translate
=======================================

Description
---------------------------------------

<nnt3:translate />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Translate a text, including optional translation via Deep-L.

See also docs for ``TranslationHelper`` for integration üvia PHP or a controller.

.. code-block:: php

	// Übersetzung per Deep-L
	{nnt3:translate(id:'my-ll-id', text:'The Text', extensionName:'nnaddress', enableApi:1, translate:1, targetLang:'EN', maxTranslations:2)}
	{mytext->nnt3:translate(id:'my-ll-id', extensionName:'nnaddress', enableApi:1, translate:1, targetLang:'EN', maxTranslations:2)}
	{mytext->nnt3:translate(id:'my-ll-id', enableApi:1, translate:1, targetLang:'EN', cacheFolder:'EXT:nnsite/path/to/somewhere/')}
	{mytext->nnt3:translate(id:'my-ll-id', enableApi:1, translate:1, targetLang:'EN', cacheFolder:'typo3conf/l10n/demo/')}

.. code-block:: php

	// Translate a block in the fluid template übersetzen.
	<nnt3:translate id="text-id-or-cObj-uid" enableApi="1" translate="1" targetLang="EN">
	  <p>I will automatically <translate, including all <b>HTML</b>tags!</p>
	</nnt3:translate>

