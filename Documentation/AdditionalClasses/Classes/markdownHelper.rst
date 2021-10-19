
.. include:: ../../Includes.txt

.. _MarkdownHelper:

==============================================
MarkdownHelper
==============================================

\\nn\\t3::MarkdownHelper()
----------------------------------------------

A wrapper to parse markdown and &um;translate it to HTML and vice versa.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::MarkdownHelper()->parseComment(``$comment = '', $encode = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert comment string to readable HTML string.
Comments canöt use Markdown.
Removes '' and '' etc.

.. code-block:: php

	\Nng\Nnhelpers\MarkdownHelper::parseComment( '...' );

| ``@return string``

\\nn\\t3::MarkdownHelper()->removeAsterisks(``$comment = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Removes the comment asterisks in a text.

.. code-block:: php

	\Nng\Nnhelpers\MarkdownHelper::removeAsterisks( '...' );

| ``@return string``

\\nn\\t3::MarkdownHelper()->toHTML(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert a text containing markdown to HTML.

.. code-block:: php

	\Nng\Nnhelpers\MarkdownHelper::toHTML( '...' );

| ``@return string``

