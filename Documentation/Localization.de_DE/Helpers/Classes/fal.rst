
.. include:: ../../Includes.txt

.. _Fal:

==============================================
Fal
==============================================

\\nn\\t3::Fal()
----------------------------------------------

Methoden zum Erzeugen von sysFile und sysFileReference-Einträgen.

Spickzettel:

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

Eine Datei zu einem FileReference-Object konvertieren und
an die Property oder ObjectStorage eines Models hängen.
Siehe auch: ``\nn\t3::Fal()->setInModel( $member, 'falslideshow', $imagesToSet );`` mit dem
Array von mehreren Bildern an eine ObjectStorage gehängt werden können.

.. code-block:: php

	\nn\t3::Fal()->attach( $model, $fieldName, $filePath );
	\nn\t3::Fal()->attach( $model, 'image', 'fileadmin/user_uploads/image.jpg' );
	\nn\t3::Fal()->attach( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg'] );
	\nn\t3::Fal()->attach( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg', 'title'=>'Titel...'] );

| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

\\nn\\t3::Fal()->clearCache(``$filenameOrSysFile = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löscht den Cache für die Bildgrößen eines FAL inkl. der umgerechneten Bilder
Wird z.B. der f:image-ViewHelper verwendet, werden alle berechneten Bildgrößen
in der Tabelle sys_file_processedfile gespeichert. Ändert sich das Originalbild,
wird evtl. noch auf ein Bild aus dem Cache zugegriffen.

.. code-block:: php

	\nn\t3::Fal()->clearCache( 'fileadmin/file.jpg' );
	\nn\t3::Fal()->clearCache( $fileReference );
	\nn\t3::Fal()->clearCache( $falFile );

| ``@param $filenameOrSysFile``     FAL oder Pfad (String) zu der Datei
| ``@return void``

\\nn\\t3::Fal()->createFalFile(``$storageConfig, $srcFile, $keepSrcFile = false, $forceCreateNew = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Erzeugt ein \File (FAL) Object (sys_file)

\nn\t3::Fal()->createFalFile( $storageConfig, $srcFile, $keepSrcFile, $forceCreateNew );

| ``@param string $storageConfig``  Pfad/Ordner, in die FAL-Datei gespeichert werden soll (z.B. 'fileadmin/projektdaten/')
| ``@param string $srcFile``            Quelldatei, die in FAL umgewandelt werden soll  (z.B. 'uploads/tx_nnfesubmit/beispiel.jpg')
Kann auch URL zu YouTube/Vimeo-Video sein (z.B. https://www.youtube.com/watch?v=7Bb5jXhwnRY)
| ``@param boolean $keepSrcFile``       Quelldatei nur kopieren, nicht verschieben?
| ``@param boolean $forceCreateNew``    Soll immer neue Datei erzeugt werden? Falls nicht, gibt er ggf. bereits existierendes File-Object zurück

| ``@return \Nng\Nnhelpers\Domain\Model\File|\TYPO3\CMS\Core\Resource\File|boolean``

\\nn\\t3::Fal()->createForModel(``$model, $field, $itemData = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine Datei zu einem FileReference-Object konvertieren und für ``attach()`` an ein vorhandenes
Model und Feld / Property vorbereiten. Die FileReference wird dabei nicht automatisch
an das Model gehängt. Um das FAL direkt in dem Model zu setzen, kann der Helper
| ``\nn\t3::Fal()->attach( $model, $field, $itemData )`` verwendet werden.

.. code-block:: php

	\nn\t3::Fal()->createForModel( $model, $fieldName, $filePath );
	\nn\t3::Fal()->createForModel( $model, 'image', 'fileadmin/user_uploads/image.jpg' );
	\nn\t3::Fal()->createForModel( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg'] );
	\nn\t3::Fal()->createForModel( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg', 'title'=>'Titel...'] );

| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

\\nn\\t3::Fal()->createSysFile(``$file, $autoCreateStorage = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Erstellt neuen Eintrag in ``sys_file``
Sucht in allen ``sys_file_storage``-Einträgen, ob der Pfad zum $file bereits als Storage existiert.
Falls nicht, wird ein neuer Storage angelegt.

.. code-block:: php

	\nn\t3::Fal()->createSysFile( 'fileadmin/bild.jpg' );
	\nn\t3::Fal()->createSysFile( '/var/www/mysite/fileadmin/bild.jpg' );

| ``@return false|\TYPO3\CMS\Core\Resource\File``

\\nn\\t3::Fal()->deleteProcessedImages(``$sysFile = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löscht alle physischen Thumbnail-Dateien, die für ein Bild generiert wurden inkl.
der Datensätze in der Tabelle ``sys_file_processedfile``.

Das Ursprungsbild, das als Argument ``$path`` übergeben wurde, wird dabei nicht gelöscht.
Das Ganze erzwingt das Neugenerieren der Thumbnails für ein Bild, falls sich z.B. das
Quellbild geändert hat aber der Dateiname gleich geblieben ist.

Weiterer Anwendungsfall: Dateien auf dem Server bereinigen, weil z.B. sensible, personenbezogene
Daten gelöscht werden sollen inkl. aller generierten Thumbnails.

.. code-block:: php

	\nn\t3::Fal()->deleteProcessedImages( 'fileadmin/pfad/beispiel.jpg' );
	\nn\t3::Fal()->deleteProcessedImages( $sysFileReference );
	\nn\t3::Fal()->deleteProcessedImages( $sysFile );

| ``@return mixed``

\\nn\\t3::Fal()->deleteSysFile(``$uidOrObject = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löscht ein SysFile (Datensatz aus Tabelle ``sys_file``) und alle dazugehörigen SysFileReferences.
Eine radikale Art, um ein Bild komplett aus der Indizierung von Typo3 zu nehmen.

Die physische Datei wird nicht vom Server gelöscht!
Siehe ``\nn\t3::File()->unlink()`` zum Löschen der physischen Datei.
Siehe ``\nn\t3::Fal()->detach( $model, $field );`` zum Löschen aus einem Model.

.. code-block:: php

	\nn\t3::Fal()->deleteSysFile( 1201 );
	\nn\t3::Fal()->deleteSysFile( 'fileadmin/pfad/zum/bild.jpg' );
	\nn\t3::Fal()->deleteSysFile( \TYPO3\CMS\Core\Resource\File );
	\nn\t3::Fal()->deleteSysFile( \TYPO3\CMS\Core\Resource\FileReference );

| ``@param $uidOrObject``

| ``@return integer``

\\nn\\t3::Fal()->deleteSysFileReference(``$uidOrFileReference = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löscht eine SysFileReference.
Siehe auch ``\nn\t3::Fal()->detach( $model, $field );`` zum Löschen aus einem Model.

.. code-block:: php

	\nn\t3::Fal()->deleteSysFileReference( 112 );
	\nn\t3::Fal()->deleteSysFileReference( \TYPO3\CMS\Extbase\Domain\Model\FileReference );

| ``@param $uidOrFileReference``

| ``@return mixed``

\\nn\\t3::Fal()->detach(``$model, $field, $obj = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Leert eine ObjectStorage in einem Model oder entfernt ein
einzelnes Object vom Model oder einer ObjectStorage.
Im Beispiel kann ``image`` eine ObjectStorage oder eine einzelne ``FileReference`` sein:

.. code-block:: php

	\nn\t3::Fal()->detach( $model, 'image' );
	\nn\t3::Fal()->detach( $model, 'image', $singleObjToRemove );

| ``@return void``

\\nn\\t3::Fal()->fileReferenceExists(``$sysFile = NULL, $params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob für einen Datensatz bereits eine SysFileReference zum gleichen SysFile exisitert

.. code-block:: php

	\nn\t3::Fal()->fileReferenceExists( $sysFile, ['uid_foreign'=>123, 'tablenames'=>'tt_content', 'field'=>'media'] );

| ``@param $sysFile``
| ``@param array $params`` => uid_foreign, tablenames, fieldname
| ``@return FileReference|false``

\\nn\\t3::Fal()->fromFile(``$params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Erzeugt ein FileRefence Objekt (Tabelle: ``sys_file_reference``) und verknüpft es mit einem Datensatz.
Beispiel: Hochgeladenes JPG soll als FAL an tt_news-Datensatz angehängt werden

Parameter:

key
Beschreibung

| ``src``
Pfad zur Quelldatei (kann auch http-Link zu YouTube-Video sein)

| ``dest``
Pfad zum Zielordner (optional, falls Datei verschoben/kopiert werden soll)

| ``table``
Ziel-Tabelle, dem die FileReference zugeordnet werden soll (z.B. ``tx_myext_domain_model_entry``)

| ``title``
Titel

| ``description``
Beschreibung

| ``link``
Link

| ``crop``
Beschnitt

| ``table``
Ziel-Tabelle, dem die FileReference zugeordnet werden soll (z.B. ``tx_myext_domain_model_entry``)

| ``sorting``
(int) Sortierung

| ``field``
Column-Name der Ziel-Tabelle, dem die FileReference zugeordnet werden soll (z.B. ``image``)

| ``uid``
(int) uid des Datensatzes in der Zieltabelle (``tx_myext_domain_model_entry.uid``)

| ``pid``
(int) pid des Datensatzes in der Zieltabelle

| ``cruser_id``
cruser_id des Datensatzes in der Zieltabelle

| ``copy``
src-Datei nicht verschieben sondern kopieren (default: ``true``)

| ``forceNew``
Im Zielordner neue Datei erzwingen (sonst wird geprüft, ob bereits Datei existiert) default: ``false``

| ``single``
Sicherstellen, dass gleiche FileReferenz nur 1x pro Datensatz verknüpft wird (default: ``true``)

Beispiel:

.. code-block:: php

	$fal = \nn\t3::Fal()->fromFile([
	    'src'           => 'fileadmin/test/bild.jpg',
	    'dest'          => 'fileadmin/test/fal/',
	    'pid'           => 132,
	    'uid'           => 5052,
	    'table'         => 'tx_myext_domain_model_entry',
	    'field'         => 'fallistimage'
	]);

| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

\\nn\\t3::Fal()->getFalFile(``$srcFile``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt ein \File (FAL) Object (``sys_file``)

.. code-block:: php

	\nn\t3::Fal()->getFalFile( 'fileadmin/image.jpg' );

| ``@param string $srcFile``
| ``@return \TYPO3\CMS\Core\Resource\File|boolean``

\\nn\\t3::Fal()->getFileObjectFromCombinedIdentifier(``$file = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt ein SysFile aus der CombinedIdentifier-Schreibweise ('1:/uploads/beispiel.txt').
Falls Datei nicht exisitert wird FALSE zurückgegeben.

.. code-block:: php

	\nn\t3::Fal()->getFileObjectFromCombinedIdentifier( '1:/uploads/beispiel.txt' );

| ``@param string $file``       Combined Identifier ('1:/uploads/beispiel.txt')
| ``@return File|boolean``

\\nn\\t3::Fal()->getFilePath(``$falReference``);
"""""""""""""""""""""""""""""""""""""""""""""""

Die URL zu einer FileReference oder einem FalFile holen.
Alias zu ``\nn\t3::File()->getPublicUrl()``.

.. code-block:: php

	\nn\t3::Fal()->getFilePath( $fileReference );    // ergibt z.B. 'fileadmin/bilder/01.jpg'

| ``@param \TYPO3\CMS\Extbase\Domain\Model\FileReference|\TYPO3\CMS\Core\Resource\FileReference $falReference``
| ``@return string``

\\nn\\t3::Fal()->getFileReferenceByUid(``$uid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt eine SysFileReference anhand der uid
Alias zu ``\nn\t3::Convert( $uid )->toFileReference()``;

.. code-block:: php

	\nn\t3::Fal()->getFileReferenceByUid( 123 );

| ``@param $uid``
| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

\\nn\\t3::Fal()->getImage(``$src = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt / konvertiert in ein \TYPO3\CMS\Core\Resource\FileReference Object (sys_file_reference)
"Smarte" Variante zu ``\TYPO3\CMS\Extbase\Service\ImageService->getImage()``

.. code-block:: php

	\nn\t3::Fal()->getImage( 1 );
	\nn\t3::Fal()->getImage( 'pfad/zum/bild.jpg' );
	\nn\t3::Fal()->getImage( $fileReference );

| ``@param string|\TYPO3\CMS\Extbase\Domain\Model\FileReference $src``
| ``@return \TYPO3\CMS\Core\Resource\FileReference|boolean``

\\nn\\t3::Fal()->process(``$fileObj = '', $processing = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Berechnet ein Bild über ``maxWidth``, ``maxHeight``, ``cropVariant`` etc.
Gibt URI zum Bild als String zurück. Hilfreich bei der Berechnung von Thumbnails im Backend.
Alias zu ``\nn\t3::File()->process()``

.. code-block:: php

	\nn\t3::File()->process( 'fileadmin/bilder/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( '1:/bilder/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFile, ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFileReference, ['maxWidth'=>200, 'cropVariant'=>'square'] );

| ``@return string``

\\nn\\t3::Fal()->setInModel(``$model, $fieldName = '', $imagesToAdd = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ersetzt eine ``FileReference`` oder ``ObjectStorage`` in einem Model mit Bildern.
Typischer Anwendungsfall: Ein FAL-Bild soll über ein Upload-Formular im Frontend geändert
werden können.

Für jedes Bild wird geprüft, ob bereits eine ``FileReference`` im Model existiert.
Bestehende FileReferences werden nicht überschrieben, sonst würden evtl.
Bildunterschriften oder Cropping-Anweisungen verloren gehen!

Achtung! Das Model wird automatisch persistiert!

.. code-block:: php

	$newModel = new \My\Extension\Domain\Model\Example();
	\nn\t3::Fal()->setInModel( $newModel, 'falslideshow', 'path/to/file.jpg' );
	echo $newModel->getUid(); // Model wurde persistiert!

Beispiel mit einer einfachen FileReference im Model:

.. code-block:: php

	$imageToSet = 'fileadmin/bilder/portrait.jpg';
	\nn\t3::Fal()->setInModel( $member, 'falprofileimage', $imageToSet );
	
	\nn\t3::Fal()->setInModel( $member, 'falprofileimage', ['publicUrl'=>'01.jpg', 'title'=>'Titel', 'description'=>'...'] );

Beispiel mit einem ObjectStorage im Model:

.. code-block:: php

	$imagesToSet = ['fileadmin/bilder/01.jpg', 'fileadmin/bilder/02.jpg', ...];
	\nn\t3::Fal()->setInModel( $member, 'falslideshow', $imagesToSet );
	
	\nn\t3::Fal()->setInModel( $member, 'falslideshow', [['publicUrl'=>'01.jpg'], ['publicUrl'=>'02.jpg']] );
	\nn\t3::Fal()->setInModel( $member, 'falvideos', [['publicUrl'=>'https://youtube.com/?watch=zagd61231'], ...] );

Beispiel mit Videos:

.. code-block:: php

	$videosToSet = ['https://www.youtube.com/watch?v=GwlU_wsT20Q', ...];
	\nn\t3::Fal()->setInModel( $member, 'videos', $videosToSet );

| ``@param mixed $model``               Das Model, das geändert werden soll
| ``@param string $fieldName``          Property (Feldname) der ObjectStorage oder FileReference
| ``@param mixed $imagesToAdd``     String / Array mit Bildern

| ``@return mixed``

\\nn\\t3::Fal()->toArray(``$fileReference = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine FileReference in ein Array konvertieren.
Enthält publicUrl, title, alternative, crop etc. der FileReference.
Alias zu ``\nn\t3::Obj()->toArray( $fileReference );``

.. code-block:: php

	\nn\t3::Fal()->toArray( $fileReference );    // ergibt ['publicUrl'=>'fileadmin/...', 'title'=>'...']

| ``@param \TYPO3\CMS\Extbase\Domain\Model\FileReference $falReference``
| ``@return array``

\\nn\\t3::Fal()->unlink(``$uidOrObject = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löscht ein SysFile und alle dazugehörigen SysFileReferences.
Alias zu ``\nn\t3::Fal()->deleteSysFile()``

| ``@return integer``

\\nn\\t3::Fal()->updateMetaData(``$filenameOrSysFile = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Update der Angaben in ``sys_file_metadata`` und ``sys_file``

.. code-block:: php

	\nn\t3::Fal()->updateMetaData( 'fileadmin/file.jpg' );
	\nn\t3::Fal()->updateMetaData( $fileReference );
	\nn\t3::Fal()->updateMetaData( $falFile );

| ``@param $filenameOrSysFile``     FAL oder Pfad (String) zu der Datei
| ``@param $data``              Array mit Daten, die geupdated werden sollen.
Falls leer, werden Bilddaten automatisch gelesen
| ``@return void``

