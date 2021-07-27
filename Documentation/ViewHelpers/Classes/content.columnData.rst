
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Content\ColumnDataViewHelper:

=======================================
content.columnData
=======================================

Description
---------------------------------------

<nnt3:content.columnData />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Lädt the raw data of a column (colPos) from the backend layout.

This is the raw ``tt_content`` data array of a column (colPos) from the backend layout.
By default, the relations (FAL, assets, media...) are also loaded. Can be prevented via ``relations:0``.

.. code-block:: php

	{nnt3:content.columnData(colPos:110)}
	{nnt3:content.columnData(colPos:110, pid:99, relations:0)}

| ``@return array``

