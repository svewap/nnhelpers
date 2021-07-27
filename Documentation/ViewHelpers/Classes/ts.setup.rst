
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Ts\SetupViewHelper:

=======================================
ts.setup
=======================================

Description
---------------------------------------

<nnt3:ts.setup />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Wert aus dem TypoScript-Setup holen.

Einfacher und direkter Zugriff aus dem Fluid-Template heraus - unabhängig von der Extension, die das Template rendert.

.. code-block:: php

	{nnt3:ts.setup(path:'pfad.zum.typoscript.setup')}
	{nnt3:ts.setup(path:'pfad.zum.typoscript', key:'setup')}
	{nnt3:ts.setup(path:'pfad.zum.typoscript.{dynamicKey}.whatever')}

| ``@return mixed``

