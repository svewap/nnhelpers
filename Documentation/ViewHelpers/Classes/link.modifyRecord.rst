
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Link\ModifyRecordViewHelper:

=======================================
link.modifyRecord
=======================================

Description
---------------------------------------

<nnt3:link.modifyRecord />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Generate link to &change specific fields of a record in a backend module.

Examples: Set the "locked" field to 1

.. code-block:: php

	<nnt3:link.modifyRecord update="{locked:1}" uid="{item.uid}" table="tx_myext_domain_model_entry">
	    <i class="fas fa-eye"></i>
	</nnt3:link.modifyRecord>

