
.. include:: ../../Includes.txt

.. _Obj:

==============================================
Obj
==============================================

\\nn\\t3::Obj()
----------------------------------------------

Alles, was man für Objects und Models braucht.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Obj()->accessSingleProperty(``$obj, $key``);
"""""""""""""""""""""""""""""""""""""""""""""""

Zugriff auf einen Key in einem Object oder Array
key muss einzelner String sein, kein Pfad

\nn\t3::Obj()->accessSingleProperty( $obj, 'uid' );
\nn\t3::Obj()->accessSingleProperty( $obj, 'fal_media' );
\nn\t3::Obj()->accessSingleProperty( $obj, 'falMedia' );

| ``@param mixed $obj`` Model oder Array
| ``@param string $key`` der Key, der geholt werden soll

| ``@return mixed``

\\nn\\t3::Obj()->diff(``$objA, $objB, $fieldsToIgnore = [], $fieldsToCompare = [], $options = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Vergleicht zwei Objekte, gibt Array mit Unterschieden zurück.
Existiert eine Property von objA nicht in objB, wird diese ignoriert.

.. code-block:: php

	// gibt Array mit Unterschieden zurück
	\nn\t3::Obj()->diff( $objA, $objB );
	
	// ignoriert die Felder uid und title
	\nn\t3::Obj()->diff( $objA, $objB, ['uid', 'title'] );
	
	// Vergleicht NUR die Felder title und bodytext
	\nn\t3::Obj()->diff( $objA, $objB, [], ['title', 'bodytext'] );
	
	// Optionen
	\nn\t3::Obj()->diff( $objA, $objB, [], [], ['ignoreWhitespaces'=>true, 'ignoreTags'=>true, 'ignoreEncoding'=>true] );

| ``@param mixed $objA``                Ein Object, Array oder Model
| ``@param mixed $objB``                Das zu vergleichende Object oder Model
| ``@param array $fieldsToIgnore``      Liste der Properties, die ignoriert werden können. Leer = keine
| ``@param array $fieldsToCompare`` Liste der Properties, die verglichen werden sollen. Leer = alle
| ``@param boolean $options``       Optionen / Toleranzen beim Vergleichen
| ``ignoreWhitespaces`` => Leerzeichen ignorieren
| ``ignoreEncoding``    => UTF8 / ISO-Encoding ignorieren
| ``ignoreTags``        => HTML-Tags ignorieren

| ``@return array``

\\nn\\t3::Obj()->forceArray(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert zu Array

| ``@param mixed $obj``

| ``@return array``

\\nn\\t3::Obj()->get(``$obj, $key = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Zugriff auf einen Wert in dem Object anhand des Keys
Alias zu ``\nn\t3::Obj()->accessSingleProperty()``

.. code-block:: php

	\nn\t3::Obj()->get( $obj, 'title' );
	\nn\t3::Obj()->get( $obj, 'falMedia' );
	\nn\t3::Obj()->get( $obj, 'fal_media' );

| ``@param mixed $obj``             Model oder Array
| ``@param string $key``            der Key / Property

| ``@return mixed``

\\nn\\t3::Obj()->getClassSchema(``$modelClassName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Infos zum classSchema eines Models holen

.. code-block:: php

	\nn\t3::Obj()->getClassSchema( \My\Model\Name::class );
	\nn\t3::Obj()->getClassSchema( $myModel );

return DataMap

\\nn\\t3::Obj()->getKeys(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Zugriff auf ALLE Keys, die in einem Object zu holen sind

.. code-block:: php

	\nn\t3::Obj()->getKeys( $model );                                    // ['uid', 'title', 'text', ...]
	\nn\t3::Obj()->getKeys( $model );                                    // ['uid', 'title', 'text', ...]
	\nn\t3::Obj()->getKeys( \Nng\MyExt\Domain\Model\Demo::class );       // ['uid', 'title', 'text', ...]

| ``@param mixed $obj`` Model, Array oder Klassen-Name
| ``@return array``

\\nn\\t3::Obj()->getMethodArguments(``$className = NULL, $methodName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Infos zu den Argumenten einer Methode holen.
| ``Berücksichtigt auch das per``@param``angegebene Typehinting, z.B. zu``ObjectStorage<ModelName>``.``

.. code-block:: php

	\nn\t3::Obj()->getMethodArguments( \My\Model\Name::class, 'myMethodName' );
	\nn\t3::Obj()->getMethodArguments( $myClassInstance, 'myMethodName' );

Gibt als Beispiel zurück:

.. code-block:: php

	'varName' => [
	    'type' => 'Storage<Model>',
	    'storageType' => 'Storage',
	    'elementType' => 'Model',
	 'optional' => true,
	 'defaultValue' => '123'
	]

return array

\\nn\\t3::Obj()->getProps(``$obj, $key = 'type', $onlySettable = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Liste der Properties eines Objects oder Models mit Typ zurückgeben.

.. code-block:: php

	\nn\t3::Obj()->getProps( $obj );         // ['uid'=>'integer', 'title'=>'string' ...]
	\nn\t3::Obj()->getProps( $obj, true );       // ['uid'=>[type=>'integer', 'private'=>TRUE]]
	\nn\t3::Obj()->getProps( $obj, 'default' );  // ['uid'=>TRUE]
	\nn\t3::Obj()->getProps( \Nng\MyExt\Domain\Model\Demo::class );

| ``@param mixed $obj``                 Model oder Klassen-Name
| ``@param mixed $key``                 Wenn TRUE wird Array mit allen Infos geholt, z.B. auch default-Wert etc.
| ``@param boolean $onlySettable``  Nur properties holen, die auch per setName() gesetzt werden können
| ``@return array``

\\nn\\t3::Obj()->getSetableKeys(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Alle keys eines Objektes holen, die einen SETTER haben.
Im Gegensatz zu ``\nn\t3::Obj()->getKeys()`` werden nur die Property-Keys
zurückgegeben, die sich auch setzen lassen, z.B. über ``setNameDerProp()``

| ``@return array``

\\nn\\t3::Obj()->getTableName(``$modelClassName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt den DB-Tabellen-Namen für ein Model zurück

.. code-block:: php

	$model = new \Nng\MyExt\Domain\Model\Test;
	\nn\t3::Obj()->getTableName( $model );   // 'tx_myext_domain_model_test'
	\nn\t3::Obj()->getTableName( Test::class );  // 'tx_myext_domain_model_test'

| ``@return string``

\\nn\\t3::Obj()->isFalFile(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob es sich bei dem Object um eine ``\TYPO3\CMS\Core\Resource\FileReference`` handelt.

.. code-block:: php

	\nn\t3::Obj()->isFalFile( $obj );

| ``@return boolean``

\\nn\\t3::Obj()->isFile(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob es sich bei dem Object um ein ``\TYPO3\CMS\Core\Resource\File`` handelt.

.. code-block:: php

	\nn\t3::Obj()->isFile( $obj );

| ``@return boolean``

\\nn\\t3::Obj()->isFileReference(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob es sich bei dem Object um eine ``\TYPO3\CMS\Extbase\Domain\Model\FileReference`` handelt.

.. code-block:: php

	\nn\t3::Obj()->isFileReference( $obj );

| ``@return boolean``

\\nn\\t3::Obj()->isModel(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob es sich bei dem Object um ein Domain-Model handelt.

.. code-block:: php

	\nn\t3::Obj()->isModel( $obj );

| ``@return boolean``

\\nn\\t3::Obj()->isSimpleType(``$type = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob es sich bei einem Typ (string) um einen "einfachen" Typ handelt.
Einfache Typen sind alle Typen außer Models, Klassen etc. - also z.B. ``array``, ``string``, ``boolean`` etc.

.. code-block:: php

	$isSimple = \nn\t3::Obj()->isSimpleType( 'string' );                         // true
	$isSimple = \nn\t3::Obj()->isSimpleType( \My\Extname\ClassName::class );     // false

| ``@return boolean``

\\nn\\t3::Obj()->isStorage(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob es sich bei dem Object um eine Storage handelt.

.. code-block:: php

	\nn\t3::Obj()->isStorage( $obj );

| ``@return boolean``

\\nn\\t3::Obj()->isSysCategory(``$obj``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob es sich bei dem Object um eine SysCategory handelt.
Berücksichtigt alle Modelle, die in ``sys_category`` gespeichert werden.

.. code-block:: php

	\nn\t3::Obj()->isSysCategory( $obj );
	
	$cat = new \GeorgRinger\News\Domain\Model\Category();
	\nn\t3::Obj()->isSysCategory( $cat );

| ``@return boolean``

\\nn\\t3::Obj()->merge(``$model = NULL, $overlay = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Merge eines Arrays in ein Object

.. code-block:: php

	\nn\t3::Obj( \My\Doman\Model )->merge(['title'=>'Neuer Titel']);

Damit können sogar FileReferences geschrieben / überschrieben werden.
In diesem Beispiel wird ``$data`` mit einem existierende Model gemerged.
| ``falMedia`` ist im Beispiel eine ObjectStorage. Das erste Element in ``falMedia`` exisitert
bereits in der Datenbank (``uid = 12``). Hier wird nur der Titel aktualisiert.
Das zweite Element im Array (ohne ``uid``) ist neu. Dafür wird automatisch eine neue
| ``sys_file_reference`` in der Datenbank erzeugt.

.. code-block:: php

	$data = [
	    'uid' => 10,
	    'title' => 'Der Titel',
	    'falMedia' => [
	        ['uid'=>12, 'title'=>'1. Bildtitel'],
	        ['title'=>'NEU Bildtitel', 'publicUrl'=>'fileadmin/_tests/5e505e6b6143a.jpg'],
	    ]
	];
	$oldModel = $repository->findByUid( $data['uid'] );
	$mergedModel = \nn\t3::Obj($oldModel)->merge($data);

Hinweis
Um ein neues Model mit Daten aus einem Array zu erzeugen gibt
es die Methode ``$newModel = \nn\t3::Convert($data)->toModel( \My\Model\Name::class );``

| ``@return Object``

\\nn\\t3::Obj()->parseType(``$paramType = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einen String mit Infos zu ``ObjectStorage<Model>`` parsen.

.. code-block:: php

	\nn\t3::Obj()->parseType( 'string' );
	\nn\t3::Obj()->parseType( 'Nng\Nnrestapi\Domain\Model\ApiTest' );
	\nn\t3::Obj()->parseType( '\TYPO3\CMS\Extbase\Persistence\ObjectStorage<Nng\Nnrestapi\Domain\Model\ApiTest>' );

Git ein Array mit Infos zurück:
| ``type`` ist dabei nur gesetzt, falls es ein Array oder eine ObjectStorage ist.
| ``elementType`` ist immer der Typ des Models oder das TypeHinting der Variable

.. code-block:: php

	[
	    'elementType' => 'Nng\Nnrestapi\Domain\Model\ApiTest',
	    'type' => 'TYPO3\CMS\Extbase\Persistence\ObjectStorage',
	    'simple' => FALSE
	]

| ``@return array``

\\nn\\t3::Obj()->prop(``$obj, $key``);
"""""""""""""""""""""""""""""""""""""""""""""""

