
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Ts\SetupViewHelper:

=======================================
ts.setup
=======================================

Description
---------------------------------------

<nnt3:ts.setup />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Get value from the TypoScript setup.

Easy and direct access from within the fluid template - regardless of the extension rendering the template.

.. code-block:: php

	{nnt3:ts.setup(path:'path.to.typoscript.setup')}
	{nnt3:ts.setup(path:'path.zum.typoscript', key:'setup')}
	{nnt3:ts.setup(path:'path.zum.typoscript.{dynamicKey}.whatever')}

| ``@return mixed``

