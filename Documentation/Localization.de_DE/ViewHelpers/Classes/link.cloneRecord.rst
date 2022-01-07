
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Link\CloneRecordViewHelper:

=======================================
link.cloneRecord
=======================================

Description
---------------------------------------

<nnt3:link.cloneRecord />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Link zum Klonen eines Datensatzes für ein Backend-Modul generieren.

Auf gleicher Seite wie Original-Element einfügen:

.. code-block:: php

	<nnt3:link.cloneRecord uid="{item.uid}" pid="{item.pid}" table="tx_myext_domain_model_entry" override="{title:'{item.title} (Kopie)'}">
	    <i class="fas fa-copy"></i>
	</nnt3:link.cloneRecord>

Auf gleicher Seite wie Original-Element einfügen, direkt hinter das Orignal-Element:

.. code-block:: php

	<nnt3:link.cloneRecord uid="{item.uid}" after="{item.uid}" table="tx_myext_domain_model_entry" override="{title:'{item.title} (Kopie)'}">
	    <i class="fas fa-copy"></i>
	</nnt3:link.cloneRecord>

