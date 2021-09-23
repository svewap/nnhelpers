
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Format\CodeViewHelper:

=======================================
format.code
=======================================

Description
---------------------------------------

<nnt3:format.code />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Highlighted code sections via PrismJS.

The code can be made available for direct download via ``download``.

The file is generated dynamically via JS and streamed – no additional files are created on the server.
nnhelpers uses this feature to offer the boilerplates as a download.

More info at: https://prismjs.com/

Build: https://bit.ly/3BLqmx0

.. code-block:: php

	<nnt3:format.code lang="css" download="rte.css">
	  ... Markup ...
	</nnt3:format.code>
	
	<nnt3:format.code lang="none">
	  ... markup ...
	</nnt3:format.code>

| ``@return string``

