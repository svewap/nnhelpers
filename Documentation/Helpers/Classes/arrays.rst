
.. include:: ../../Includes.txt

.. _Arrays:

==============================================
Arrays
==============================================

\\nn\\t3::Arrays()
----------------------------------------------

Diverse Methoden, um mit Arrays zu arbeiten wie mergen, bereinigen oder leere Werte zu entfernen.
Methoden, um ein Value eines assoziativen Arrays als Key zu verwenden.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Arrays()->first();
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt das erste Element des Arrays zurück, ohne array_shift()

.. code-block:: php

	\nn\t3::Arrays( $objArr )->first();

| ``@return array``

\\nn\\t3::Arrays()->intExplode(``$delimiter = ','``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einen String – oder Array – am Trennzeichen splitten, nicht numerische
und leere Elemente entfernen

.. code-block:: php

	\nn\t3::Arrays('1,a,b,2,3')->intExplode();       // [1,2,3]
	\nn\t3::Arrays(['1','a','2','3'])->intExplode(); // [1,2,3]

| ``@return array``

\\nn\\t3::Arrays()->key(``$key = 'uid', $value = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Als Key des Arrays ein Feld im Array verwenden, z.B. um eine Liste zu bekommen,
deren Key immer die UID des assoziativen Arrays ist:

Beispiel:

.. code-block:: php

	$arr = [['uid'=>'1', 'title'=>'Titel A'], ['uid'=>'2', 'title'=>'Titel B']];
	\nn\t3::Arrays($arr)->key('uid');            // ['1'=>['uid'=>'1', 'title'=>'Titel A'], '2'=>['uid'=>'2', 'title'=>'Titel B']]
	\nn\t3::Arrays($arr)->key('uid', 'title');   // ['1'=>'Titel A', '2'=>'Titel B']

| ``@return array``

\\nn\\t3::Arrays()->merge();
"""""""""""""""""""""""""""""""""""""""""""""""

Ein assoziatives Array rekursiv mit einem anderen Array mergen.

| ``$addKeys`` => wenn ``false`` werden nur Keys überschrieben, die auch in ``$arr1`` existieren
| ``$includeEmptyValues`` => wenn ``true`` werden auch leere Values in ``$arr1`` übernommen
| ``$enableUnsetFeature`` => wenn ``true``, kann ``__UNSET`` als Wert in ``$arr2`` verwendet werden, um eine Wert in ``$arr1`` zu löschen

.. code-block:: php

	$mergedArray = \nn\t3::Arrays( $arr1 )->merge( $arr2, $addKeys, $includeEmptyValues, $enableUnsetFeature );
	$mergedArray = \nn\t3::Arrays( $arr1 )->merge( $arr2 );
	$mergedArray = \nn\t3::Arrays()->merge( $arr1, $arr2 );

| ``@return array``

\\nn\\t3::Arrays()->pluck(``$keys = NULL, $isSingleObject = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Assoziatives Array auf bestimmte Elemente reduzieren / destillieren:

.. code-block:: php

	\nn\t3::Arrays( $objArr )->key('uid')->pluck('title');                    // ['1'=>'Titel A', '2'=>'Titel B']
	\nn\t3::Arrays( $objArr )->key('uid')->pluck(['title', 'bodytext']);  // ['1'=>['title'=>'Titel A', 'bodytext'=>'Inhalt'], '2'=>...]
	\nn\t3::Arrays( ['uid'=>1, 'pid'=>2] )->pluck(['uid'], true);          // ['uid'=>1]

| ``@return array``

\\nn\\t3::Arrays()->removeEmpty();
"""""""""""""""""""""""""""""""""""""""""""""""

Leere Werte aus einem Array entfernen.

.. code-block:: php

	$clean = \nn\t3::Arrays( $arr1 )->removeEmpty();

| ``@return array``

\\nn\\t3::Arrays()->toArray();
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt dieses Array-Object als "normales" Array zurück.

.. code-block:: php

	\nn\t3::Arrays( $objArr )->key('uid')->toArray();

| ``@return array``

\\nn\\t3::Arrays()->trimExplode(``$delimiter = ',', $removeEmpty = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einen String – oder Array – am Trennzeichen splitten, leere Elemente entfernen
Funktioniert mit Strings und Arrays.

.. code-block:: php

	\nn\t3::Arrays('1,,2,3')->trimExplode();         // [1,2,3]
	\nn\t3::Arrays('1,,2,3')->trimExplode( false );      // [1,'',2,3]
	\nn\t3::Arrays('1|2|3')->trimExplode('|');           // [1,2,3]
	\nn\t3::Arrays('1|2||3')->trimExplode('|', false);   // [1,2,'',3]
	\nn\t3::Arrays('1|2,3')->trimExplode(['|', ',']);    // [1,2,3]
	\nn\t3::Arrays(['1','','2','3'])->trimExplode(); // [1,2,3]

| ``@return array``

