<?php

namespace Nng\Nnhelpers\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class AttrEncodeViewHelper extends AbstractViewHelper {

	use CompileWithRenderStatic;

	protected $escapeOutput = false;

	public function initializeArguments() {
		$this->registerArgument('str', 'mixed', 'Text', false);
	}

	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext ) {
		$str = $arguments['str'] ?: $renderChildrenClosure();
		if (is_array($str)) $str = json_encode($str);
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
	}
}