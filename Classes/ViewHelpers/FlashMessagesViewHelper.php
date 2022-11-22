<?php
namespace Nng\Nnhelpers\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Gibt eine Flash-Message aus.
 * 
 * Im Controller:
 * ```
 * \nn\t3::Message()->OK('Titel', 'Infotext');
 * \nn\t3::Message()->setId('oben')->ERROR('Titel', 'Infotext');
 * ```
 * Im Fluid:
 * ```
 * <nnt3:flashMessages />
 * <nnt3:flashMessages id='oben' />
 * ```
 * Die Core-Funktionen:
 * ```
 * <f:flashMessages queueIdentifier='core.template.flashMessages' />
 * <f:flashMessages queueIdentifier='oben' />
 * ```
 * @return string
 */
class FlashMessagesViewHelper extends AbstractViewHelper {

	use CompileWithRenderStatic;

	protected $escapeOutput = false;

	public function initializeArguments() {
		parent::initializeArguments();	
		$this->registerArgument('id', 'string', 'queueIdentifier der Messages', false, 'core.template.flashMessages');
    }

	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext ) {
		return 'Needs to be fixed for TYPO3 v12';
		$arguments['queueIdentifier'] = $arguments['id'];
		$html = parent::renderStatic( $arguments, $renderChildrenClosure, $renderingContext );
		return html_entity_decode( $html );
	}
    
}
