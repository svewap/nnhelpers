
.. include:: ../Includes.txt

.. _Content:

============
Content
============

\\nn\\t3::Content()
---------------

Read and render content elements and content of a backend column (``colPos``)
.

Overview of Methods
~~~~~~~~~~~~~~~~

\\nn\\t3::Content()->get(``$ttContentUid = NULL, $getRelations = false``);
""""""""""""""""

Lädt a tt_content element as an array

.. code-block:: php

	\nn\t3::Content()->get( 1201 );

Loading relations (``media``, ``assets``, ...)

.. code-block:: php

	\nn\t3::Content()->get( 1201, true );

| ``@return array``

\\nn\\t3::Content()->addRelations(``$data = []``);
""""""""""""""""

L&l;dt relations (``media``, ``assets``, ...) to a ``tt_content`` data array.
Uses an ``EXT:mask`` method for this.

.. code-block:: php

	\nn\t3::Content()->addRelations( $data );

@todo: Decouple from mask.
| ``@return array``

\\nn\\t3::Content()->render(``$ttContentUid = NULL, $data = []``);
""""""""""""""""

Renders an ``tt_content`` element as HTML

.. code-block:: php

	\nn\t3::Content()->render( 1201 );
	\nn\t3::Content()->render( 1201, ['key'=>'value'] );

Also available as a ViewHelper:

.. code-block:: php

	{nnt3:contentElement(uid:123, data:feUser.data)}

| ``@return string``

\\nn\\t3::Content()->column(``$colPos, $pageUid = NULL``);
""""""""""""""""

Lädt the content for a given column (``colPos``) and page.
If no pageUid is specified, it uses the current page.

.. code-block:: php

	\nn\t3::Content()->column( 110 );
	\nn\t3::Content()->column( $colPos, $pageUid );

Also available as a ViewHelper:

.. code-block:: php

	{nnt3:content.column(colPos:110)}
	{nnt3:content.column(colPos:110, pid:99)}

| ``@return string``

\\nn\\t3::Content()->columnData(``$colPos, $addRelations = false, $pageUid = NULL``);
""""""""""""""""

Lädt the "raw" ``tt_content`` data of a given column (``colPos``).

.. code-block:: php

	\nn\t3::Content()->columnData( 110 );
	\nn\t3::Content()->columnData( 110, true );
	\nn\t3::Content()->columnData( 110, true, 99 );

Also present as ViewHelper.
| ``relations`` defaults to ``TRUE``
 in ViewHelper.

.. code-block:: php

	{nnt3:content.columnData(colPos:110)}
	{nnt3:content.columnData(colPos:110, pid:99, relations:0)}

| ``@return array``