Zugriff auf einen Key in einem Object oder Array.
Der Key kann auch ein Pfad sein, z.B. "img.0.uid"

\nn\t3::Obj()->prop( $obj, 'img.0.uid' );

| ``@param mixed $obj`` Model oder Array
| ``@param string $key`` der Key, der geholt werden soll

| ``@return mixed``

\\nn\\t3::Obj()->props(``$obj, $keys = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einzelne Properties eines Objects oder Arrays holen

.. code-block:: php

	\nn\t3::Obj()->props( $obj, ['uid', 'pid'] );
	\nn\t3::Obj()->props( $obj, 'uid' );

| ``@return array``

\\nn\\t3::Obj()->set(``$obj, $key = '', $val = '', $useSetter = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Setzt einen Wert in einem Object oder Array.

.. code-block:: php

	\nn\t3::Obj()->set( $obj, 'title', $val );

| ``@param mixed $obj``             Model oder Array
| ``@param string $key``            der Key / Property
| ``@param mixed $val``             der Wert, der gesetzt werden soll
| ``@param boolean $useSetter``     setKey()-Methode zum Setzen verwenden

| ``@return mixed``

\\nn\\t3::Obj()->toArray(``$obj, $depth = 3, $fields = [], $addClass = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert ein Object in ein Array
Bei Memory-Problemen wegen Rekursionen: Max-Tiefe angebenen!

.. code-block:: php

	\nn\t3::Obj()->toArray($obj, 2, ['uid', 'title']);
	\nn\t3::Obj()->toArray($obj, 1, ['uid', 'title', 'parent.uid']);

| ``@param mixed $obj``             ObjectStorage, Model oder Array das Konvertiert werden soll
| ``@param integer $depth``         Tiefe, die konvertiert werden soll. Bei rekursivem Konvertieren unbedingt nutzen
| ``@param array $fields``      nur diese Felder aus dem Object / Array zurückgeben
| ``@param boolean $addClass``  '__class' mit Infos zur Klasse ergänzen?

| ``@return array``

