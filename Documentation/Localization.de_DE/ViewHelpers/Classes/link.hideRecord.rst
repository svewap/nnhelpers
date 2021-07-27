
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Link\HideRecordViewHelper:

=======================================
link.hideRecord
=======================================

Description
---------------------------------------

<nnt3:link.hideRecord />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Link zum Verstecken / Sichtbar machen eines Datensatzes in einem Backend-Modul generieren.

Link zum Verstecken eines Datensatzes:

.. code-block:: php

	<nnt3:link.hideRecord uid="{item.uid}" data="{ajax:1}" table="tx_myext_domain_model_entry" hidden="1">
	    <i class="fas fa-eye"></i>
	</nnt3:link.hideRecord>

Link zum show/hide-Toggle eines Datensatzes:

.. code-block:: php

	<nnt3:link.hideRecord uid="{item.uid}" data="{ajax:1}" table="tx_myext_domain_model_entry" visible="{item.hidden}">
	    <i class="fas fa-toggle"></i>
	</nnt3:link.hideRecord>

