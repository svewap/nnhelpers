
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Link\DeleteRecordViewHelper:

=======================================
link.deleteRecord
=======================================

Description
---------------------------------------

<nnt3:link.deleteRecord />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Link zum Löschen eines Datensatzes für ein Backend-Modul generieren.

.. code-block:: php

	<nnt3:link.deleteRecord uid="{item.uid}" data="{ajax:1}" table="tx_myext_domain_model_entry">
	    <i class="fas fa-trash"></i>
	</nnt3:link.deleteRecord>

