
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Format\HtmlToSphinxViewHelper:

=======================================
format.htmlToSphinx
=======================================

Description
---------------------------------------

<nnt3:format.htmlToSphinx />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Konvertiert HTML-Tags zu Sphinx-Syntax für die TER Dokumentation.

.. code-block:: php

	{annotation->f:format.raw()->nnt3:format.htmlToSphinx()}

Aus folgendem Code ...

.. code-block:: php

	<nnt3:format.htmlToSphinx>
	  <p>Das ist eine Beschreibung dieser Methode</p>
	  <pre><code>$a = 99;</code></pre>
	</nnt3:format.htmlToSphinx>

wird das hier gerendert:

.. code-block:: php

	Das ist eine Beschreibung dieser Methode
	
	.. code-block:: php
	
	   $a = 99;

| ``@return string``

