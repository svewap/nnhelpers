
.. include:: ../../Includes.txt

.. _DocumentationHelper:

==============================================
DocumentationHelper
==============================================

\\nn\\t3::DocumentationHelper()
----------------------------------------------

Various methods for parsing PHP source code and comments in the
Source Code (Annotations). Objective: to create automated documentation from the comments
in the PHP code.

Examples of usage including rendering of the template

In the controller with rendering by fluid:

.. code-block:: php

	$path = \nn\t3::Environment()->extPath('myext') . 'Classes/Utilities/';
	$doc = \Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( $path );
	$this->view->assign('doc', $doc);

Generating the Typo3 / Sphinx ReST doc üvia a custom fluid template:

.. code-block:: php

	$path = \nn\t3::Environment()->extPath('myext') . 'Classes/Utilities/';
	$doc = \Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( $path );
	
	foreach ($doc as $className=>$infos) {
	  $rendering = $nn\t3::Template()->render(
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

Get class name as string including full namespace from a PHP file.
Returns e.g. ``Nng\Classes\MyClass``.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::getClassNameFromFile( 'Classes/MyClass.php' );

| ``@return string``

\\nn\\t3::DocumentationHelper()->getSourceCode(``$class, $method``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the source code of a method.

Returns the "raw" PHP code of the method of a class.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseClass( \Nng\Classes\MyClass::class, 'myMethodName' );

| ``@return string``

\\nn\\t3::DocumentationHelper()->parseClass(``$className = '', $returnMethods = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get info about a specific class.

Ähnelt ``parseFile()`` - but here you have to pass the actual class name übergeben.
If you only know the path to the PHP file, use ``parseFile()``.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseClass( \Nng\Classes\MyClass::class );

| ``@return array``

\\nn\\t3::DocumentationHelper()->parseFile(``$path = '', $returnMethods = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get all info about a single PHP file.

Parses the comment (annotation) üover the class definition and optionally all methods of the class.
Returns an array where the arguments/parameters of each method are also listed.

Markdown can be used in the annotations, the markdown is automatically converted to HTML code.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseFile( 'Path/Classes/MyClass.php' );

| ``@return array``

\\nn\\t3::DocumentationHelper()->parseFolder(``$path = '', $options = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Parse a folder (recursively) for classes with annotations.
Returns an array with information about each class and its methods.

The annotations (comments) üover the class methods can be formatted in Markdown, they are automatically converted to HTML with appropriate ``<pre>`` and ``<code>`` tags.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\DocumentationHelper::parseFolder( 'Path/To/Classes/' );
	\Nng\Nnhelpers\DocumentationHelper::parseFolder( 'EXT:myext/Classes/ViewHelpers/' );
	\Nng\Nnhelpers\DocumentationHelper::parseFolder( 'Path/Somewhere/', ['recursive'=>false, 'suffix'=>'php', 'parseMethods'=>false] );

| ``@return array``

