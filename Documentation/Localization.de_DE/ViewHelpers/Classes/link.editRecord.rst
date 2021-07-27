
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Link\EditRecordViewHelper:

=======================================
link.editRecord
=======================================

Description
---------------------------------------

<nnt3:link.editRecord />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Link zum Editieren eines Datensatzes in einem Backend-Modul generieren.

.. code-block:: php

	<nnt3:link.editRecord uid="{item.uid}" data="{ajax:1}" table="tx_myext_domain_model_entry" returnUrl="...">
	    <i class="fas fa-eye"></i>
	</nnt3:link.editRecord>

Alternativ kann auch der Core-ViewHelper genutzt werden:

.. code-block:: php

	{namespace be=TYPO3\CMS\Backend\ViewHelpers}
	<be:link.editRecord uid="42" table="a_table" returnUrl="foo/bar" />

