
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\AbstractTagBasedViewHelper:

=======================================
abstractTagBased
=======================================

Description
---------------------------------------

<nnt3:abstractTagBased />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Dieser ViewHelper ist keine eigener ViewHelper, der in Fluid nutzbar ist.
Er dient als Basis-Klasse für Deine eigenen, Tag-basierten ViewHelper.

Nutze ``extend`` in Deinem eigenen ViewHelper, um ihn zu verwenden.
Hier ein Beispiel-Boilerplate, mit allem, was Du zum Loslegen brauchst:

.. code-block:: php

	<?php
	namespace My\Ext\ViewHelpers;
	
	use \Nng\Nnhelpers\ViewHelpers\AbstractTagBasedViewHelper;
	
	class ExampleViewHelper extends AbstractTagBasedViewHelper {
	
	 protected $tagName = 'div';
	
	 public function initializeArguments() {
	     parent::initializeArguments();
	     $this->registerArgument('title', 'string', 'Infos', false);
	 }
	 public function render() {
	     $args = ['item'];
	     foreach ($args as $arg) ${$arg} = $this->arguments[$arg] ?: '';
	     $content = $this->renderChildren();
	     $this->tag->setContent($content);
	     return $this->tag->render();
	 }
	}

