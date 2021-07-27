
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Content\ColumnDataViewHelper:

=======================================
content.columnData
=======================================

Description
---------------------------------------

<nnt3:content.columnData />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Lädt die rohen Daten einer Spalte (colPos) des Backend Layouts.

Es handelt sich hier um das rohe ``tt_content``-data-Array einer Spalte (colPos) aus dem Backend-Layout.
Per default werden auch die Relationen (FAL, assets, media...) geladen. Kann per ``relations:0`` verhindert werden.

.. code-block:: php

	{nnt3:content.columnData(colPos:110)}
	{nnt3:content.columnData(colPos:110, pid:99, relations:0)}

| ``@return array``

