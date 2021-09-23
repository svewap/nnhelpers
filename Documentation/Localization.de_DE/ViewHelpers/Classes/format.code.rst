
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Format\CodeViewHelper:

=======================================
format.code
=======================================

Description
---------------------------------------

<nnt3:format.code />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Highlighted code-Abschnitte per PrismJS.

Der Code kann über ``download`` zum direkten Download verfügbar gemacht werden.

Die Datei wird dabei dynamisch per JS generiert und gestreamt – es enstehen keine zusätzlichen Dateien auf dem Server.
nnhelpers nutzt diese Funktion, um die Boilerplates als Download anzubieten.

Mehr Infos unter: https://prismjs.com/

Build: https://bit.ly/3BLqmx0

.. code-block:: php

	<nnt3:format.code lang="css" download="rte.css">
	  ... Markup ...
	</nnt3:format.code>
	
	<nnt3:format.code lang="none">
	  ... Markup ...
	</nnt3:format.code>

| ``@return string``

