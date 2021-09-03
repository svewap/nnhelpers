
.. include:: ../../Includes.txt

.. _Obj:

==============================================
Obj
==============================================

\\nn\\t3::Obj()
----------------------------------------------

Everything you need for objects and models.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Obj()->accessSingleProperty(``$obj, $key``);
"""""""""""""""""""""""""""""""""""""""""""""""

Access a key in an object or array.
key must be single string, not path

\nn\t3::Obj()->accessSingleProperty( $obj, 'uid' );
\nn\t3::Obj()->accessSingleProperty( $obj, 'fal_media' );
\nn\t3::Obj()->accessSingleProperty( $obj, 'falMedia' );

| ``@param mixed $obj`` Model or array.
| ``@param string $key`` the key to fetch

| ``@return mixed``

\\nn\\t3::Obj()->diff(``$objA, $objB, $fieldsToIgnore = [], $fieldsToCompare = [], $options = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Compares two objects, returns array with differences.
If a property of objA does not exist in objB, it is ignored.

.. code-block:: php

	// returns array with differences.
	\nn\t3::Obj()->diff( $objA, $objB );
	
	// ignores the uid and title fields
	\nn\t3::Obj()->diff( $objA, $objB, ['uid', 'title'] );
	
	// Compares ONLY the title and bodytext fields
	\nn\t3::Obj()->diff( $objA, $objB, [], ['title', 'bodytext'] );
	
	// options
	\nn\t3::Obj()->diff( $objA, $objB, [], [], ['ignoreWhitespaces'=>true, 'ignoreTags'=>true, 'ignoreEncoding'=>true] );

| ``@param mixed $objA`` An object, array, or model.
| ``@param mixed $objB`` The object or model to compare.
| ``@param array $fieldsToIgnore`` List of properties that can be ignored. Empty = none
| ``@param array $fieldsToCompare`` List of properties to compare. Empty = all
| ``@param boolean $options`` Options / tolerances when comparing.
| ``ignoreWhitespaces`` => ignore spaces.
| ``ignoreEncoding`` => ignore UTF8 / ISO encoding.
| ``ignoreTags`` => ignore HTML tags

| ``@return array``

\\nn\\t3::Obj()->forceArray(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

converts to array

| ``@param mixed $obj``

| ``@return array``

\\nn\\t3::Obj()->get(``$obj, $key = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Access a value in the object using the key.
Alias to ``\nn\t3::Obj()->accessSingleProperty()``

.. code-block:: php

	\nn\t3::Obj()->get( $obj, 'title' );
	\nn\t3::Obj()->get( $obj, 'falMedia' );
	\nn\t3::Obj()->get( $obj, 'fal_media' );

| ``@param mixed $obj`` Model or array.
| ``@param string $key`` the key/property

| ``@return mixed``

\\nn\\t3::Obj()->getClassSchema(``$modelClassName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get info about the classSchema of a model

.. code-block:: php

	 \nn\t3::Obj()->getClassSchema( \My\Model\Name );

return DataMap
.

\\nn\\t3::Obj()->getKeys(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Access ALL keys to be fetched in an object

.. code-block:: php

	\nn\t3::Obj()->getKeys( $model ); // ['uid', 'title', 'text', ...]
	\nn\t3::Obj()->getKeys( $model ); // ['uid', 'title', 'text', ...]
	\nn\t3::Obj()->getKeys( \Nng\MyExt\Domain\Model\Demo::class ); // ['uid', 'title', 'text', ...]

| ``@param mixed $obj`` Model, array, or class name.
| ``@return array``

\\nn\\t3::Obj()->getProps(``$obj, $key = 'type', $onlySettable = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

return the list of properties of an object or model with type.

.. code-block:: php

	\nn\t3::Obj()->getProps( $obj ); // ['uid'=>'integer', 'title'=>'string' ...]
	\nn\t3::Obj()->getProps( $obj, true ); // ['uid'=>[type=>'integer', 'private'=>TRUE]]
	\nn\t3::Obj()->getProps( $obj, 'default' ); // ['uid'=>TRUE]
	\nn\t3::Obj()->getProps( \Nng\MyExt\Domain\Model\Demo::class );

| ``@param mixed $obj`` model or class name.
| ``@param mixed $key`` If TRUE array with all info is fetched, e.g. also default value etc.
| ``@param boolean $onlySettable`` Get only properties that can also be set by setName().
| ``@return array``

\\nn\\t3::Obj()->getSetableKeys(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get all keys of an object that have a SETTER.
In contrast to ``\nn\t3::Obj()->getKeys()``, only the property keys
that can be set, e.g. via ``setNameDerProp()``

| ``@return array``

\\nn\\t3::Obj()->getTableName(``$modelClassName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

returns the DB table name for a model

.. code-block:: php

	$model = new \Nng\MyExt\Domain\Model\Test;
	\nn\t3::Obj()->getTableName( $model ); // 'tx_myext_domain_model_test'
	\nn\t3::Obj()->getTableName( Test::class ); // 'tx_myext_domain_model_test'

| ``@return string``

\\nn\\t3::Obj()->isFalFile(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft whether the object is a \TYPO3\CMS\Core\Resource\FileReference.

.. code-block:: php

	\nn\t3::Obj()->isFalFile( $obj );

| ``@return boolean``

\\nn\\t3::Obj()->isFile(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Check whether the object is a ``\TYPO3\CMS\Core\Resource\File``.

.. code-block:: php

	\nn\t3::Obj()->isFile( $obj );

| ``@return boolean``

\\nn\\t3::Obj()->isFileReference(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft whether the object is a \TYPO3\CMS\Extbase\Domain\Model\FileReference.

.. code-block:: php

	\nn\t3::Obj()->isFileReference( $obj );

| ``@return boolean``

\\nn\\t3::Obj()->isStorage(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft whether the object is a storage.

.. code-block:: php

	\nn\t3::Obj()->isStorage( $obj );

| ``@return boolean``

\\nn\\t3::Obj()->isSysCategory(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Checks whether the object is a SysCategory.
Takes into account all models that are stored in ``sys_category``

.. code-block:: php

	\nn\t3::Obj()->isSysCategory( $obj );
	
	$cat = new \GeorgRinger\News\Domain\Model\Category();
	\nn\t3::Obj()->isSysCategory( $cat );

| ``@return boolean``

\\nn\\t3::Obj()->merge(``$obj = NULL, $overlay = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Merge an array into an object

.. code-block:: php

	\nn\t3::Obj( \My\Doman\Model )->merge(['title'=>'New Title']);

This can even be used to write / üoverwrite FileReferences.
In this example, ``$data`` is merged with an existing model.
| ``falMedia`` is an ObjectStorage in the example. The first element in ``falMedia`` exists
already exists in the database (``uid = 12``). Only the title is updated here.
The second element in the array (without ``uid``) is new. For this, a new
| ``sys_file_reference`` is created in the database.

.. code-block:: php

	$data = [
	    'uid' => 10,
	    'title' => 'the title',
	    'falMedia' => [
	        ['uid'=>12, 'title'=>'1st image title'],
	        ['title'=>'NEW image title', 'publicUrl'=>'fileadmin/_tests/5e505e6b6143a.jpg'],
	    ]
	];
	$oldModel = $repository->findByUid( $data['uid'] );
	$mergedModel = \nn\t3::Obj($oldModel)->merge($data);

Note
In order to create a new model with data from an array there is
there is a method ``$newModel = \nn\t3::Convert($data)->toModel( \My\Model\Name::class );``

| ``@return Object``

\\nn\\t3::Obj()->prop(``$obj, $key``);
"""""""""""""""""""""""""""""""""""""""""""""""

