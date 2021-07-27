
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Ts\PageViewHelper:

=======================================
ts.page
=======================================

Description
---------------------------------------

<nnt3:ts.page />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Get value from PageTSconfig.

Easily and directly access from within the fluid template - regardless of the extension rendering the template.

.. code-block:: php

	{nnt3:ts.page(path:'path.zum.page.config')}
	{nnt3:ts.page(path:'path.zum.page', key:'config')}
	{nnt3:ts.page(path:'path.zum.page.{dynamicKey}.whatever')}

| ``@return mixed``

