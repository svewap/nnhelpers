
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\File\ExistsViewHelper:

=======================================
file.exists
=======================================

Description
---------------------------------------

<nnt3:file.exists />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Prüft, ob eine Datei existiert.

.. code-block:: php

	{nnt3:file.exists(file:'pfad/zum/bild.jpg')}

.. code-block:: php

	<f:if condition="!{nnt3:file.exists(file:'pfad/zum/bild.jpg')}">
	  Wo ist das Bild hin?
	</f:if>

| ``@return boolean``

