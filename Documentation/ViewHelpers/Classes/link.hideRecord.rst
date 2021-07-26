
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Link\HideRecordViewHelper:

=======================================
link.hideRecord
=======================================

Description
---------------------------------------

<nnt3:link.hideRecord />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Generate a link to hide / make visible a record in a backend module.

Link to hide a record:

.. code-block:: php

	<nnt3:link.hideRecord uid="{item.uid}" data="{ajax:1}" table="tx_myext_domain_model_entry" hidden="1">
	    <i class="fas fa-eye"></i>
	</nnt3:link.hideRecord>

Link to show/hide toggle a record:

.. code-block:: php

	<nnt3:link.hideRecord uid="{item.uid}" data="{ajax:1}" table="tx_myext_domain_model_entry" visible="{item.hidden}">
	    <i class="fas fa-toggle"></i>
	</nnt3:link.hideRecord>

