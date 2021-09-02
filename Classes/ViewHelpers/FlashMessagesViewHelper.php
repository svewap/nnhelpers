<?php
namespace Nng\Nnhelpers\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

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
class FlashMessagesViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\FlashMessagesViewHelper {

	use CompileWithRenderStatic;

	protected $escapeOutput = false;

	public function initializeArguments() {
		parent::initializeArguments();	
		$this->registerArgument('id', 'string', 'queueIdentifier der Messages', false, 'core.template.flashMessages');
    }

	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext ) {
		$arguments['queueIdentifier'] = $arguments['id'];
		$html = parent::renderStatic( $arguments, $renderChildrenClosure, $renderingContext );
		return html_entity_decode( $html );
	}
    
}
