
.. include:: ../../Includes.txt

.. _DocumentationHelper:

==============================================
DocumentationHelper
==============================================

\\nn\\t3::DocumentationHelper()
----------------------------------------------

Diverse Methoden zum Parsen von PHP-Quelltexten und Kommentaren im
Quelltext (Annotations). Zielsetzung: Automatisierte Dokumentation aus den Kommentaren
im PHP-Code erstellen.

Beispiele für die Verwendung inkl. Rendering des Templates

Im Controller mit Rendering per Fluid:

.. code-block:: php

	$path = \nn\t3::Environment()->extPath('myext') . 'Classes/Utilities/';
	$doc = \Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( $path );
	$this->view->assign('doc', $doc);

Generieren der Typo3 / Sphinx ReST-Doku über ein eigenen Fluid-Template:

.. code-block:: php

	$path = \nn\t3::Environment()->extPath('myext') . 'Classes/Utilities/';
	$doc = \Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( $path );
	
	foreach ($doc as $className=>$infos) {
	  $rendering = \nn\t3::Template()->render(
	    'EXT:myext/Resources/Private/Backend/Templates/Documentation/ClassTemplate.html', [
	      'infos' => $infos
	    ]
	  );
	
	  $filename = $infos['fileName'] . '.rst';
	  $file = \nn\t3::File()->absPath('EXT:myext/Documentation/Utilities/Classes/' . $filename);
	  $result = file_put_contents( $file, $rendering );
	}

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::DocumentationHelper()->getClassNameFromFile(``$file``);
"""""""""""""""""""""""""""""""""""""""""""""""

Klassen-Name als String inkl. vollem Namespace aus einer PHP-Datei holen.
Gibt z.B. ``Nng\Classes\MyClass`` zurück.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::getClassNameFromFile( 'Classes/MyClass.php' );

| ``@return string``

\\nn\\t3::DocumentationHelper()->getSourceCode(``$class, $method``);
"""""""""""""""""""""""""""""""""""""""""""""""

Quelltext einer Methode holen.

Gibt den "rohen" PHP-Code der Methode einer Klasse zurück.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseClass( \Nng\Classes\MyClass::class, 'myMethodName' );

| ``@return string``

\\nn\\t3::DocumentationHelper()->parseClass(``$className = '', $returnMethods = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Infos zu einer bestimmten Klasse holen.

Ähnelt ``parseFile()`` - allerdings muss hier der eigentliche Klassen-Name übergeben werden.
Wenn man nur den Pfad zur PHP-Datei kennt, nutzt man ``parseFile()``.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseClass( \Nng\Classes\MyClass::class );

| ``@return array``

\\nn\\t3::DocumentationHelper()->parseFile(``$path = '', $returnMethods = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Alle Infos zu einer einzelnen PHP-Datei holen.

Parsed den Kommentar (Annotation) über der Klassen-Definition und optional auch alle Methoden der Klasse.
Gibt ein Array zurück, bei der auch die Argumente / Parameter jeder Methode aufgeführt werden.

Markdown kann in den Annotations verwendet werden, das Markdown wird automatisch in HTML-Code umgewandelt.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseFile( 'Path/Classes/MyClass.php' );

| ``@return array``

\\nn\\t3::DocumentationHelper()->parseFolder(``$path = '', $options = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einen Ordner (rekursiv) nach Klassen mit Annotations parsen.
Gibt ein Array mit Informationen zu jeder Klasse und seinen Methoden zurück.

Die Annotations (Kommentare) über den Klassen-Methoden können in Markdown formatiert werden, sie werden automatisch in HTML mit passenden ``<pre>`` und ``<code>`` Tags umgewandelt.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( 'Path/To/Classes/' );
	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( 'EXT:myext/Classes/ViewHelpers/' );
	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( 'Path/Somewhere/', ['recursive'=>false, 'suffix'=>'php', 'parseMethods'=>false] );

| ``@return array``

