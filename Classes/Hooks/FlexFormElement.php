<?php

namespace Nng\Nnhelpers\Hooks;

use TYPO3\CMS\Backend\Form\AbstractNode;

class FlexFormElement extends AbstractNode {

	public function render( $data = [] ) {
			return ['html'=>'\Nng\Nnhelpers\Hooks\FlexFormElement->render()'];
	}

}