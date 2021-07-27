
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\UniqidViewHelper:

=======================================
uniqid
=======================================

Description
---------------------------------------

<nnt3:uniqid />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Returns a unique, one-time ID.

Helpful e.g. for unique IDs or class names in fluid templates.

.. code-block:: php

	{nnt3:uniqid()}

.. code-block:: php

	<div id="box-{nnt3:uniqid()}"> ... </div>

| ``@return string``

