
.. include:: ../../Includes.txt

.. _Storage:

==============================================
Storage
==============================================

\\nn\\t3::Storage()
----------------------------------------------

Alles rund um Storages

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Storage()->clearStorageRowCache();
"""""""""""""""""""""""""""""""""""""""""""""""

Löscht den StorageRowCache

.. code-block:: php

	    \nn\t3::Storage()->clearStorageRowCache();

| ``@return void``

\\nn\\t3::Storage()->getFolder(``$file, $storage = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt den \Folder-Object für einen Zielordner (oder Datei) innerhalb einer Storage zurück.
Legt Ordner an, falls er noch nicht existiert

Beispiele:

.. code-block:: php

	\nn\t3::Storage()->getFolder( 'fileadmin/test/beispiel.txt' );
	\nn\t3::Storage()->getFolder( 'fileadmin/test/' );
	        ==>  gibt \Folder-Object für den Ordner 'test/' zurück

| ``@return Folder``

\\nn\\t3::Storage()->getPid(``$extName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Im Controller: Aktuelle StoragePid für ein PlugIn holen.
Alias zu ``\nn\t3::Settings()->getStoragePid()``

.. code-block:: php

	\nn\t3::Storage()->getPid();
	\nn\t3::Storage()->getPid('news');

| ``@return string``

