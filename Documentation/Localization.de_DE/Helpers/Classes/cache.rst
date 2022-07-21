
.. include:: ../../Includes.txt

.. _Cache:

==============================================
Cache
==============================================

\\nn\\t3::Cache()
----------------------------------------------

Methoden, zum Lesen und Schreiben in den Typo3 Cache.
Nutzt das Caching-Framework von Typo3, siehe ``EXT:nnhelpers/ext_localconf.php`` für Details

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Cache()->clear(``$identifier = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löscht Caches.
Wird ein ``identifier`` angegeben, dann werden nur die Caches des spezifischen
identifiers gelöscht – sonst ALLE Caches aller Extensions und Seiten.

RAM-Caches
CachingFramework-Caches, die per ``\nn\t3::Cache()->set()`` gesetzt wurde
Datei-Caches, die per ``\nn\t3::Cache()->write()`` gesetzt wurde

.. code-block:: php

	// ALLE Caches löschen – auch die Caches anderer Extensions, der Seiten etc.
	\nn\t3::Cache()->clear();
	
	// Nur die Caches mit einem bestimmten Identifier löschen
	\nn\t3::Cache()->clear('nnhelpers');

| ``@param string $identifier``
| ``@return void``

\\nn\\t3::Cache()->clearPageCache(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löscht den Seiten-Cache. Alias zu ``\nn\t3::Page()->clearCache()``

.. code-block:: php

	\nn\t3::Cache()->clearPageCache( 17 );       // Seiten-Cache für pid=17 löschen
	\nn\t3::Cache()->clearPageCache();           // Cache ALLER Seiten löschen

| ``@param mixed $pid``     pid der Seite, deren Cache gelöscht werden soll oder leer lassen für alle Seite
| ``@return void``

\\nn\\t3::Cache()->get(``$identifier = '', $useRamCache = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lädt Inhalt des Typo3-Caches anhand eines Identifiers.
Der Identifier ist ein beliebiger String oder ein Array, der den Cache eindeutif Identifiziert.

.. code-block:: php

	\nn\t3::Cache()->get('myid');
	\nn\t3::Cache()->get(['pid'=>1, 'uid'=>'7']);
	\nn\t3::Cache()->get(['func'=>__METHOD__, 'uid'=>'17']);
	\nn\t3::Cache()->get([__METHOD__=>$this->request->getArguments()]);

| ``@param mixed $identifier``  String oder Array zum Identifizieren des Cache
| ``@param mixed $useRamCache`` temporärer Cache in $GLOBALS statt Caching-Framework

| ``@return mixed``

\\nn\\t3::Cache()->getIdentifier(``$identifier = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Wandelt übergebenen Cache-Identifier in brauchbaren String um.
Kann auch ein Array als Identifier verarbeiten.

| ``@param mixed $indentifier``
| ``@return string``

\\nn\\t3::Cache()->read(``$identifier``);
"""""""""""""""""""""""""""""""""""""""""""""""

Statischen Datei-Cache lesen.

Liest die PHP-Datei, die per ``\nn\t3::Cache()->write()`` geschrieben wurde.

.. code-block:: php

	$cache = \nn\t3::Cache()->read( $identifier );

Die PHP-Datei ist ein ausführbares PHP-Script mit dem ``return``-Befehl.
Sie speichert den Cache-Inhalt in einem Array.

.. code-block:: php

	<?php
	    return ['_'=>...];

| ``@return string|array``

\\nn\\t3::Cache()->set(``$identifier = '', $data = NULL, $useRamCache = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Schreibt einen Eintrag in den Typo3-Cache.
Der Identifier ist ein beliebiger String oder ein Array, der den Cache eindeutif Identifiziert.

.. code-block:: php

	// Klassische Anwendung im Controller: Cache holen und setzen
	if ($cache = \nn\t3::Cache()->get('myid')) return $cache;
	...
	$cache = $this->view->render();
	return \nn\t3::Cache()->set('myid', $cache);

.. code-block:: php

	// RAM-Cache verwenden? TRUE als dritter Parameter setzen
	\nn\t3::Cache()->set('myid', $dataToCache, true);
	
	// Dauer des Cache auf 60 Minuten festlegen
	\nn\t3::Cache()->set('myid', $dataToCache, 3600);
	
	// Als key kann auch ein Array angegeben werden
	\nn\t3::Cache()->set(['pid'=>1, 'uid'=>'7'], $html);

| ``@param mixed $indentifier`` String oder Array zum Identifizieren des Cache
| ``@param mixed $data``            Daten, die in den Cache geschrieben werden sollen. (String oder Array)
| ``@param mixed $useRamCache`` ``true``: temporärer Cache in $GLOBALS statt Caching-Framework.
| ``integer``: Wie viele Sekunden cachen?

| ``@return mixed``

\\nn\\t3::Cache()->write(``$identifier, $cache``);
"""""""""""""""""""""""""""""""""""""""""""""""

Statischen Datei-Cache schreiben.

Schreibt eine PHP-Datei, die per ``$cache = require('...')`` geladen werden kann.

Angelehnt an viele Core-Funktionen und Extensions (z.B. mask), die statische PHP-Dateien
ins Filesystem legen, um performancelastige Prozesse wie Klassenpfade, Annotation-Parsing etc.
besser zu cachen. Nutzt bewußt nicht die Core-Funktionen, um jeglichen Overhead zu
vermeiden und größtmögliche Kompatibilität bei Core-Updates zu gewährleisten.

.. code-block:: php

	$cache = ['a'=>1, 'b'=>2];
	$identifier = 'myid';
	
	\nn\t3::Cache()->write( $identifier, $cache );
	$read = \nn\t3::Cache()->read( $identifier );

Das Beispiel oben generiert eine PHP-Datei mit diesem Inhalt:

.. code-block:: php

	<?php
	return ['_' => ['a'=>1, 'b'=>2]];

| ``@return string|array``

