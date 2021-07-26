
.. include:: ../../Includes.txt

.. _Template:

==============================================
Template
==============================================

\\nn\\t3::Template()
----------------------------------------------

Render fluid templates and manipulate paths to templates in the view.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Template()->findTemplate(``$view = NULL, $templateName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds a template in an array of möpossible templatePaths of the view

.. code-block:: php

	\nn\t3::Template()->findTemplate( $this->view, 'example.html' );

| ``@return string``

\\nn\\t3::Template()->getVariables(``$view``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets the variables of the current view, ie:
Everything set via assign() and assignMultiple().

In the ViewHelper:

.. code-block:: php

	\nn\t3::Template()->getVariables( $renderingContext );

In the controller:

.. code-block:: php

	\nn\t3::Template()->getVariables( $this->view );

| ``@return array``

\\nn\\t3::Template()->mergeTemplatePaths(``$defaultTemplatePaths = [], $additionalTemplatePaths = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Merge paths to templates, partials, layout

.. code-block:: php

	\nn\t3::Template()->mergeTemplatePaths( $defaultTemplatePaths, $additionalTemplatePaths );

| ``@return array``

\\nn\\t3::Template()->removeControllerPath(``$view``);
"""""""""""""""""""""""""""""""""""""""""""""""

Removes the controller name path e.g. /Main/....
from the template search.

.. code-block:: php

	\nn\t3::Template()->removeControllerPath( $this->view );

| ``@return void``

\\nn\\t3::Template()->render(``$templateName = NULL, $vars = [], $templatePaths = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Rendering a Fluid Template via StandAlone Renderer

.. code-block:: php

	\nn\t3::Template()->render( 'template name', $vars, $templatePaths );
	\nn\t3::Template()->render( 'templateName', $vars, 'myext' );
	\nn\t3::Template()->render( 'templateName', $vars, 'tx_myext_myplugin' );
	\nn\t3::Template()->render( 'fileadmin/Fluid/Demo.html', $vars );

| ``@return string``

\\nn\\t3::Template()->renderHtml(``$html = NULL, $vars = [], $templatePaths = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

simply render fluid code via StandAlone renderer

.. code-block:: php

	 \nn\t3::Template()->renderHtml( '{_all->f:debug()} Test: {test}', $vars );
	    \nn\t3::Template()->renderHtml( ['Name: {name}', 'Test: {test}'], $vars );
	    \nn\t3::Template()->renderHtml( ['name'=>'{firstname} {lastname}', 'test'=>'{test}'], $vars );

| ``@return string``

\\nn\\t3::Template()->setTemplatePaths(``$view = NULL, $defaultTemplatePaths = [], $additionalTemplatePaths = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sets templates, partials, and layouts for a view.
$additionalTemplatePaths can be üpassed to prioritize paths

.. code-block:: php

	\nn\t3::Template()->setTemplatePaths( $this->view, $templatePaths );

| ``@return array``

