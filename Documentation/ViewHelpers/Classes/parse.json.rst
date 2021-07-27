
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Parse\JsonViewHelper:

=======================================
parse.json
=======================================

Description
---------------------------------------

<nnt3:parse.json />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Wandelt ein normales JavaScript-Object, dass als String übergeben wird in ein Array um.
Erlaubt es, Konfigurationen für Slider und andere JS-Bibliotheken im TypoScript anzulegen und später per JS zu parsen.

Siehe ``JsonHelper`` für Beispiele.

.. code-block:: php

	{myConfig->nnt3:parse.json()->f:debug()}

.. code-block:: php

	<div data-config="{myConfig->nnt3:parse.json()->nnt3:format.attrEncode()}">
	  ...
	</div>

| ``@return mixed``

