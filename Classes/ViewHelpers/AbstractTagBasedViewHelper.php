<?php
namespace Nng\Nnhelpers\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper as AbstractTypo3TagBasedViewHelper;

class AbstractTagBasedViewHelper extends AbstractTypo3TagBasedViewHelper {

	protected $tagName = 'a';

	public function initializeArguments() {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
    }

	public function render() {
		 // usw
		 $this->tag->addAttribute(
            'href',
            'https://www.99grad.de'
        );
        return $this->tag->render();
	}
    
}