Access to a key in an object or array.
The key can also be a path, e.g. "img.0.uid"

nn\t3::Obj()->prop( $obj, 'img.0.uid' );

| ``@param mixed $obj`` Model or array.
| ``@param string $key`` the key to fetch

| ``@return mixed``

\\nn\\t3::Obj()->props(``$obj, $keys = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get individual properties of an object or array

.. code-block:: php

	\nn\t3::Obj()->props( $obj, ['uid', 'pid'] );
	\nn\t3::Obj()->props( $obj, 'uid' );

| ``@return array``

\\nn\\t3::Obj()->set(``$obj, $key = '', $val = '', $useSetter = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sets a value in an object or array.

.. code-block:: php

	\nn\t3::Obj()->set( $obj, 'title', $val );

| ``@param mixed $obj`` Model or array.
| ``@param string $key`` the key / property
| ``@param mixed $val`` the value to be set
| ``@param boolean $useSetter`` use setKey() method to set

| ``@return mixed``

\\nn\\t3::Obj()->toArray(``$obj, $depth = 3, $fields = [], $addClass = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts an object to an array.
For memory problems due to recursion: Specify max depth!

.. code-block:: php

	\nn\t3::Obj()->toArray($obj, 2, ['uid', 'title']);
	\nn\t3::Obj()->toArray($obj, 1, ['uid', 'title', 'parent.uid']);

| ``@param mixed $obj`` ObjectStorage, model or array to be converted.
| ``@param integer $depth`` Depth to be converted. For recursive conversion, be sure to use.
| ``@param array $fields`` return only those fields from the object / array.
| ``@param boolean $addClass`` '__class' with info about the class?

| ``@return array``

