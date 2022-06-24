
.. include:: ../../Includes.txt

.. _Cache:

==============================================
Cache
==============================================

\\nn\\t3::Cache()
----------------------------------------------

Methods, for reading and writing to the Typo3 cache.
Uses Typo3's caching framework, see ``EXT:nnhelpers/ext_localconf.php`` for details
.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Cache()->clear(``$identifier = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes caches.
If a ``identifier`` is specified, then only the caches of the specific
identifier will be deleted Ã¢ otherwise ALL caches of all extensions and pages.

RAM caches
CachingFramework caches set via ``\nn\t3::Cache()->set()``
File caches set by ``\nn\t3::Cache()->write()``

.. code-block:: php

	// Clear ALL caches Ã¢ including the caches of other extensions, the pages etc.
	\nn\t3::Cache()->clear();
	
	// Delete only the caches with a given identifier.
	\nn\t3::Cache()->clear('nnhelpers');

| ``@param string $identifier``
| ``@return void``

\\nn\\t3::Cache()->clearPageCache(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

clears the page cache. Alias to ``\nn\t3::Page()->clearCache()``

.. code-block:: php

	\nn\t3::Cache()->clearPageCache( 17 ); // clear page cache for pid=17.
	\nn\t3::Cache()->clearPageCache(); // clear cache of ALL pages

| ``@param mixed $pid`` pid of the page whose cache should be cleared, or leave empty for all pages
| ``@return void``

\\nn\\t3::Cache()->get(``$identifier = '', $useRamCache = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lädt contents of the Typo3 cache using an identifier.
The identifier is an arbitrary string or array that uniquely identifies the cache.

.. code-block:: php

	\nn\t3::Cache()->get('myid');
	\nn\t3::Cache()->get(['pid'=>1, 'uid'=>'7']);
	\nn\t3::Cache()->get(['func'=>__METHOD__, 'uid'=>'17']);
	\nn\t3::Cache()->get([__METHOD__=>$this->request->getArguments()]);

| ``@param mixed $identifier`` String or array to identify the cache.
| ``@param mixed $useRamCache`` temporärer cache in $GLOBALS instead of caching framework

| ``@return mixed``

\\nn\\t3::Cache()->getIdentifier(``$identifier = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts üpassed cache identifier to usable string.
Can also handle an array as an identifier.

| ``@param mixed $indentifier``
| ``@return string``

\\nn\\t3::Cache()->read(``$identifier``);
"""""""""""""""""""""""""""""""""""""""""""""""

Read static file cache.

Reads the PHP file written via ``\nn\t3::Cache()->write()``.

.. code-block:: php

	$cache = \nn\t3::Cache()->read( $identifier );

The PHP file is an executable PHP script with the ``return`` command.
It stores the cache contents in an array.

.. code-block:: php

	<?php
	    return ['_'=>...];

| ``@return string|array``

\\nn\\t3::Cache()->set(``$identifier = '', $data = NULL, $useRamCache = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Writes an entry into the Typo3 cache.
The identifier is an arbitrary string or array that uniquely identifies the cache.

.. code-block:: php

	// Classic application in the controller: get and set cache.
	if ($cache = \nn\t3::Cache()->get('myid')) return $cache;
	...
	$cache = $this->view->render();
	return \nn\t3::Cache()->set('myid', $cache);

.. code-block:: php

	// Use RAM cache? Set TRUE as the third parameter
	\nn\t3::Cache()->set('myid', $dataToCache, true);
	
	// set duration of cache to 60 minutes
	\nn\t3::Cache()->set('myid', $dataToCache, 3600);
	
	// You can also specify an array as key
	\nn\t3::Cache()->set(['pid'=>1, 'uid'=>'7'], $html);

| ``@param mixed $indentifier`` String or array to identify the cache.
| ``@param mixed $data`` Data to be written to the cache. (string or array)
| ``@param mixed $useRamCache`` ``true``: temporärer cache in $GLOBALS instead of caching framework.
| ``integer``: how many seconds cache?

| ``@return mixed``

.

\\nn\\t3::Cache()->write(``$identifier, $cache``);
"""""""""""""""""""""""""""""""""""""""""""""""

Write static file cache.

Writes a PHP file that can be loaded via ``$cache = require('...')``.

Mimics many core functions and extensions (e.g. mask) that put static PHP files
into the filesystem to better cache performance-heavy processes such as classpaths, annotation parsing, etc.
better cached. Consciously do not use the core functions to avoid any overhead and to be more
overhead and to ensure maximum compatibility with core updates.

.. code-block:: php

	$cache = ['a'=>1, 'b'=>2];
	$identifier = 'myid';
	
	\nn\t3::Cache()->write( $identifier, $cache );
	$read = \nn\t3::Cache()->read( $identifier );

The example above generates a PHP file with this content:

.. code-block:: php

	<?php
	return ['_' => ['a'=>1, 'b'=>2]];

| ``@return string|array``

