
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Link\ModifyRecordViewHelper:

=======================================
link.modifyRecord
=======================================

Description
---------------------------------------

<nnt3:link.modifyRecord />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Link zum Ändern von bestimmten Feldern eines Datensatzes in einem Backend-Modul generieren.

Beispiele: Das Feld "locked" auf 1 setzen

.. code-block:: php

	<nnt3:link.modifyRecord update="{locked:1}" uid="{item.uid}" table="tx_myext_domain_model_entry">
	    <i class="fas fa-eye"></i>
	</nnt3:link.modifyRecord>

