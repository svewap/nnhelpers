
.. include:: ../../Includes.txt

.. _Arrays:

==============================================
Arrays
==============================================

\\nn\\t3::Arrays()
----------------------------------------------

Various methods to work with arrays like merge, purge or remove empty values.
Methods to use a value of an associative array as a key.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Arrays()->first();
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the first element of the array, without array_shift()

.. code-block:: php

	\nn\t3::Arrays( $objArr )->first();

| ``@return array``

\\nn\\t3::Arrays()->intExplode(``$delimiter = ','``);
"""""""""""""""""""""""""""""""""""""""""""""""

Split a string – or array – at the separator, remove non-numeric
and remove empty elements

.. code-block:: php

	\nn\t3::Arrays('1,a,b,2,3')->intExplode(); // [1,2,3]
	\nn\t3::Arrays(['1','a','2','3'])->intExplode(); // [1,2,3]

| ``@return array``

\\nn\\t3::Arrays()->key(``$key = 'uid', $value = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Use a field in the array as the key of the array, e.g. to get a list,
whose key is always the UID of the associative array:

Example:

.. code-block:: php

	$arr = [['uid'=>'1', 'title'=>'title A'], ['uid'=>'2', 'title'=>'title B']];
	\nn\t3::Arrays($arr)->key('uid'); // ['1'=>['uid'=>'1', 'title'=>'Title A'], '2'=>['uid'=>'2', 'title'=>'Title B']]
	\nn\t3::Arrays($arr)->key('uid', 'title'); // ['1'=>'Title A', '2'=>'Title B']

| ``@return array``

\\nn\\t3::Arrays()->merge();
"""""""""""""""""""""""""""""""""""""""""""""""

Merge an associative array recursively with another array.

| ``$addKeys`` => if ``false``, only keys üare overwritten that also exist in ``$arr1``
| ``$includeEmptyValues`` => if ``true``, empty values in ``$arr1`` will be included as well
| ``$enableUnsetFeature`` => if ``true``, ``__UNSET`` can be used as a value in ``$arr2`` to delete a value in ``$arr1``

.. code-block:: php

	$mergedArray = \nn\t3::Arrays( $arr1 )->merge( $arr2, $addKeys, $includeEmptyValues, $enableUnsetFeature );
	$mergedArray = \nn\t3::Arrays( $arr1 )->merge( $arr2 );
	$mergedArray = \nn\t3::Arrays()->merge( $arr1, $arr2 );

| ``@return array``

\\nn\\t3::Arrays()->pluck(``$keys = NULL, $isSingleObject = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Reduce/distill associative array to specific elements:

.. code-block:: php

	\nn\t3::Arrays( $objArr )->key('uid')->pluck('title'); // ['1'=>'Title A', '2'=>'Title B']
	\nn\t3::Arrays( $objArr )->key('uid')->pluck(['title', 'bodytext']); // ['1'=>['title'=>'title A', 'bodytext'=>'content'], '2'=>...]
	\nn\t3::Arrays( ['uid'=>1, 'pid'=>2] )->pluck(['uid'], true); // ['uid'=>1]

| ``@return array``

\\nn\\t3::Arrays()->removeEmpty();
"""""""""""""""""""""""""""""""""""""""""""""""

Remove empty values from an array.

.. code-block:: php

	$clean = \nn\t3::Arrays( $arr1 )->removeEmpty();

| ``@return array``

\\nn\\t3::Arrays()->toArray();
"""""""""""""""""""""""""""""""""""""""""""""""

Returns this array object as a "normal" array.

.. code-block:: php

	\nn\t3::Arrays( $objArr )->key('uid')->toArray();

| ``@return array``

\\nn\\t3::Arrays()->trimExplode(``$delimiter = ',', $removeEmpty = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Split a string – or array – at the separator, remove empty elements.
Works with strings and arrays.

.. code-block:: php

	\nn\t3::Arrays('1,,2,3')->trimExplode(); // [1,2,3]
	\nn\t3::Arrays('1,,2,3')->trimExplode( false ); // [1,'',2,3]
	\nn\t3::Arrays('1|2|3')->trimExplode('|'); // [1,2,3]
	\nn\t3::Arrays('1|2||3')->trimExplode('|', false); // [1,2,'',3]
	\nn\t3::Arrays('1|2,3')->trimExplode(['|', ',']); // [1,2,3]
	\nn\t3::Arrays(['1','','2','3'])->trimExplode(); // [1,2,3]

| ``@return array``

