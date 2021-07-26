
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\AbstractViewHelper:

=======================================
abstract
=======================================

Description
---------------------------------------

<nnt3:abstract />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This ViewHelper is not a custom ViewHelper usable in Fluid.

It serves as a base class for your own ViewHelper.

| ``$escapeOutput = false`` is set as default.
If XSS attacks could be a problem with your ViewHelper, this should be üoverridden.

Use ``extend`` in your own ViewHelper to use it.
Here's a sample boilerplate, with everything you need to get started:

.. code-block:: php

	<?php
	namespace My\ExtViewHelpers;
	
	use Nng\Nnhelpers\ViewHelpers\AbstractViewHelper;
	use TYPO3Fluid\Core\Rendering\RenderingContextInterface;
	
	class ExampleViewHelper extends AbstractTagBasedViewHelper {
	
	 public function initializeArguments() {
	     parent::initializeArguments();
	     $this->registerArgument('title', 'string', 'info', false);
	 }
	
	 public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext ) {
	
	     // Just use `$title` instead of `$arguments['title']`.
	     foreach ($arguments as $k=>$v) {
	        ${$k} = $v;
	     }
	
	     // Render content between the ViewHelper tag
	     if (!$title) $title = $renderChildrenClosure();
	
	     // Example to get all actual variables in the fluid template
	     // $templateVars = \nn\t3::Template()->getVariables( $renderingContext );
	
	     return $title;
	 }
	}

