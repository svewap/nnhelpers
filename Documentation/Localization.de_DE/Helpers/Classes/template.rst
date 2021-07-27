
.. include:: ../../Includes.txt

.. _Template:

==============================================
Template
==============================================

\\nn\\t3::Template()
----------------------------------------------

Fluid Templates rendern und Pfade zu Templates im View manipulieren.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Template()->findTemplate(``$view = NULL, $templateName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Findet ein Template in einem Array von möglichen templatePaths des Views

.. code-block:: php

	\nn\t3::Template()->findTemplate( $this->view, 'example.html' );

| ``@return string``

\\nn\\t3::Template()->getVariables(``$view``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt die Variables des aktuellen Views, sprich:
Alles, was per assign() und assignMultiple() gesetzt wurde.

Im ViewHelper:

.. code-block:: php

	\nn\t3::Template()->getVariables( $renderingContext );

Im Controller:

.. code-block:: php

	\nn\t3::Template()->getVariables( $this->view );

| ``@return array``

\\nn\\t3::Template()->mergeTemplatePaths(``$defaultTemplatePaths = [], $additionalTemplatePaths = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Pfade zu Templates, Partials, Layout mergen

.. code-block:: php

	\nn\t3::Template()->mergeTemplatePaths( $defaultTemplatePaths, $additionalTemplatePaths );

| ``@return array``

\\nn\\t3::Template()->removeControllerPath(``$view``);
"""""""""""""""""""""""""""""""""""""""""""""""

Entfernt den Pfad des Controller-Names z.B. /Main/...
aus der Suche nach Templates.

.. code-block:: php

	\nn\t3::Template()->removeControllerPath( $this->view );

| ``@return void``

\\nn\\t3::Template()->render(``$templateName = NULL, $vars = [], $templatePaths = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein Fluid-Templates rendern per StandAlone-Renderer

.. code-block:: php

	\nn\t3::Template()->render( 'Templatename', $vars, $templatePaths );
	\nn\t3::Template()->render( 'Templatename', $vars, 'myext' );
	\nn\t3::Template()->render( 'Templatename', $vars, 'tx_myext_myplugin' );
	\nn\t3::Template()->render( 'fileadmin/Fluid/Demo.html', $vars );

| ``@return string``

\\nn\\t3::Template()->renderHtml(``$html = NULL, $vars = [], $templatePaths = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

einfachen Fluid-Code rendern per StandAlone-Renderer

.. code-block:: php

	    \nn\t3::Template()->renderHtml( '{_all->f:debug()} Test: {test}', $vars );
	    \nn\t3::Template()->renderHtml( ['Name: {name}', 'Test: {test}'], $vars );
	    \nn\t3::Template()->renderHtml( ['name'=>'{firstname} {lastname}', 'test'=>'{test}'], $vars );

| ``@return string``

\\nn\\t3::Template()->setTemplatePaths(``$view = NULL, $defaultTemplatePaths = [], $additionalTemplatePaths = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Setzt Templates, Partials und Layouts für einen View.
$additionalTemplatePaths kann übergeben werden, um Pfade zu priorisieren

.. code-block:: php

	\nn\t3::Template()->setTemplatePaths( $this->view, $templatePaths );

| ``@return array``

