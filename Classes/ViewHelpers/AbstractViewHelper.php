<?php
namespace Nng\Nnhelpers\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper as AbstractTypo3ViewHelper;

class AbstractViewHelper extends AbstractTypo3ViewHelper {

	use CompileWithRenderStatic;

	protected $escapeOutput = false;

	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext ) {
		 // usw
	}
    
}
