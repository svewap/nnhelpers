
.. include:: ../../Includes.txt

.. _Content:

==============================================
Content
==============================================

\\nn\\t3::Content()
----------------------------------------------

Read and render content elements and content of a backend column (``colPos``)
.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Content()->addRelations(``$data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lädt relations (``media``, ``assets``, ...) to a ``tt_content`` data array.
If ``EXT:mask`` is installed, the corresponding method from mask is used.

.. code-block:: php

	\nn\t3::Content()->addRelations( $data );

| ``@return array``

\\nn\\t3::Content()->column(``$colPos, $pageUid = NULL, $slide = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lädt the content for a given column (``colPos``) and page.
If no pageUid is specified, it uses the current page.
With ``slide``, the content items of the üparent page are fetched if there is no content item in the column on the specified page.

Get content of ``colPos = 110`` from current page:

.. code-block:: php

	\nn\t3::Content()->column( 110 );

Get content of ``colPos = 110`` from the current page. If there is no content in the column on the current page, use the content from the üparent page:

.. code-block:: php

	\nn\t3::Content()->column( 110, true );

Get content of ``colPos = 110`` from page with id ``99``:

.. code-block:: php

	\nn\t3::Content()->column( 110, 99 );

Get content of ``colPos = 110`` from page with id ``99``. If there is no content in the column on page ``99``, use the content from the parent page of page ``99``:

.. code-block:: php

	\nn\t3::Content()->column( 110, 99, true );

Also available as ViewHelper:

.. code-block:: php

	{nnt3:content.column(colPos:110)}
	{nnt3:content.column(colPos:110, slide:1)}
	{nnt3:content.column(colPos:110, pid:99)}
	{nnt3:content.column(colPos:110, pid:99, slide:1)}

| ``@return string``

\\nn\\t3::Content()->columnData(``$colPos, $addRelations = false, $pageUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

\\nn\\t3::Content()->get(``$ttContentUid = NULL, $getRelations = false, $localize = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Loads the data of a tt_content element as a simple array:

.. code-block:: php

	\nn\t3::Content()->get( 1201 );

Load relations (``media``, ``assets``, ...)

.. code-block:: php

	\nn\t3::Content()->get( 1201, true );

Translations / Localization:

Do NOT translate element automatically if another language is set

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, false );

Get element in a OTHER language than the one set in the frontend.
Takes into account the fallback chain of the language set in the site config

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, 2 );

Get element with its own fallback chain. Completely ignores the chain,
defined in the site config.

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, [2,3,0] );

| ``@param int $ttContentUid`` Content Uid in table tt_content.
| ``@param bool $getRelations`` Also get relations / FAL?
| ``@param bool $localize`` Override the entry?
| ``@return array``

\\nn\\t3::Content()->getAll(``$constraints = [], $getRelations = false, $localize = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get multiple content elements (from ``tt_content``).

The records are automatically localized Ã¢ except ``$localize`` is set to ``false``
set. See ``nn\t3::Content()->get()`` for more ``$localize`` options.

Using a list of UIDs:

.. code-block:: php

	\nn\t3::Content()->getAll( 1 );
	\nn\t3::Content()->getAll( [1, 2, 7] );

Using filter criteria:

.. code-block:: php

	\nn\t3::Content()->getAll( ['pid'=>1] );
	\nn\t3::Content()->getAll( ['pid'=>1, 'colPos'=>1] );
	\nn\t3::Content()->getAll( ['pid'=>1, 'CType'=>'mask_section_cards', 'colPos'=>1] );

| ``@param mixed $ttContentUid`` Content uids or constraints for querying the data.
| ``@param bool $getRelations`` Also get relations / FAL?
| ``@param bool $localize`` Override the entry?
| ``@return array``

\\nn\\t3::Content()->localize(``$table = 'tt_content', $data = [], $localize = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Localize / translate data.

Examples:

Translate data, using the current language of the frontend.

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data );

Get data in a OTHER language than the one set in the frontend.
Takes into account the fallback chain of the language set in the site config

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data, 2 );

Get data with custom fallback chain. Completely ignores the chain,
defined in the site config.

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data, [3, 2, 0] );

| ``@param string $table`` database table.
| ``@param array $data`` Array containing the default language data (languageUid = 0).
| ``@param mixed $localize`` Specify how to translate. Boolean, uid or array with uids
| ``@return array``

\\nn\\t3::Content()->render(``$ttContentUid = NULL, $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Renders an ``tt_content`` element as HTML

.. code-block:: php

	\nn\t3::Content()->render( 1201 );
	\nn\t3::Content()->render( 1201, ['key'=>'value'] );

Also available as a ViewHelper:

.. code-block:: php

	{nnt3:contentElement(uid:123, data:feUser.data)}

| ``@return string``

