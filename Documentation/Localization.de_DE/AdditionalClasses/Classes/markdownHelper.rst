
.. include:: ../../Includes.txt

.. _MarkdownHelper:

==============================================
MarkdownHelper
==============================================

\\nn\\t3::MarkdownHelper()
----------------------------------------------

Ein Wrapper zum Parsen von markdown und Übersetzung in HTML und umgekehrt.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::MarkdownHelper()->parseComment(``$comment = '', $encode = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Kommentar-String zu lesbarem HTML-String konvertieren
Kommentare können Markdown verwenden.
Entfernt '' und '' etc.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\MarkdownHelper::parseComment( '...' );

| ``@return string``

\\nn\\t3::MarkdownHelper()->removeAsterisks(``$comment = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Entfernt die Kommentar-Sternchen in einem Text.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\MarkdownHelper::removeAsterisks( '...' );

| ``@return string``

\\nn\\t3::MarkdownHelper()->toHTML(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einen Text, der markdown enthält in HTML umwandeln.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\MarkdownHelper::toHTML( '...' );

| ``@return string``

