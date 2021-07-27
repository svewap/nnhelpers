
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Ts\ConstantsViewHelper:

=======================================
ts.constants
=======================================

Description
---------------------------------------

<nnt3:ts.constants />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Get value from TypoScript constants.

Easy and direct access from within the fluid template - regardless of the extension rendering the template.

.. code-block:: php

	{nnt3:ts.constants(path:'path.zur.constant')}
	{nnt3:ts.constants(path:'path.zur', key:'constant')}
	{nnt3:ts.constants(path:'path.{dynamicKey}.whatever')}

| ``@return mixed``

