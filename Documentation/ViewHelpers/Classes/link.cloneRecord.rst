
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Link\CloneRecordViewHelper:

=======================================
link.cloneRecord
=======================================

Description
---------------------------------------

<nnt3:link.cloneRecord />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Generate link to clone a record for a backend module.

Insert on same page as original element:

.. code-block:: php

	<nnt3:link.cloneRecord uid="{item.uid}" pid="{item.pid}" table="tx_myext_domain_model_entry" override="{title:'{item.title} (copy)'}">
	    <i class="fas fa-copy"></i>
	</nnt3:link.cloneRecord>

Insert on same page as original element, directly after orignal element:

.. code-block:: php

	<nnt3:link.cloneRecord uid="{item.uid}" after="{item.uid}" table="tx_myext_domain_model_entry" override="{title:'{item.title} (copy)'}">
	    <i class="fas fa-copy"></i>
	</nnt3:link.cloneRecord>

