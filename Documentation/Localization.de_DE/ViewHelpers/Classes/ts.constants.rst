
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Ts\ConstantsViewHelper:

=======================================
ts.constants
=======================================

Description
---------------------------------------

<nnt3:ts.constants />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Wert aus den TypoScript-Constants holen.

Einfacher und direkter Zugriff aus dem Fluid-Template heraus - unabhängig von der Extension, die das Template rendert.

.. code-block:: php

	{nnt3:ts.constants(path:'pfad.zur.constant')}
	{nnt3:ts.constants(path:'pfad.zur', key:'constant')}
	{nnt3:ts.constants(path:'pfad.{dynamicKey}.whatever')}

| ``@return mixed``

