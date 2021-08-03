
.. include:: ../../Includes.txt

.. _Convert:

==============================================
Convert
==============================================

\\nn\\t3::Convert()
----------------------------------------------

Converting arrays to models, models to JSONs, arrays to ObjectStorages,
hex colors to RGB, and a whole lot more that has anything to do
to do.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Convert()->toArray(``$obj = NULL, $depth = 3``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a model to an array.
Alias to \nn\t3::Obj()->toArray();

For memory problems due to recursion: Specify max-depth!

.. code-block:: php

	\nn\t3::Convert($model)->toArray(2);
	\nn\t3::Convert($model)->toArray(); => ['uid'=>1, 'title'=>'example', ...]

| ``@return array``

\\nn\\t3::Convert()->toBytes();
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a human-readable specification of bytes/megabytes to a byte integer.
Extremely tolerant of spaces, capitalization, and commas instead of periods

.. code-block:: php

	\nn\t3::Convert('1M')->toBytes(); // -> 1048576
	\nn\t3::Convert('1 MB')->toBytes(); // -> 1048576
	\nn\t3::Convert('1kb')->toBytes(); // -> 1024
	\nn\t3::Convert('1,5kb')->toBytes(); // -> 1024
	\nn\t3::Convert('1.5Gb')->toBytes(); // -> 1610612736

For the reverse (bytes to human readable notation like 1024 -> 1kb) there is
there is a handy Fluid ViewHelper in the core:

.. code-block:: php

	{fileSize->f:format.bytes()}

| ``@return integer``

\\nn\\t3::Convert()->toFileReference();
"""""""""""""""""""""""""""""""""""""""""""""""

.
Converts a ``\TYPO3\CMS\Core\Resource\FileReference`` (or its ``uid``)
into a ``\TYPO3\CMS\Extbase\Domain\Model\FileReference``

.. code-block:: php

	\nn\t3::Convert( $input )->toFileReference() => \TYPO3\CMS\Extbase\Domain\Model\FileReference

| ``@param $input`` Can be ``\TYPO3\CMS\Core\Resource\FileReference`` or ``uid`` of it.
| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``
.

\\nn\\t3::Convert()->toIso();
"""""""""""""""""""""""""""""""""""""""""""""""

Converts (normalizes) a string to ISO-8859-1

.. code-block:: php

	\nn\t3::Convert('äöü')->toIso();

| ``@return string``

\\nn\\t3::Convert()->toJson(``$obj = NULL, $depth = 3``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a model to a JSON

.. code-block:: php

	\nn\t3::Convert($model)->toJson() => ['uid'=>1, 'title'=>'example', ...]

| ``@return array``

\\nn\\t3::Convert()->toModel(``$className = NULL, $parentModel = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts an array to a model.

.. code-block:: php

	\nn\t3::Convert($array)->toModel( \Nng\Model\Name::class ) => \Nng\Model\Name

Can also automatically create FileReferences.
In this example, a new model of type ``\Nng\Model\Name`` is created and then
then persisted in the database. The ``falMedia`` field is an ObjectStorage.
with ``FileReferences``. The FileReferences are created automatically!

.. code-block:: php

	$data = [
	    'pid' => 6,
	    'title' => 'new record',
	    'description' => 'The text',
	    'falMedia' => [
	        ['title'=>'Image 1', 'publicUrl'=>'fileadmin/_tests/5e505e6b6143a.jpg']
	        ['title'=>'image 2', 'publicUrl'=>'fileadmin/_tests/5e505fbf5d3dd.jpg'],
	        ['title'=>'image 3', 'publicUrl'=>'fileadmin/_tests/5e505f435061e.jpg'],
	    ]
	];
	$newModel = \nn\t3::Convert( $data )->toModel( \Nng\Model\Name::class );
	$modelRepository->add( $newModel );
	\nn\t3::Db()->persistAll();

Example: create a news model from an array:

.. code-block:: php

	$entry = [
	    'pid' => 12,
	    'title' => 'news-title',
	    'description' => '<p>My News</p>',
	    'falMedia' => [['publicUrl' => 'fileadmin/image.jpg', 'title'=>'image'], ...],
	    'categories' => [1, 2]
	];
	$model = \nn\t3::Convert( $entry )->toModel( \GeorgRinger\News\Domain\Model\News::class );
	$newsRepository->add( $model );
	\nn\t3::Db()->persistAll();

Note
To update an already existing model with data from an array there is
there is the method ``$updatedModel = \nn\t3::Obj( $prevModel )->merge( $data );``

| ``@return mixed``

\\nn\\t3::Convert()->toObjectStorage(``$obj = NULL, $childType = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts something to an ObjectStorage

.. code-block:: php

	\nn\t3::Convert($something)->toObjectStorage()
	\nn\t3::Convert($something)->toObjectStorage( \My\Child\Type::class )
	
	\nn\t3::Convert()->toObjectStorage([['uid'=>1], ['uid'=>2], ...], \My\Child\Type::class )
	\nn\t3::Convert()->toObjectStorage([1, 2, ...], \My\Child\Type::class )

| ``@return ObjectStorage``
.

\\nn\\t3::Convert()->toRGB();
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a color value to another number format

.. code-block:: php

	\nn\t3::Convert('#ff6600')->toRGB(); // -> 255,128,0

| ``@return string``

\\nn\\t3::Convert()->toSysCategories();
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a list to an ``ObjectStorage`` with ``SysCategory``

.. code-block:: php

	Not yet implemented!

| ``@return ObjectStorage``

\\nn\\t3::Convert()->toUTF8();
"""""""""""""""""""""""""""""""""""""""""""""""

Converts (normalizes) a string to UTF-8

.. code-block:: php

	\nn\t3::Convert('äöü')->toUTF8();

| ``@return string``

