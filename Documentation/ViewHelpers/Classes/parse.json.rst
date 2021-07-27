
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Parse\JsonViewHelper:

=======================================
parse.json
=======================================

Description
---------------------------------------

<nnt3:parse.json />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

See ``JsonHelper`` for examples.

.. code-block:: php

	{myConfig->nnt3:parse.json()->f:debug()}

.. code-block:: php

	<div data-config="{myConfig->nnt3:parse.json()->nnt3:format.attrEncode()}">
	  ...
	</div>

| ``@return mixed``

