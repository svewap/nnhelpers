<?php
namespace Nng\Nnhelpers\ViewHelpers\Encrypt;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class HashViewHelper extends AbstractViewHelper {

	use CompileWithRenderStatic;

	protected $escapeOutput = false;

	public function initializeArguments() {
	   $this->registerArgument('value', 'string', 'Value to be hashed', false);
   }

	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext ) {
		$value = $arguments['value'] ?: $renderChildrenClosure();
		return \nn\t3::Encrypt()->hash( $value );
	}
    
}
