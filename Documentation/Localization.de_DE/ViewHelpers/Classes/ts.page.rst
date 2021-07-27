
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Ts\PageViewHelper:

=======================================
ts.page
=======================================

Description
---------------------------------------

<nnt3:ts.page />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Wert aus der PageTSconfig holen.

Einfacher und direkter Zugriff aus dem Fluid-Template heraus - unabhängig von der Extension, die das Template rendert.

.. code-block:: php

	{nnt3:ts.page(path:'pfad.zum.page.config')}
	{nnt3:ts.page(path:'pfad.zum.page', key:'config')}
	{nnt3:ts.page(path:'pfad.zum.page.{dynamicKey}.whatever')}

| ``@return mixed``

