
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Content\ColumnViewHelper:

=======================================
content.column
=======================================

Description
---------------------------------------

<nnt3:content.column />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Renders the contents of a column (colPos) of the backend layout.
If no page ID is specified üvia ``pid``, it uses the current page ID.

.. code-block:: php

	{nnt3:content.column(colPos:110)}

Use ``slide`` to fetch the content elements of the üparent page if there is no content element in the column on the specified pages.

.. code-block:: php

	{nnt3:content.column(colPos:110, slide:1)}

Use ``pid`` to render the column content of a foreign page:

.. code-block:: php

	{nnt3:content.column(colPos:110, pid:99)}

Slide also works for third-party pages:

.. code-block:: php

	{nnt3:content.column(colPos:110, pid:99, slide:1)}

| ``@return string``

