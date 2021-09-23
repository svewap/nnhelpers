
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Format\ReplaceViewHelper:

=======================================
format.replace
=======================================

Description
---------------------------------------

<nnt3:format.replace />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Find and replace text in a string.

.. code-block:: php

	{nnt3:format.replace(str:'all shön in July.', from:'July', to:'May')}
	{varname->nnt3:format.replace(from:'July', to:'May')}

| ``@return string``

