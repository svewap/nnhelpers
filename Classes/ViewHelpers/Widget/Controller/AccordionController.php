<?php

namespace Nng\Nnhelpers\ViewHelpers\Widget\Controller;

use TYPO3\CMS\Core\Utility\ArrayUtility;

class AccordionController extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController
{

	/**
	 * @var array
	 */
	protected $configuration = [
	];

	/**
	 * Main action
	 *
	 */
	public function indexAction() {
		$this->view->assignMultiple([
			'configuration' => $this->widgetConfiguration,
			'title' 		=> $this->widgetConfiguration['title'],
			'icon' 			=> $this->widgetConfiguration['icon'],
			'class' 		=> $this->widgetConfiguration['class'],
			'uniqid'		=> uniqid('acc-'),
		]);
	}

}