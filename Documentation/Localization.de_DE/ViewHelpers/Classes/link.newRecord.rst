
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Link\NewRecordViewHelper:

=======================================
link.newRecord
=======================================

Description
---------------------------------------

<nnt3:link.newRecord />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Link zum Erstellen eines neuen Datensatzes in einem Backend-Modul generieren.

.. code-block:: php

	<nnt3:link.newRecord afterUid="{item.uid}" pid="" table="tx_myext_domain_model_entry" returnUrl="...">
	    <i class="fas fa-plus"></i>
	</nnt3:link.newRecord>

Alternativ kann auch der Core-ViewHelper genutzt werden:

.. code-block:: php

	{namespace be=TYPO3\CMS\Backend\ViewHelpers}
	<be:link.newRecord uid="42" table="a_table" returnUrl="foo/bar" />

