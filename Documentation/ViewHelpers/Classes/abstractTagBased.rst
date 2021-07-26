
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\AbstractTagBasedViewHelper:

=======================================
abstractTagBased
=======================================

Description
---------------------------------------

<nnt3:abstractTagBased />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This ViewHelper is not a custom ViewHelper that is usable in Fluid.
It serves as a base class for your own tag-based ViewHelper.

Use ``extend`` in your own ViewHelper to use it.
Here's a sample boilerplate, with everything you need to get started:

.. code-block:: php

	<?php
	namespace My\ExtViewHelpers;
	
	use \Nng\Nnhelpers\ViewHelpers\AbstractTagBasedViewHelper;
	
	class ExampleViewHelper extends AbstractTagBasedViewHelper {
	
	 protected $tagName = 'div';
	
	 public function initializeArguments() {
	     parent::initializeArguments();
	     $this->registerArgument('title', 'string', 'info', false);
	 }
	 public function render() {
	     $args = ['item'];
	     foreach ($args as $arg) ${$arg} = $this->arguments[$arg] ?: '';
	     $content = $this->renderChildren();
	     $this->tag->setContent($content);
	     return $this->tag->render();
	 }
	}

