
.. include:: ../../Includes.txt

.. _File:

==============================================
File
==============================================

\\nn\\t3::File()
----------------------------------------------

Methoden rund um das Dateisystem:
Lesen, Schreiben, Kopieren, Verschieben und Bereinigen von Dateien.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::File()->absPath(``$file = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Absoluter Pfad zu einer Datei auf dem Server.

Gibt den kompletten Pfad ab der Server-Root zurück, z.B. ab ``/var/www/...``.
Falls der Pfad bereits absolut war, wird er unverändert zurückgegeben.

.. code-block:: php

	\nn\t3::File()->absPath('fileadmin/bild.jpg');                   // => /var/www/website/fileadmin/bild.jpg
	\nn\t3::File()->absPath('/var/www/website/fileadmin/bild.jpg');  // => /var/www/website/fileadmin/bild.jpg
	\nn\t3::File()->absPath('EXT:nnhelpers');                        // => /var/www/website/typo3conf/ext/nnhelpers/

Außer dem Dateipfad als String können auch alle denkbaren Objekte übergeben werden:

.. code-block:: php

	// \TYPO3\CMS\Core\Resource\Folder
	\nn\t3::File()->absPath( $folderObject );    => /var/www/website/fileadmin/bild.jpg
	
	// \TYPO3\CMS\Core\Resource\File
	\nn\t3::File()->absPath( $fileObject );      => /var/www/website/fileadmin/bild.jpg
	
	// \TYPO3\CMS\Extbase\Domain\Model\FileReference
	\nn\t3::File()->absPath( $fileReference );   => /var/www/website/fileadmin/bild.jpg

Existiert auch als ViewHelper:

.. code-block:: php

	{nnt3:file.absPath(file:'pfad/zum/bild.jpg')}

| ``@return boolean``

\\nn\\t3::File()->absUrl(``$file = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Absolute URL zu einer Datei generieren.
Gibt den kompletten Pfad zur Datei inkl. ``https://.../`` zurück.

.. code-block:: php

	// => https://www.myweb.de/fileadmin/bild.jpg
	\nn\t3::File()->absUrl( 'fileadmin/bild.jpg' );
	
	// => https://www.myweb.de/fileadmin/bild.jpg
	\nn\t3::File()->absUrl( 'https://www.myweb.de/fileadmin/bild.jpg' );
	
	// => /var/www/vhost/somewhere/fileadmin/bild.jpg
	\nn\t3::File()->absUrl( 'https://www.myweb.de/fileadmin/bild.jpg' );

| ``@return string``

\\nn\\t3::File()->addPathSite(``$file``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt Pfad zu Datei / Ordner MIT absoluten Pfad

Beispiel:

.. code-block:: php

	\nn\t3::File()->addPathSite('fileadmin/test.jpg');
	 // ==> gibt var/www/website/fileadmin/test.jpg zurück

| ``@return string``

\\nn\\t3::File()->addSuffix(``$filename = NULL, $newSuffix = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ersetzt den suffix für einen Dateinamen.

.. code-block:: php

	\nn\t3::File()->suffix('bild', 'jpg');               //  => bild.jpg
	\nn\t3::File()->suffix('bild.png', 'jpg');           //  => bild.jpg
	\nn\t3::File()->suffix('pfad/zu/bild.png', 'jpg');   //  => pfad/zu/bild.jpg

| ``@return string``

\\nn\\t3::File()->cleanFilename(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Bereinigt einen Dateinamen

.. code-block:: php

	$clean = \nn\t3::File()->cleanFilename('fileadmin/nö:so nicht.jpg'); // 'fileadmin/noe_so_nicht.jpg'

| ``@return string``

\\nn\\t3::File()->copy(``$src = NULL, $dest = NULL, $renameIfFileExists = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Kopiert eine Datei.
Gibt ``false`` zurück, falls die Datei nicht kopiert werden konnte.
Gibt (neuen) Dateinamen zurück, falls das Kopieren erfolgreich war.

.. code-block:: php

	$filename = \nn\t3::File()->copy('fileadmin/bild.jpg', 'fileadmin/bild-kopie.jpg');

| ``@param string $src``    Pfad zur Quelldatei
| ``@param string $dest``   Pfad zur Zieldatei
| ``@param boolean $renameIfFileExists``    Datei umbenennen, falls am Zielort bereits Datei mit gleichem Namen existiert
| ``@return string|boolean``

\\nn\\t3::File()->createFolder(``$path = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einen Ordner im ``fileadmin/`` erzeugen.
Um einen Ordner außerhalb des ``fileadmin`` anzulegen, die Methode ``\nn\t3::File()->mkdir()`` verwenden.

.. code-block:: php

	\nn\t3::File()->createFolder('tests');

| ``@return boolean``

\\nn\\t3::File()->download(``$files = NULL, $filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Download einer einzelnen Datei oder eines gezippten Archives.

Download als ZIP erfordert die PHP-Extension ``gmp``. Falls Extension nicht vorhanden ist,
wird auf ``.tar``-Variante ausgewichen. Bei Mac verwendet die Funktion aufgrund von
Sicherheitswarnungen des Finders grundsätzlich ``tar``

.. code-block:: php

	\nn\t3::File()->download( 'fileadmin/test.pdf' );
	\nn\t3::File()->download( $fileReference );
	\nn\t3::File()->download( $sysFile );
	\nn\t3::File()->download( 'fileadmin/test.pdf', 'download.pdf' );

Wird ein Array übergeben, wird ein tar/zip-Download gestartet.
Durch Übergabe eines assoziativen Arrays mit Dateiname als key und Pfad im Archiv als value
Kann die Datei- und Ordnerstruktur im zip-Archiv bestimmt werden.

.. code-block:: php

	\nn\t3::File()->download( ['fileadmin/test-1.pdf', 'fileadmin/test-2.pdf'], 'archive.zip' );
	\nn\t3::File()->download( ['fileadmin/test-1.pdf'=>'eins.pdf', 'fileadmin/test-2.pdf'=>'zwei.pdf'], 'archive.zip' );
	\nn\t3::File()->download( ['fileadmin/test-1.pdf'=>'zip-folder-1/eins.pdf', 'fileadmin/test-2.pdf'=>'zip-folder-2/zwei.pdf'], 'archive.zip' );

| ``@param mixed $files``           String oder Array der Dateien, die geladen werden sollen
| ``@param mixed $filename``        Optional: Dateinamen überschreiben beim Download
| ``@return void``

\\nn\\t3::File()->exists(``$src = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob eine Datei existiert.
Gibt absoluten Pfad zur Datei zurück.

.. code-block:: php

	\nn\t3::File()->exists('fileadmin/bild.jpg');

Existiert auch als ViewHelper:

.. code-block:: php

	{nnt3:file.exists(file:'pfad/zum/bild.jpg')}

| ``@return string|boolean``

\\nn\\t3::File()->extractExifData(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

EXIF Daten für Datei in JSON speichern.

.. code-block:: php

	\nn\t3::File()->extractExifData( 'yellowstone.jpg' );

| ``@return array``

\\nn\\t3::File()->getData(``$file = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Imageinfo + EXIF Data für Datei holen.
Sucht auch nach JSON-Datei, die evtl. nach processImage() generiert wurde

| ``@return array``

\\nn\\t3::File()->getExifData(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

ALLE EXIF Daten für Datei holen.

.. code-block:: php

	\nn\t3::File()->getExif( 'yellowstone.jpg' );

| ``@return array``

\\nn\\t3::File()->getFolder(``$file``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt den Ordner zu einer Datei zurück

Beispiel:

.. code-block:: php

	\nn\t3::File()->getFolder('fileadmin/test/beispiel.txt');
	// ==> gibt 'fileadmin/test/' zurück

| ``@return string``

\\nn\\t3::File()->getImageData(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

EXIF Bild-Daten für Datei holen.

.. code-block:: php

	\nn\t3::File()->getImageData( 'yellowstone.jpg' );

| ``@return array``

\\nn\\t3::File()->getImageSize(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

imagesize für Datei holen.

.. code-block:: php

	\nn\t3::File()->getImageSize( 'yellowstone.jpg' );

| ``@return array``

\\nn\\t3::File()->getLocationData(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

EXIF GEO-Daten für Datei holen.
Adressdaten werden automatisch ermittelt, falls möglich

.. code-block:: php

	\nn\t3::File()->getLocationData( 'yellowstone.jpg' );

| ``@return array``

\\nn\\t3::File()->getPath(``$file, $storage = NULL, $absolute = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt den Pfad einer Datei anhand eines Dateinamens und der Storage wieder.
Beispiel:

.. code-block:: php

	\nn\t3::File()->getPath('media/bild.jpg', $storage);
	// ==> gibt '/var/www/.../fileadmin/media/bild.jpg' zurück
	\nn\t3::File()->getPath('fileadmin/media/bild.jpg');
	// ==> gibt '/var/www/.../fileadmin/media/bild.jpg' zurück

| ``@return string``

\\nn\\t3::File()->getPublicUrl(``$obj = NULL, $absolute = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt Pfad zur Datei, relativ zum Typo3-Installtionsverzeichnis (PATH_site).
Kann mit allen Arten von Objekten umgehen.

.. code-block:: php

	\nn\t3::File()->getPublicUrl( $falFile );        // \TYPO3\CMS\Core\Resource\FileReference
	\nn\t3::File()->getPublicUrl( $fileReference );  // \TYPO3\CMS\Extbase\Domain\Model\FileReference
	\nn\t3::File()->getPublicUrl( $folder );         // \TYPO3\CMS\Core\Resource\Folder
	\nn\t3::File()->getPublicUrl( $folder, true );   // https://.../fileadmin/bild.jpg

| ``@return string``

\\nn\\t3::File()->getRelativePathInStorage(``$file, $storage = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt den relativen Pfad einer Datei zur angegebenen Storage wieder.

Beispiel:

.. code-block:: php

	\nn\t3::File()->getRelativePathInStorage('fileadmin/media/bild.jpg', $storage);
	// ==> gibt 'media/bild.jpg' zurück

| ``@return string``

\\nn\\t3::File()->getStorage(``$file, $createIfNotExists = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Findet ein passendes sys_file_storage zu einem Datei- oder Ordnerpfad.
Durchsucht dazu alle sys_file_storage-Einträge und vergleicht,
ob der basePath des Storages zum Pfad der Datei passt.

.. code-block:: php

	\nn\t3::File()->getStorage('fileadmin/test/beispiel.txt');
	\nn\t3::File()->getStorage( $falFile );
	\nn\t3::File()->getStorage( $sysFileReference );
	// gibt ResourceStorage mit basePath "fileadmin/" zurück

| ``@return ResourceStorage``

\\nn\\t3::File()->isAllowed(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt an, ob der Dateityp erlaubt ist

.. code-block:: php

	\nn\t3::File()->isForbidden('bild.jpg'); => gibt 'true' zurück
	\nn\t3::File()->isForbidden('hack.php'); => gibt 'false' zurück

| ``@return boolean``

\\nn\\t3::File()->isConvertableToImage(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt an, ob die Datei in ein Bild konvertiert werden kann

.. code-block:: php

	\nn\t3::File()->isConvertableToImage('bild.jpg');    => gibt true zurück
	\nn\t3::File()->isConvertableToImage('text.ppt');    => gibt false zurück

| ``@return boolean``

\\nn\\t3::File()->isExternalVideo(``$url = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt an, ob es ein Video auf YouTube / Vimeo ist.
Falls ja, wird ein Array mit Angaben zum Einbetten zurückgegeben.

.. code-block:: php

	\nn\t3::File()->isExternalVideo('http://...');

| ``@return array|boolean``

\\nn\\t3::File()->isFolder(``$file``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt zurück, ob angegebener Pfad ein Ordner ist

Beispiel:

.. code-block:: php

	\nn\t3::File()->isFolder('fileadmin'); // => gibt true zurück

| ``@return boolean``

\\nn\\t3::File()->isForbidden(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt an, ob der Dateityp verboten ist

.. code-block:: php

	\nn\t3::File()->isForbidden('bild.jpg');     => gibt 'false' zurück
	\nn\t3::File()->isForbidden('hack.php');     => gibt 'true' zurück
	\nn\t3::File()->isForbidden('.htaccess');    => gibt 'true' zurück

| ``@return boolean``

\\nn\\t3::File()->isVideo(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt an, ob die Datei ein Video ist

.. code-block:: php

	\nn\t3::File()->isVideo('pfad/zum/video.mp4');       => gibt true zurück

| ``@return boolean``

\\nn\\t3::File()->mkdir(``$path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einen Ordner anlegen

.. code-block:: php

	\nn\t3::File()->mkdir( 'fileadmin/mein/ordner/' );
	\nn\t3::File()->mkdir( '1:/mein/ordner/' );

| ``@return boolean``

\\nn\\t3::File()->move(``$src = NULL, $dest = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Verschiebt eine Datei

.. code-block:: php

	\nn\t3::File()->move('fileadmin/bild.jpg', 'fileadmin/bild-kopie.jpg');

| ``@return boolean``

\\nn\\t3::File()->moveUploadedFile(``$src = NULL, $dest = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine Upload-Datei ins Zielverzeichnis verschieben.

Kann absoluter Pfad zur tmp-Datei des Uploads sein – oder ein ``TYPO3\CMS\Core\Http\UploadedFile``,
das sich im Controller über ``$this->request->getUploadedFiles()`` holen lässt.

.. code-block:: php

	\nn\t3::File()->moveUploadedFile('/tmp/xjauGSaudsha', 'fileadmin/bild-kopie.jpg');
	\nn\t3::File()->moveUploadedFile( $fileObj, 'fileadmin/bild-kopie.jpg');

| ``@return string``

\\nn\\t3::File()->normalizePath(``$path``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löst ../../-Angaben in Pfad auf.
Funktioniert sowohl mit existierenden Pfaden (per realpath) als auch
nicht-existierenden Pfaden.

.. code-block:: php

	\nn\t3::File()->normalizePath( 'fileadmin/test/../bild.jpg' );       =>   fileadmin/bild.jpg

| ``@return string``

\\nn\\t3::File()->process(``$fileObj = '', $processing = [], $returnProcessedImage = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Berechnet ein Bild über ``maxWidth``, ``maxHeight`` etc.
Einfache Version von ``\nn\t3::File()->processImage()``
Kann verwendet werden, wenn es nur um das Generieren von verkleinerten Bilder geht
ohne Berücksichtigung von Korrekturen der Kamera-Ausrichtung etc.

Da die Crop-Einstellungen in FileReference und nicht File gespeichert sind,
funktioniert ``cropVariant`` nur bei Übergabe einer ``FileReference``.

.. code-block:: php

	\nn\t3::File()->process( 'fileadmin/imgs/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( '1:/bilder/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFile, ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFile, ['maxWidth'=>200, 'absolute'=>true] );
	\nn\t3::File()->process( $sysFileReference, ['maxWidth'=>200, 'cropVariant'=>'square'] );

Mit dem Parameter ``$returnProcessedImage = true`` wird nicht der Dateipfad zum neuen Bild
sondern das processedImage-Object zurückgegeben.

.. code-block:: php

	\nn\t3::File()->process( 'fileadmin/imgs/portrait.jpg', ['maxWidth'=>200], true );

| ``@return string``

\\nn\\t3::File()->processImage(``$filenameOrSysFile = '', $processing = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Kann direkt nach dem upload_copy_move() aufgerufen werden.
Korrigiert die Ausrichtung des Bildes, die evtl. in EXIF-Daten gespeichert wurde.
Für einfach ``maxWidth``-Anweisungen die Methode ``\nn\t3::File()->process()`` verwenden.

Anweisungen für $processing:

| ``correctOrientation`` =>  Drehung korrigieren (z.B. weil Foto vom Smartphone hochgeladen wurde)

| ``@return string``

\\nn\\t3::File()->read(``$src = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt den Inhalt einer Datei

.. code-block:: php

	\nn\t3::File()->read('fileadmin/text.txt');

| ``@return string|boolean``

\\nn\\t3::File()->relPath(``$path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

relativen Pfad (vom aktuellen Script aus) zum einer Datei / Verzeichnis zurück.
Wird kein Pfad angegeben, wird das Typo3-Root-Verzeichnis zurückgegeben.

.. code-block:: php

	\nn\t3::File()->relPath( $file );        => ../fileadmin/bild.jpg
	\nn\t3::File()->relPath();               => ../

| ``@return string``

\\nn\\t3::File()->resolvePathPrefixes(``$file = NULL, $absolute = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

EXT: Prefix auflösen zu relativer Pfadangabe

.. code-block:: php

	\nn\t3::File()->resolvePathPrefixes('EXT:extname');                  => /typo3conf/ext/extname/
	\nn\t3::File()->resolvePathPrefixes('EXT:extname/');                 => /typo3conf/ext/extname/
	\nn\t3::File()->resolvePathPrefixes('EXT:extname/bild.jpg');         => /typo3conf/ext/extname/bild.jpg
	\nn\t3::File()->resolvePathPrefixes('1:/uploads/bild.jpg', true);    => /var/www/website/fileadmin/uploads/bild.jpg

| ``@return string``

\\nn\\t3::File()->sendDownloadHeader(``$filename = '', $filesize = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

PHP Header für Download senden.
Wenn die Datei physisch existiert, wird die ``filesize`` automatisch ermittelt.

.. code-block:: php

	\nn\t3::File()->sendDownloadHeader( 'download.jpg' );
	\nn\t3::File()->sendDownloadHeader( 'pfad/zur/datei/download.jpg' );
	\nn\t3::File()->sendDownloadHeader( 'fakedatei.jpg', 1200 );

| ``@return void``

\\nn\\t3::File()->size(``$src = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt Dateigröße zu einer Datei in Bytes zurück
Falls Datei nicht exisitert, wird 0 zurückgegeben.

.. code-block:: php

	\nn\t3::File()->size('fileadmin/bild.jpg');

| ``@return integer``

\\nn\\t3::File()->stripPathSite(``$file, $prefix = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt Pfad zu Datei / Ordner OHNE absoluten Pfad.
Optional kann ein Prefix angegeben werden.

Beispiel:

.. code-block:: php

	\nn\t3::File()->stripPathSite('var/www/website/fileadmin/test.jpg');         ==>  fileadmin/test.jpg
	\nn\t3::File()->stripPathSite('var/www/website/fileadmin/test.jpg', true);   ==>  var/www/website/fileadmin/test.jpg
	\nn\t3::File()->stripPathSite('fileadmin/test.jpg', true);                   ==>  var/www/website/fileadmin/test.jpg
	\nn\t3::File()->stripPathSite('fileadmin/test.jpg', '../../');               ==>  ../../fileadmin/test.jpg

| ``@return string``

\\nn\\t3::File()->suffix(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt den Suffix der Datei zurück

.. code-block:: php

	\nn\t3::File()->suffix('bild.jpg');  => gibt 'jpg' zurück

| ``@return string``

\\nn\\t3::File()->suffixForMimeType(``$mime = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt den Suffix für einen bestimmten Mime-Type / Content-Type zurück.
Sehr reduzierte Variante – nur wenige Typen abgedeckt.
Umfangreiche Version: https://bit.ly/3B9KrNA

.. code-block:: php

	\nn\t3::File()->suffixForMimeType('image/jpeg'); => gibt 'jpg' zurück

| ``@return string``

\\nn\\t3::File()->type(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt die Art der Datei anhand des Datei-Suffixes zurück

.. code-block:: php

	\nn\t3::File()->type('bild.jpg');    => gibt 'image' zurück
	\nn\t3::File()->type('text.doc');    => gibt 'document' zurück

| ``@return string``

\\nn\\t3::File()->uniqueFilename(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Erzeugt einen eindeutigen Dateinamen für die Datei, falls
im Zielverzeichnis bereits eine Datei mit identischem Namen
existiert.

.. code-block:: php

	$name = \nn\t3::File()->uniqueFilename('fileadmin/01.jpg');  // 'fileadmin/01-1.jpg'

| ``@return string``

\\nn\\t3::File()->unlink(``$file = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löscht eine Datei komplett vom Sever.
Löscht auch alle ``sys_file`` und ``sys_file_references``, die auf die Datei verweisen.
Zur Sicherheit können keine PHP oder HTML Dateien gelöscht werden.

.. code-block:: php

	\nn\t3::File()->unlink('fileadmin/bild.jpg');                    // Pfad zum Bild
	\nn\t3::File()->unlink('/abs/path/to/file/fileadmin/bild.jpg');  // absoluter Pfad zum Bild
	\nn\t3::File()->unlink('1:/my/image.jpg');                       // Combined identifier Schreibweise
	\nn\t3::File()->unlink( $model->getImage() );                 // \TYPO3\CMS\Extbase\Domain\Model\FileReference
	\nn\t3::File()->unlink( $falFile );                              // \TYPO3\CMS\Core\Resource\FileReference

| ``@return boolean``

\\nn\\t3::File()->write(``$path = NULL, $content = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einen Ordner und/oder Datei erzeugen.
Legt auch die Ordner an, falls sie nicht existieren.

.. code-block:: php

	\nn\t3::File()->write('fileadmin/some/deep/folder/');
	\nn\t3::File()->write('1:/some/deep/folder/');
	\nn\t3::File()->write('fileadmin/some/deep/folder/file.json', 'TEXT');

| ``@return boolean``

