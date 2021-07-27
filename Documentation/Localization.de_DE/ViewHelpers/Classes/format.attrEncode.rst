
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Format\AttrEncodeViewHelper:

=======================================
format.attrEncode
=======================================

Description
---------------------------------------

<nnt3:format.attrEncode />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Masks "critical" characters so they can be used as an attribute to an HTML tag.

.. code-block:: php

	<div data-example="{something->nnt3:format.attrEncode()}"> ... </div>
	<a title="{title->nnt3:format.attrEncode()}"> ... </a>

| ``@return string``

