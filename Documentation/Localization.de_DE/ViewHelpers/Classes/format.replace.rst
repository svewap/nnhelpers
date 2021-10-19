
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Format\ReplaceViewHelper:

=======================================
format.replace
=======================================

Description
---------------------------------------

<nnt3:format.replace />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Text in einem String suchen und ersetzen.

.. code-block:: php

	{nnt3:format.replace(str:'alles schön im Juli.', from:'Juli', to:'Mai')}
	{varname->nnt3:format.replace(from:'Juli', to:'Mai')}

| ``@return string``

