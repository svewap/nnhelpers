
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Encrypt\HashViewHelper:

=======================================
encrypt.hash
=======================================

Description
---------------------------------------

<nnt3:encrypt.hash />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Generiert einen Hash aus einem String oder einer Zahl.

.. code-block:: php

	{secret->nnt3:encrypt.hash()}
	{nnt3:encrypt(value:secret)}

Hilfreich, falls z.B. eine Mail versendet werden soll mit Bestätigungs-Link.

Die UID des Datensatzes wird zusätzlich als Hash übergeben. Im Controller wird dann überprüft,
ob aus der übergeben ``uid`` der übergeben ``hash`` generiert werden kann.
Falls nicht, wurde die ``uid`` manipuliert.

.. code-block:: php

	<f:link.action action="validate" arguments="{uid:uid, checksum:'{uid->nnt3:encrypt.hash()}'}">
	  ...
	</f:link.action>

| ``@return string``

