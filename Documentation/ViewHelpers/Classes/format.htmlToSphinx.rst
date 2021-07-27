
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Format\HtmlToSphinxViewHelper:

=======================================
format.htmlToSphinx
=======================================

Description
---------------------------------------

<nnt3:format.htmlToSphinx />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Converts HTML tags to Sphinx syntax for TER documentation.

.. code-block:: php

	{annotation->f:format.raw()->nnt3:format.htmlToSphinx()}

From the following code ...

.. code-block:: php

	<nnt3:format.htmlToSphinx>
	  <p>This is a description of this method</p>
	  <pre><code>$a = 99;</code></pre>
	</nnt3:format.htmlToSphinx>

this is what is rendered:

.. code-block:: php

	This is a description of that method.
	
	.. code-block:: php
	
	   $a = 99;

| ``@return string``

