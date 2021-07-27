
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\TranslateViewHelper:

=======================================
translate
=======================================

Description
---------------------------------------

<nnt3:translate />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Einen Text übersetzen, inkl. optionaler Übersetzung über Deep-L.

Siehe auch Doku zu ``TranslationHelper`` für die Einbindung über PHP oder einen Controller.

.. code-block:: php

	// Übersetzung über locallang.xlf
	{mytext->nnt3:translate(id:'LLL:EXT:nnaddress/Resources/Private/Language/locallang_db.xlf:my-ll-id')}
	{mytext->nnt3:translate(id:'my-ll-id', extensionName:'nnaddress')}

.. code-block:: php

	// Übersetzung per Deep-L
	{nnt3:translate(id:'my-ll-id', text:'Der Text', extensionName:'nnaddress', enableApi:1, translate:1, targetLang:'EN', maxTranslations:2)}
	{mytext->nnt3:translate(id:'my-ll-id', extensionName:'nnaddress', enableApi:1, translate:1, targetLang:'EN', maxTranslations:2)}
	{mytext->nnt3:translate(id:'my-ll-id', enableApi:1, translate:1, targetLang:'EN', cacheFolder:'EXT:nnsite/path/to/somewhere/')}
	{mytext->nnt3:translate(id:'my-ll-id', enableApi:1, translate:1, targetLang:'EN', cacheFolder:'typo3conf/l10n/demo/')}

.. code-block:: php

	// Einen Block im Fluid-Template übersetzen
	<nnt3:translate id="text-id-or-cObj-uid" enableApi="1" translate="1" targetLang="EN">
	  <p>Ich werde automatisch übersetzt, inkl. aller <b>HTML</b>-Tags!</p>
	</nnt3:translate>

