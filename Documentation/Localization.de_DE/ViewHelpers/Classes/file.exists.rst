
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\File\ExistsViewHelper:

=======================================
file.exists
=======================================

Description
---------------------------------------

<nnt3:file.exists />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Checks if a file exists

.. code-block:: php

	{nnt3:file.exists(file:'path/to/image.jpg')}

.. code-block:: php

	<f:if condition="!{nnt3:file.exists(file:'path/to/image.jpg')}">
	  Where did the image go?
	</f:if>

| ``@return boolean``

