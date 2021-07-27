
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\UniqidViewHelper:

=======================================
uniqid
=======================================

Description
---------------------------------------

<nnt3:uniqid />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Gibt eine eindeutige, einmalige ID zurück.

Hilfreich z.B. für eindeutige IDs oder Klassen-Namen in Fluid-Templates.

.. code-block:: php

	{nnt3:uniqid()}

.. code-block:: php

	<div id="box-{nnt3:uniqid()}"> ... </div>

| ``@return string``

