<?php

namespace  Nng\Nnhelpers\ViewHelpers\Content;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Rendert die Inhalte einer Spalte (colPos) des Backend Layouts
 * ```
 * {nnt3:content.column(colPos:110)}
 * {nnt3:content.column(colPos:110, pid:99)}
 * ```
 */
class ColumnViewHelper extends AbstractViewHelper {

	use CompileWithRenderStatic;

	protected $escapeOutput = false;

	public function initializeArguments() {
	   $this->registerArgument('pid', 'intval', 'PageUid von der die Spalte gerendert werden soll');
	   $this->registerArgument('colPos', 'intval', 'Spalten-Nr (colPos) des Backend-Layouts, die gerendert werden soll.');
   }

	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext ) {
		return \nn\t3::Content()->column($arguments['colPos'], $arguments['pid']);
	}

}