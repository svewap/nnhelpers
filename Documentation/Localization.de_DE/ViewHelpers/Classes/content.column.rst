
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Content\ColumnViewHelper:

=======================================
content.column
=======================================

Description
---------------------------------------

<nnt3:content.column />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Rendert die Inhalte einer Spalte (colPos) des Backend Layouts.
Wird keine Seiten-ID über ``pid`` angegeben, verwendet er die aktuelle Seiten-ID.

.. code-block:: php

	{nnt3:content.column(colPos:110)}

Mit ``slide`` werden die Inhaltselement der übergeordnete Seite geholt, falls auf der angegeben Seiten kein Inhaltselement in der Spalte existiert.

.. code-block:: php

	{nnt3:content.column(colPos:110, slide:1)}

Mit ``pid`` kann der Spalten-Inhalt einer fremden Seite gerendert werden:

.. code-block:: php

	{nnt3:content.column(colPos:110, pid:99)}

Slide funktioniert auch für fremde Seiten:

.. code-block:: php

	{nnt3:content.column(colPos:110, pid:99, slide:1)}

| ``@return string``

