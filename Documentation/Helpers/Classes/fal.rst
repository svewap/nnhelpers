
.. include:: ../../Includes.txt

.. _Fal:

==============================================
Fal
==============================================

\\nn\\t3::Fal()
----------------------------------------------

Methods to create sysFile and sysFileReference entries.

Checklist:

.. code-block:: php

	\TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage
	 |
	 └─ \TYPO3\CMS\Extbase\Domain\Model\FileReference
	        ... getOriginalResource()
	                |
	                └─ \TYPO3\CMS\Core\Resource\FileReference
	                    ... getOriginalFile()
	                            |
	                            └─ \TYPO3\CMS\Core\Resource\File

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Fal()->attach(``$model, $field, $itemData = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert a file to a FileReference object, and attach it
Attach it to the Property or ObjectStorage of a model.
See also: ``\nn\t3::Fal()->setInModel( $member, 'falslideshow', $imagesToSet );`` with the
array of multiple images can be attached to an ObjectStorage.

.. code-block:: php

	\nn\t3::Fal()->attach( $model, $fieldName, $filePath );
	\nn\t3::Fal()->attach( $model, 'image', 'fileadmin/user_uploads/image.jpg' );
	\nn\t3::Fal()->attach( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg'] );
	\nn\t3::Fal()->attach( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg', 'title'=>'Title...'] );

| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

\\nn\\t3::Fal()->clearCache(``$filenameOrSysFile = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes the cache for the image sizes of a FAL including the converted images.
If e.g. the f:image-ViewHelper is used, all calculated image sizes will be
are stored in the table sys_file_processedfile. Ächanges the original image,
an image from the cache may still be accessed.

.. code-block:: php

	\nn\t3::Fal()->clearCache( 'fileadmin/file.jpg' );
	\nn\t3::Fal()->clearCache( $fileReference );
	\nn\t3::Fal()->clearCache( $falFile );

| ``@param $filenameOrSysFile`` FAL or path (string) to the file.
| ``@return void``

\\nn\\t3::Fal()->createFalFile(``$storageConfig, $srcFile, $keepSrcFile = false, $forceCreateNew = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Creates a \File (FAL) Object (sys_file)

nn\t3::Fal()->createFalFile( $storageConfig, $srcFile, $keepSrcFile, $forceCreateNew );

| ``@param string $storageConfig`` Path/folder where FAL file should be stored (e.g. 'fileadmin/projectdata/').
| ``@param string $srcFile`` Source file to be converted to FAL (e.g. 'uploads/tx_nnfesubmit/example.jpg').
Can also be URL to YouTube/Vimeo video (e.g. https://www.youtube.com/watch?v=7Bb5jXhwnRY)
| ``@param boolean $keepSrcFile`` Copy source file only, not move it?
| ``@param boolean $forceCreateNew`` Should new file always be created? If not, it returns existing File object if necessary

| ``@return \Nng\Nnhelpers\Domain\Model\File|\TYPO3\CMS\Core\Resource\File|boolean``

\\nn\\t3::Fal()->createForModel(``$model, $field, $itemData = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert a file to a FileReference object and für ``attach()`` to an existing
Prepare model and field/property. The FileReference will not be attached to the model automatically.
automatically attached to the model. To set the FAL directly in the model, you can use the helper
| ``\nn\t3::Fal()->attach( $model, $field, $itemData )`` can be used.

.. code-block:: php

	\nn\t3::Fal()->createForModel( $model, $fieldName, $filePath );
	\nn\t3::Fal()->createForModel( $model, 'image', 'fileadmin/user_uploads/image.jpg' );
	\nn\t3::Fal()->createForModel( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg'] );
	\nn\t3::Fal()->createForModel( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg', 'title'=>'Title...'] );

| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

\\nn\\t3::Fal()->createSysFile(``$file, $autoCreateStorage = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Creates new entry in ``sys_file``
Searches all ``sys_file_storage`` entries to see if the path to the $file already exists as storage.
If not, a new storage will be created.

.. code-block:: php

	\nn\t3::Fal()->createSysFile( 'fileadmin/image.jpg' );
	\nn\t3::Fal()->createSysFile( '/var/www/mysite/fileadmin/image.jpg' );

| ``@return false|\TYPO3\CMS\Core\Resource\File``

\\nn\\t3::Fal()->deleteProcessedImages(``$sysFile = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes all physical thumbnail files that have been generated for an image incl.
the records in the ``sys_file_processedfile`` table.

The original image, passed as argument ``$path`` üis not deleted in the process.
The whole thing forces the regeneration of thumbnails for an image if, for example, the source image has changed.
source image has changed but the filename has remained the same.

Another use case: clean up files on the server, e.g. because sensitive, personal data has been deleted.
Data should be deleted incl. all generated thumbnails.

.. code-block:: php

	\nn\t3::Fal()->deleteProcessedImages( 'fileadmin/path/sample.jpg' );
	\nn\t3::Fal()->deleteProcessedImages( $sysFileReference );
	\nn\t3::Fal()->deleteProcessedImages( $sysFile );

| ``@return mixed``

\\nn\\t3::Fal()->deleteSysFile(``$uidOrObject = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes a SysFile (record from table ``sys_file``) and all associated SysFileReferences.
A radical way to take an image completely out of Typo3's indexing.

The physical file is not deleted from the server!
See ``\nn\t3::File()->unlink()`` to delete the physical file.
See ``\nn\t3::Fal()->detach( $model, $field );`` for löling from a model.

.. code-block:: php

	\nn\t3::Fal()->deleteSysFile( 1201 );
	\nn\t3::Fal()->deleteSysFile( 'fileadmin/path/to/image.jpg' );
	\nn\t3::Fal()->deleteSysFile( \TYPO3\CMS\Core\Resource\File );
	\nn\t3::Fal()->deleteSysFile( \TYPO3\CMS\Core\Resource\FileReference );

| ``@param $uidOrObject``

| ``@return integer``

\\nn\\t3::Fal()->deleteSysFileReference(``$uidOrFileReference = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lödeletes a SysFileReference.
See also ``\nn\t3::Fal()->detach( $model, $field );`` to delete from a model.

.. code-block:: php

	\nn\t3::Fal()->deleteSysFileReference( 112 );
	\nn\t3::Fal()->deleteSysFileReference( \TYPO3\CMS\Extbase\Domain\Model\FileReference );

| ``@param $uidOrFileReference``

| ``@return mixed``

\\nn\\t3::Fal()->detach(``$model, $field, $obj = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes an ObjectStorage in a model or removes an
single Object from the Model or an ObjectStorage.
In the example, ``image`` can be an ObjectStorage or a single ``FileReference``:

.. code-block:: php

	\nn\t3::Fal()->detach( $model, 'image' );
	\nn\t3::Fal()->detach( $model, 'image', $singleObjToRemove );

| ``@return void``

\\nn\\t3::Fal()->fileReferenceExists(``$sysFile = NULL, $params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Checks if a SysFileReference to the same SysFile already exists for a record

.. code-block:: php

	\nn\t3::Fal()->fileReferenceExists( $sysFile, ['uid_foreign'=>123, 'tablenames'=>'tt_content', 'field'=>'media'] );

| ``@param $sysFile``
| ``@param array $params`` => uid_foreign, tablenames, fieldname.
| ``@return FileReference|false``
.

\\nn\\t3::Fal()->fromFile(``$params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Creates a FileRefence object (table: ``sys_file_reference``) and associates it with a record.
Example: Uploaded JPG should be attached as FAL to tt_news record

Parameters:

key
description

| ``src``
path to source file (can also be http link to YouTube video)

| ``dest``
Path to destination folder (optional if file is to be moved/copied)

| ``table``
Target table to which FileReference should be assigned (e.g. ``tx_myext_domain_model_entry``)

| ``title``
title

| ``description``
description

| ``link``
link

| ``crop``
crop

| ``table``
Target table to which the FileReference should be assigned (e.g. ``tx_myext_domain_model_entry``)

| ``sorting``
(int) sorting

| ``field``
Column name of the target table to which the FileReference should be assigned (e.g., ``image``)

| ``uid``
(int) uid of the record in the target table (``tx_myext_domain_model_entry.uid``)

| ``pid``
(int) pid of the record in the destination table

| ``cruser_id``
cruser_id of the record in the target table

| ``copy``
src file do not move but copy (default: ``true``)

| ``forceNew``
Force new file in destination folder (otherwise checks if file already exists) default: ``false``

| ``single``
Make sure that same FileReference is linked only 1x per record (default: ``true``)

Example:

.. code-block:: php

	$fal = \nn\t3::Fal()->fromFile([
	    'src' => 'fileadmin/test/image.jpg',
	    'dest' => 'fileadmin/test/fal/',
	    'pid' => 132,
	    'uid' => 5052,
	    'table' => 'tx_myext_domain_model_entry',
	    'field' => 'fallistimage'
	]);

| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``
.

\\nn\\t3::Fal()->getFalFile(``$srcFile``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets a \File (FAL) object (``sys_file``)

.. code-block:: php

	\nn\t3::Fal()->getFalFile( 'fileadmin/image.jpg' );

| ``@param string $srcFile``
| ``@return \TYPO3\CMS\Core\Resource\File|boolean``

\\nn\\t3::Fal()->getFileObjectFromCombinedIdentifier(``$file = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets a SysFile from the CombinedIdentifier notation ('1:/uploads/example.txt').
If file does not exist FALSE will be returned.

.. code-block:: php

	\nn\t3::Fal()->getFileObjectFromCombinedIdentifier( '1:/uploads/example.txt' );

| ``@param string $file`` Combined Identifier ('1:/uploads/example.txt')
| ``@return file|boolean``

\\nn\\t3::Fal()->getFilePath(``$falReference``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the URL to a FileReference or FalFile.
Alias to ``\nn\t3::File()->getPublicUrl()``.

.. code-block:: php

	\nn\t3::Fal()->getFilePath( $fileReference ); // results in e.g. 'fileadmin/pictures/01.jpg'

| ``@param \TYPO3\CMS\Extbase\Domain\Model\FileReference|\TYPO3\CMS\Core\Resource\FileReference $falReference``
| ``@return string``

\\nn\\t3::Fal()->getFileReferenceByUid(``$uid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets a SysFileReference based on the uid.
Alias to ``\nn\t3::Convert( $uid )->toFileReference()``;

.. code-block:: php

	\nn\t3::Fal()->getFileReferenceByUid( 123 );

| ``@param $uid``
| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``
.

\\nn\\t3::Fal()->getImage(``$src = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

.
Gets/converts to a \TYPO3\CMS\Core\Resource\FileReference Object (sys_file_reference).
"Smart" variant to ``\TYPO3\CMS\Extbase\Service\ImageService->getImage()``

.. code-block:: php

	\nn\t3::Fal()->getImage( 1 );
	\nn\t3::Fal()->getImage( 'path/to/image.jpg' );
	\nn\t3::Fal()->getImage( $fileReference );

| ``@param string|\TYPO3\CMS\Extbase\Domain\Model\FileReference $src``
| ``@return \TYPO3\CMS\Core\Resource\FileReference|boolean``

\\nn\\t3::Fal()->process(``$fileObj = '', $processing = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Calculates an image üover ``maxWidth``, ``maxHeight``, ``cropVariant`` etc.
Returns URI to image as string. Helpful when calculating thumbnails in the backend.
Alias to ``\nn\t3::File()->process()``

.. code-block:: php

	\nn\t3::File()->process( 'fileadmin/images/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( '1:/images/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFile, ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFileReference, ['maxWidth'=>200, 'cropVariant'=>'square'] );

| ``@return string``

\\nn\\t3::Fal()->setInModel(``$model, $fieldName = '', $imagesToAdd = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Replaces a ``FileReference`` or ``ObjectStorage`` in a model with images.
Typical use case: A FAL image should be changed via an upload form in the frontend.
in the frontend.

For each image, it is checked if a ``FileReference`` already exists in the model.
Existing FileReferences are not overwritten, otherwise captions or cropping annotations might be used.
Captions or cropping instructions would be lost!

Attention! The model will be persisted automatically!

.. code-block:: php

	$newModel = new \My\Extension\Domain\Model\Example();
	\nn\t3::Fal()->setInModel( $newModel, 'falslideshow', 'path/to/file.jpg' );
	echo $newModel->getUid(); // Model has been persisted!

Example with a simple FileReference in the Model:

.. code-block:: php

	$imageToSet = 'fileadmin/images/portrait.jpg';
	\nn\t3::Fal()->setInModel( $member, 'falprofileimage', $imageToSet );
	
	\nn\t3::Fal()->setInModel( $member, 'falprofileimage', ['publicUrl'=>'01.jpg', 'title'=>'title', 'description'=>'...'] );

Example with an ObjectStorage in the model:

.. code-block:: php

	$imagesToSet = ['fileadmin/images/01.jpg', 'fileadmin/images/02.jpg', ...];
	\nn\t3::Fal()->setInModel( $member, 'falslideshow', $imagesToSet );
	
	\nn\t3::Fal()->setInModel( $member, 'falslideshow', [['publicUrl'=>'01.jpg'], ['publicUrl'=>'02.jpg']] );
	\nn\t3::Fal()->setInModel( $member, 'falvideos', [['publicUrl'=>'https://youtube.com/?watch=zagd61231'], ...] );

Example with videos:

.. code-block:: php

	$videosToSet = ['https://www.youtube.com/watch?v=GwlU_wsT20Q', ...];
	\nn\t3::Fal()->setInModel( $member, 'videos', $videosToSet );

| ``@param mixed $model`` The model to be changed.
| ``@param string $fieldName`` Property (field name) of the ObjectStorage or FileReference.
| ``@param mixed $imagesToAdd`` String / array of images

| ``@return mixed``

\\nn\\t3::Fal()->toArray(``$fileReference = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert a FileReference to an array.
Contains publicUrl, title, alternative, crop etc of the FileReference.
Alias to ``\nn\t3::Obj()->toArray( $fileReference );``

.. code-block:: php

	\nn\t3::Fal()->toArray( $fileReference ); // yields ['publicUrl'=>'fileadmin/...', 'title'=>'...']

| ``@param \TYPO3\CMS\Extbase\Domain\Model\FileReference $falReference``
| ``@return array``

\\nn\\t3::Fal()->unlink(``$uidOrObject = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes a SysFile and all associated SysFileReferences.
Alias to ``\nn\t3::Fal()->deleteSysFile()``

| ``@return integer``
.

\\nn\\t3::Fal()->updateMetaData(``$filenameOrSysFile = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Update the data in ``sys_file_metadata`` and ``sys_file``

.. code-block:: php

	\nn\t3::Fal()->updateMetaData( 'fileadmin/file.jpg' );
	\nn\t3::Fal()->updateMetaData( $fileReference );
	\nn\t3::Fal()->updateMetaData( $falFile );

| ``@param $filenameOrSysFile`` FAL or path (string) to the file.
| ``@param $data`` Array of data to be updated.
If empty, image data will be read automatically
| ``@return void``

