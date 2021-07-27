
.. include:: ../../Includes.txt

.. _Storage:

==============================================
Storage
==============================================

\\nn\\t3::Storage()
----------------------------------------------

All about Storages

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Storage()->clearStorageRowCache();
"""""""""""""""""""""""""""""""""""""""""""""""

clears the StorageRowCache

.. code-block:: php

	 \nn\t3::Storage()->clearStorageRowCache();

| ``@return void``

\\nn\\t3::Storage()->getFolder(``$file, $storage = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the \Folder object for a destination folder (or file) within a storage.
Creates folder if it does not already exist

Examples:

.. code-block:: php

	\nn\t3::Storage()->getFolder( 'fileadmin/test/example.txt' );
	\nn\t3::Storage()->getFolder( 'fileadmin/test/' );
	        ==> returns \Folder object for the folder 'test/'

| ``@return Folder``

\\nn\\t3::Storage()->getPid(``$extName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

In the controller: get current StoragePid for a plugin.
Alias to ``\nn\t3::Settings()->getStoragePid()``

.. code-block:: php

	\nn\t3::Storage()->getPid();
	\nn\t3::Storage()->getPid('news');

| ``@return string``

