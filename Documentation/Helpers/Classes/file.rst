
.. include:: ../../Includes.txt

.. _File:

==============================================
File
==============================================

\\nn\\t3::File()
----------------------------------------------

Methods related to the file system:
Reading, writing, copying, moving, and cleaning up files.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::File()->absPath(``$file = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Absolute path to a file on the server.

Returns the complete path starting from the server root, e.g. starting from ``/var/www/...``
If the path was already absolute, it will be returned unchanged.

.. code-block:: php

	\nn\t3::File()->absPath('fileadmin/image.jpg'); // => /var/www/website/fileadmin/image.jpg
	\nn\t3::File()->absPath('/var/www/website/fileadmin/image.jpg'); // => /var/www/website/fileadmin/image.jpg
	\nn\t3::File()->absPath('EXT:nnhelpers'); // => /var/www/website/typo3conf/ext/nnhelpers/

In addition to the file path as a string, all conceivable objects can also be passed:

.. code-block:: php

	// \TYPO3\CMS\Core\Resource\Folder
	\nn\t3::File()->absPath( $folderObject ); => /var/www/website/fileadmin/image.jpg
	
	// \TYPO3\CMS\Core\Resource\File
	\nn\t3::File()->absPath( $fileObject ); => /var/www/website/fileadmin/image.jpg
	
	// \TYPO3\CMS\Extbase\Domain\Model\FileReference
	\nn\t3::File()->absPath( $fileReference ); => /var/www/website/fileadmin/image.jpg

Also acts as a ViewHelper:

.. code-block:: php

	{nnt3:file.absPath(file:'path/to/image.jpg')}

| ``@return boolean``

\\nn\\t3::File()->absUrl(``$file = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Generate absolute URL to a file.
Returns the full path to the file including ``https://.../``.

.. code-block:: php

	// => https://www.myweb.de/fileadmin/bild.jpg
	\nn\t3::File()->absUrl( 'fileadmin/image.jpg' );
	
	// => https://www.myweb.de/fileadmin/bild.jpg
	\nn\t3::File()->absUrl( 'https://www.myweb.de/fileadmin/bild.jpg' );
	
	// => /var/www/vhost/somewhere/fileadmin/image.jpg
	\nn\t3::File()->absUrl( 'https://www.myweb.de/fileadmin/bild.jpg' );

| ``@return string``

\\nn\\t3::File()->addPathSite(``$file``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gives path to file / folder WITH absolute path

Example:

.. code-block:: php

	\nn\t3::File()->addPathSite('fileadmin/test.jpg');
	 // ==> returns var/www/website/fileadmin/test.jpg

| ``@return string``

\\nn\\t3::File()->addSuffix(``$filename = NULL, $newSuffix = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Replaces the suffix for a file name.

.. code-block:: php

	\nn\t3::File()->suffix('image', 'jpg'); // => image.jpg
	\nn\t3::File()->suffix('image.png', 'jpg'); // => image.jpg
	\nn\t3::File()->suffix('path/to/image.png', 'jpg'); // => path/to/image.jpg

| ``@return string``

\\nn\\t3::File()->cleanFilename(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

cleans a filename

.. code-block:: php

	$clean = \nn\t3::File()->cleanFilename('fileadmin/nö:so not.jpg'); // 'fileadmin/noe_so_not.jpg'

| ``@return string``

\\nn\\t3::File()->copy(``$src = NULL, $dest = NULL, $renameIfFileExists = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Copies a file.
Returns ``false`` if the file could not be copied.
Returns (new) filename if the copy was successful.

.. code-block:: php

	$filename = \nn\t3::File()->copy('fileadmin/image.jpg', 'fileadmin/image-copy.jpg');

| ``@param string $src`` Path to the source file.
| ``@param string $dest`` Path to the destination file.
| ``@param boolean $renameIfFileExists`` Rename file if file with same name already exists at destination.
| ``@return string|boolean``

\\nn\\t3::File()->createFolder(``$path = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Create a folder in the ``fileadmin/``
To create a folder outside of ``fileadmin``, use the ``\nn\t3::File()->mkdir()`` method.

.. code-block:: php

	\nn\t3::File()->createFolder('tests');

| ``@return boolean``

\\nn\\t3::File()->download(``$files = NULL, $filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Download a single file or a zipped archive.

Download as a ZIP requires the PHP extension ``gmp``. If extension is not present,
it will use the ``.tar`` variant. On Mac, the function uses the
security warnings of the Finder, the function uses ``tar``

.. code-block:: php

	\nn\t3::File()->download( 'fileadmin/test.pdf' );
	\nn\t3::File()->download( $fileReference );
	\nn\t3::File()->download( $sysFile );
	\nn\t3::File()->download( 'fileadmin/test.pdf', 'download.pdf' );

When an array is üpassed, a tar/zip download is started.
By üpassing an associative array with filename as key and path in archive as value.
The file and folder structure in the zip archive can be determined.

.. code-block:: php

	\nn\t3::File()->download( ['fileadmin/test-1.pdf', 'fileadmin/test-2.pdf'], 'archive.zip' );
	\nn\t3::File()->download( ['fileadmin/test-1.pdf'=>'one.pdf', 'fileadmin/test-2.pdf'=>'two.pdf'], 'archive.zip' );
	\nn\t3::File()->download( ['fileadmin/test-1.pdf'=>'zip-folder-1/one.pdf', 'fileadmin/test-2.pdf'=>'zip-folder-2/two.pdf'], 'archive.zip' );

| ``@param mixed $files`` String or array of files to load.
| ``@param mixed $filename`` Optional: overwrite filename when downloading.
| ``@return void``

\\nn\\t3::File()->exists(``$src = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Probes whether a file exists.
Returns absolute path to the file

.. code-block:: php

	\nn\t3::File()->exists('fileadmin/image.jpg');

Also acts as a ViewHelper:

.. code-block:: php

	{nnt3:file.exists(file:'path/to/image.jpg')}

| ``@return string|boolean``

\\nn\\t3::File()->extractExifData(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Save EXIF data for file in JSON

.. code-block:: php

	\nn\t3::File()->extractExifData( 'yellowstone.jpg' );

| ``@return array``

\\nn\\t3::File()->getData(``$file = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get imageinfo + EXIF Data für file.
Also looks for JSON file that may have been generated after processImage()

| ``@return array``

\\nn\\t3::File()->getExifData(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get ALL EXIF data for file

.. code-block:: php

	\nn\t3::File()->getExif( 'yellowstone.jpg' );

| ``@return array``

\\nn\\t3::File()->getFolder(``$file``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the folder to a file

Example:

.. code-block:: php

	\nn\t3::File()->getFolder('fileadmin/test/example.txt');
	// ==> return 'fileadmin/test/'

| ``@return string``

\\nn\\t3::File()->getImageData(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get EXIF image data for file

.. code-block:: php

	\nn\t3::File()->getImageData( 'yellowstone.jpg' );

| ``@return array``

\\nn\\t3::File()->getImageSize(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

getimagesize für file.

.. code-block:: php

	\nn\t3::File()->getImageSize( 'yellowstone.jpg' );

| ``@return array``

\\nn\\t3::File()->getLocationData(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get EXIF GEO data for file.
Address data will be retrieved automatically if possible

.. code-block:: php

	\nn\t3::File()->getLocationData( 'yellowstone.jpg' );

| ``@return array``

\\nn\\t3::File()->getPath(``$file, $storage = NULL, $absolute = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the path of a file based on a filename and storage.
Example:

.. code-block:: php

	\nn\t3::File()->getPath('media/image.jpg', $storage);
	// ==> returns '/var/www/.../fileadmin/media/image.jpg'.
	\nn\t3::File()->getPath('fileadmin/media/image.jpg');
	// ==> returns '/var/www/.../fileadmin/media/image.jpg' toück

| ``@return string``

\\nn\\t3::File()->getPublicUrl(``$obj = NULL, $absolute = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets path to file, relative to Typo3 installation directory (PATH_site).
Can handle all types of objects

.. code-block:: php

	\nn\t3::File()->getPublicUrl( $falFile ); // \TYPO3\CMS\Core\Resource\FileReference.
	\nn\t3::File()->getPublicUrl( $fileReference ); // \TYPO3\CMS\Extbase\Domain\Model\FileReference
	\nn\t3::File()->getPublicUrl( $folder ); // \TYPO3\CMS\Core\Resource\Folder
	\nn\t3::File()->getPublicUrl( $folder, true ); // https://.../fileadmin/bild.jpg

| ``@return string``

\\nn\\t3::File()->getRelativePathInStorage(``$file, $storage = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the relative path of a file to the specified storage.

Example:

.. code-block:: php

	\nn\t3::File()->getRelativePathInStorage('fileadmin/media/image.jpg', $storage);
	// ==> returns 'media/image.jpg'

| ``@return string``

\\nn\\t3::File()->getStorage(``$file, $createIfNotExists = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds a matching sys_file_storage to a file or folder path.
To do this, searches all sys_file_storage entries and compares,
if the basePath of the storage matches the path of the file.

.. code-block:: php

	\nn\t3::File()->getStorage('fileadmin/test/example.txt');
	\nn\t3::File()->getStorage( $falFile );
	\nn\t3::File()->getStorage( $sysFileReference );
	//returns ResourceStorage with basePath "fileadmin/"

| ``@return ResourceStorage``
.

\\nn\\t3::File()->isAllowed(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Indicates whether the file type is allowed

.. code-block:: php

	\nn\t3::File()->isForbidden('image.jpg'); => returns 'true'

| ``@return boolean``

\\nn\\t3::File()->isConvertableToImage(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Indicates whether the file can be converted to an image

.. code-block:: php

	\nn\t3::File()->isConvertableToImage('image.jpg'); => returns true

| ``@return boolean``

\\nn\\t3::File()->isExternalVideo(``$url = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Indicates if it is a video on YouTube / Vimeo.
If it is, an array of details will be returned for embedding.

.. code-block:: php

	\nn\t3::File()->isExternalVideo('http://...');

| ``@return array|boolean``

\\nn\\t3::File()->isFolder(``$file``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns whether specified path is a folder

Example:

.. code-block:: php

	\nn\t3::File()->isFolder('fileadmin'); // => returns true

| ``@return boolean``

\\nn\\t3::File()->isForbidden(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Indicates whether the file type is forbidden

.. code-block:: php

	\nn\t3::File()->isForbidden('image.jpg'); => returns 'false'
	\nn\t3::File()->isForbidden('hack.php'); => return true
	\nn\t3::File()->isForbidden('.htaccess'); => returns 'true'

| ``@return boolean``

\\nn\\t3::File()->isVideo(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Indicates whether the file is a video

.. code-block:: php

	\nn\t3::File()->isVideo('path/to/video.mp4'); => returns true

| ``@return boolean``

\\nn\\t3::File()->mkdir(``$path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Create a folder

.. code-block:: php

	\nn\t3::File()->mkdir( 'fileadmin/my/folder/' );
	\nn\t3::File()->mkdir( '1:/my/folder/' );

| ``@return boolean``

\\nn\\t3::File()->move(``$src = NULL, $dest = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Moves a file

.. code-block:: php

	\nn\t3::File()->move('fileadmin/image.jpg', 'fileadmin/image-copy.jpg');

| ``@return boolean``

\\nn\\t3::File()->moveUploadedFile(``$src = NULL, $dest = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Move an upload file to the destination directory

Can be absolute path to the upload tmp file – or a ``TYPO3\CMS\Core\Http\UploadedFile``,
which can be fetched in the controller via ``$this->request->getUploadedFiles()``

.. code-block:: php

	\nn\t3::File()->moveUploadedFile('/tmp/xjauGSaudsha', 'fileadmin/image-copy.jpg');
	\nn\t3::File()->moveUploadedFile( $fileObj, 'fileadmin/image-copy.jpg');

| ``@return string``

\\nn\\t3::File()->normalizePath(``$path``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löst ../../ specifications in path.
Works with both existing paths (per realpath) and
non-existing paths.

.. code-block:: php

	\nn\t3::File()->normalizePath( 'fileadmin/test/../image.jpg' ); => fileadmin/image.jpg

| ``@return string``

\\nn\\t3::File()->process(``$fileObj = '', $processing = [], $returnProcessedImage = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Calculates an image üover ``maxWidth``, ``maxHeight`` etc.
Simple version of ``\nn\t3::File()->processImage()``
Can be used when it is just a matter of generating resized images
without taking into account corrections to camera orientation etc.

Since crop settings are stored in FileReference and not File,
| ``cropVariant`` only works when &um;passed a ``FileReference``.

.. code-block:: php

	\nn\t3::File()->process( 'fileadmin/imgs/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( '1:/images/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFile, ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFile, ['maxWidth'=>200, 'absolute'=>true] );
	\nn\t3::File()->process( $sysFileReference, ['maxWidth'=>200, 'cropVariant'=>'square'] );

Using the ``$returnProcessedImage = true`` parameter, not the file path to the new image.
but the processedImage object is returned.

.. code-block:: php

	\nn\t3::File()->process( 'fileadmin/imgs/portrait.jpg', ['maxWidth'=>200], true );

| ``@return string``

\\nn\\t3::File()->processImage(``$filenameOrSysFile = '', $processing = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Can be called directly after upload_copy_move().
Corrects the orientation of the image, which may have been stored in EXIF data.
For simple ``maxWidth`` statements, use the ``\nn\t3::File()->process()`` method.

Statements für $processing:

| ``correctOrientation`` => Correct rotation (e.g. because photo was uploaded from smartphone)

| ``@return string``

\\nn\\t3::File()->read(``$src = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets the contents of a file

.. code-block:: php

	\nn\t3::File()->read('fileadmin/text.txt');

| ``@return string|boolean``

\\nn\\t3::File()->relPath(``$path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

relative path (from the current script) to a file / directory back.
If no path is given, the Typo3 root directory is returned

.. code-block:: php

	\nn\t3::File()->relPath( $file ); => ../fileadmin/image.jpg
	\nn\t3::File()->relPath(); => ../

| ``@return string``

\\nn\\t3::File()->resolvePathPrefixes(``$file = NULL, $absolute = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

EXT: resolve prefix to relative path

.. code-block:: php

	\nn\t3::File()->resolvePathPrefixes('EXT:extname'); => /typo3conf/ext/extname/
	\nn\t3::File()->resolvePathPrefixes('EXT:extname/'); => /typo3conf/ext/extname/
	\nn\t3::File()->resolvePathPrefixes('EXT:extname/image.jpg'); => /typo3conf/ext/extname/image.jpg
	\nn\t3::File()->resolvePathPrefixes('1:/uploads/image.jpg', true); => /var/www/website/fileadmin/uploads/image.jpg

| ``@return string``

\\nn\\t3::File()->sendDownloadHeader(``$filename = '', $filesize = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Send PHP header for download.
If the file physically exists, the ``filesize`` is determined automatically.

.. code-block:: php

	\nn\t3::File()->sendDownloadHeader( 'download.jpg' );
	\nn\t3::File()->sendDownloadHeader( 'path/to/file/download.jpg' );
	\nn\t3::File()->sendDownloadHeader( 'fakedatei.jpg', 1200 );

| ``@return void``

\\nn\\t3::File()->size(``$src = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the file size of a file in bytes.
If file does not exist, 0 is returned

.. code-block:: php

	\nn\t3::File()->size('fileadmin/image.jpg');

| ``@return integer``

\\nn\\t3::File()->stripPathSite(``$file, $prefix = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gives path to file / folder WITHOUT absolute path.
Optionally, a prefix can be specified.

Example:

.. code-block:: php

	\nn\t3::File()->stripPathSite('var/www/website/fileadmin/test.jpg'); ==> fileadmin/test.jpg
	\nn\t3::File()->stripPathSite('var/www/website/fileadmin/test.jpg', true); ==> var/www/website/fileadmin/test.jpg
	\nn\t3::File()->stripPathSite('fileadmin/test.jpg', true); ==> var/www/website/fileadmin/test.jpg
	\nn\t3::File()->stripPathSite('fileadmin/test.jpg', '../../'); ==> ../../fileadmin/test.jpg

| ``@return string``

\\nn\\t3::File()->suffix(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the suffix of the file

.. code-block:: php

	\nn\t3::File()->suffix('image.jpg'); => returns 'jpg'

| ``@return string``

\\nn\\t3::File()->suffixForMimeType(``$mime = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the suffix for a specific mime type / content type.
Very reduced version Ã¢ only a few types covered.
Extensive version: https://bit.ly/3B9KrNA

.. code-block:: php

	\nn\t3::File()->suffixForMimeType('image/jpeg'); => returns 'jpg'

| ``@return string``

\\nn\\t3::File()->type(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the type of file based on the file suffix

.. code-block:: php

	\nn\t3::File()->type('image.jpg'); => returns 'image'

| ``@return string``

\\nn\\t3::File()->uniqueFilename(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Creates a unique filename for the file if there is
a file with the same name already exists in the destination

.. code-block:: php

	$name = \nn\t3::File()->uniqueFilename('fileadmin/01.jpg'); // 'fileadmin/01-1.jpg'

| ``@return string``

\\nn\\t3::File()->unlink(``$file = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes a file completely from the server.
Also delete all ``sys_file`` and ``sys_file_references`` that refer to the file.
For security, no PHP or HTML files can be deleted.

.. code-block:: php

	\nn\t3::File()->unlink('fileadmin/image.jpg'); // Path to the image.
	\nn\t3::File()->unlink('/abs/path/to/file/fileadmin/image.jpg'); // absolute path to the image
	\nn\t3::File()->unlink('1:/my/image.jpg'); // Combined identifier notation
	\nn\t3::File()->unlink( $model->getImage() ); // \TYPO3\CMS\Extbase\Domain\Model\FileReference
	\nn\t3::File()->unlink( $falFile ); // \TYPO3\CMS\Core\Resource\FileReference

| ``@return boolean``

\\nn\\t3::File()->write(``$path = NULL, $content = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Create a folder and/or file.
Also creates the folders if they do not exist.

.. code-block:: php

	\nn\t3::File()->write('fileadmin/some/deep/folder/');
	\nn\t3::File()->write('1:/some/deep/folder/');
	\nn\t3::File()->write('fileadmin/some/deep/folder/file.json', 'TEXT');

| ``@return boolean``

