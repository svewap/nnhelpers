
.. include:: ../../Includes.txt

.. _Content:

==============================================
Content
==============================================

\\nn\\t3::Content()
----------------------------------------------

Inhaltselemente und Inhalte einer Backend-Spalten (``colPos``) lesen und rendern

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Content()->addRelations(``$data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lädt Relationen (``media``, ``assets``, ...) zu einem ``tt_content``-Data-Array.
Falls ``EXT:mask`` installiert ist, wird die entsprechende Methode aus mask genutzt.

.. code-block:: php

	\nn\t3::Content()->addRelations( $data );

| ``@return array``

\\nn\\t3::Content()->column(``$colPos, $pageUid = NULL, $slide = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lädt den Content für eine bestimmte Spalte (``colPos``) und Seite.
Wird keine pageUid angegeben, verwendet er die aktuelle Seite.
Mit ``slide`` werden die Inhaltselement der übergeordnete Seite geholt, falls auf der angegeben Seiten kein Inhaltselement in der Spalte existiert.

Inhalt der ``colPos = 110`` von der aktuellen Seite holen:

.. code-block:: php

	\nn\t3::Content()->column( 110 );

Inhalt der ``colPos = 110`` von der aktuellen Seite holen. Falls auf der aktuellen Seite kein Inhalt in der Spalte ist, den Inhalt aus der übergeordneten Seite verwenden:

.. code-block:: php

	\nn\t3::Content()->column( 110, true );

Inhalt der ``colPos = 110`` von der Seite mit id ``99`` holen:

.. code-block:: php

	\nn\t3::Content()->column( 110, 99 );

Inhalt der ``colPos = 110`` von der Seite mit der id ``99`` holen. Falls auf Seite ``99`` kein Inhalt in der Spalte ist, den Inhalt aus der übergeordneten Seite der Seite ``99`` verwenden:

.. code-block:: php

	\nn\t3::Content()->column( 110, 99, true );

Auch als ViewHelper vorhanden:

.. code-block:: php

	{nnt3:content.column(colPos:110)}
	{nnt3:content.column(colPos:110, slide:1)}
	{nnt3:content.column(colPos:110, pid:99)}
	{nnt3:content.column(colPos:110, pid:99, slide:1)}

| ``@return string``

\\nn\\t3::Content()->columnData(``$colPos, $addRelations = false, $pageUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lädt die "rohen" ``tt_content`` Daten einer bestimmten Spalte (``colPos``).

.. code-block:: php

	\nn\t3::Content()->columnData( 110 );
	\nn\t3::Content()->columnData( 110, true );
	\nn\t3::Content()->columnData( 110, true, 99 );

Auch als ViewHelper vorhanden.
| ``relations`` steht im ViewHelper als default auf ``TRUE``

.. code-block:: php

	{nnt3:content.columnData(colPos:110)}
	{nnt3:content.columnData(colPos:110, pid:99, relations:0)}

| ``@return array``

\\nn\\t3::Content()->get(``$ttContentUid = NULL, $getRelations = false, $localize = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lädt die Daten eines tt_content-Element als einfaches Array:

.. code-block:: php

	\nn\t3::Content()->get( 1201 );

Laden von Relationen (``media``, ``assets``, ...)

.. code-block:: php

	\nn\t3::Content()->get( 1201, true );

Übersetzungen / Localization:

Element NICHT automatisch übersetzen, falls eine andere Sprache eingestellt wurde

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, false );

Element in einer ANDEREN Sprache holen, als im Frontend eingestellt wurde.
Berücksichtigt die Fallback-Chain der Sprache, die in der Site-Config eingestellt wurde

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, 2 );

Element mit eigener Fallback-Chain holen. Ignoriert dabei vollständig die Chain,
die in der Site-Config definiert wurde.

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, [2,3,0] );

| ``@param int $ttContentUid``      Content-Uid in der Tabelle tt_content
| ``@param bool $getRelations`` Auch Relationen / FAL holen?
| ``@param bool $localize``     Übersetzen des Eintrages?
| ``@return array``

\\nn\\t3::Content()->getAll(``$constraints = [], $getRelations = false, $localize = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Mehrere Content-Elemente (aus ``tt_content``) holen.

Die Datensätze werden automatisch lokalisiert – außer ``$localize`` wird auf ``false``
gesetzt. Siehe ``\nn\t3::Content()->get()`` für weitere ``$localize`` Optionen.

Anhand einer Liste von UIDs:

.. code-block:: php

	\nn\t3::Content()->getAll( 1 );
	\nn\t3::Content()->getAll( [1, 2, 7] );

Anhand von Filter-Kriterien:

.. code-block:: php

	\nn\t3::Content()->getAll( ['pid'=>1] );
	\nn\t3::Content()->getAll( ['pid'=>1, 'colPos'=>1] );
	\nn\t3::Content()->getAll( ['pid'=>1, 'CType'=>'mask_section_cards', 'colPos'=>1] );

| ``@param mixed $ttContentUid``    Content-Uids oder Constraints für Abfrage der Daten
| ``@param bool $getRelations`` Auch Relationen / FAL holen?
| ``@param bool $localize``     Übersetzen des Eintrages?
| ``@return array``

\\nn\\t3::Content()->localize(``$table = 'tt_content', $data = [], $localize = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Daten lokalisieren / übersetzen.

Beispiele:

Daten übersetzen, dabei die aktuelle Sprache des Frontends verwenden.

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data );

Daten in einer ANDEREN Sprache holen, als im Frontend eingestellt wurde.
Berücksichtigt die Fallback-Chain der Sprache, die in der Site-Config eingestellt wurde

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data, 2 );

Daten mit eigener Fallback-Chain holen. Ignoriert dabei vollständig die Chain,
die in der Site-Config definiert wurde.

.. code-block:: php

	\nn\t3::Content()->localize( 'tt_content', $data, [3, 2, 0] );

| ``@param string $table``  Datenbank-Tabelle
| ``@param array $data``        Array mit den Daten der Standard-Sprache (languageUid = 0)
| ``@param mixed $localize``    Angabe, wie übersetzt werden soll. Boolean, uid oder Array mit uids
| ``@return array``

\\nn\\t3::Content()->render(``$ttContentUid = NULL, $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Rendert ein ``tt_content``-Element als HTML

.. code-block:: php

	\nn\t3::Content()->render( 1201 );
	\nn\t3::Content()->render( 1201, ['key'=>'value'] );

Auch als ViewHelper vorhanden:

.. code-block:: php

	{nnt3:contentElement(uid:123, data:feUser.data)}

| ``@return string``

