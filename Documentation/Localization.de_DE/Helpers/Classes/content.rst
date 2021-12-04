
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

\\nn\\t3::Content()->get(``$ttContentUid = NULL, $getRelations = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lädt ein tt_content-Element als Array

.. code-block:: php

	\nn\t3::Content()->get( 1201 );

Laden von Relationen (``media``, ``assets``, ...)

.. code-block:: php

	\nn\t3::Content()->get( 1201, true );

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

