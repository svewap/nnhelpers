<?php

namespace Nng\Nnhelpers\Controller;

use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

abstract class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * Backend Template Container
	 * @var string
	 */
	protected $defaultViewObjectName = \TYPO3\CMS\Backend\View\BackendTemplateView::class;

	/** 
	 * 	Cache des Source-Codes für die Doku
	 * 	@var array
	 */
	protected $sourceCodeCache = [];
	protected $maxTranslationsPerLoad = 10;

	/**
	 * 	Initialize View
	 */
	public function initializeView ( ViewInterface $view ) {
		parent::initializeView($view);

		if (!$view->getModuleTemplate()) return;
		
		$pageRenderer = $view->getModuleTemplate()->getPageRenderer();
		
		$pageRenderer->loadRequireJsModule('TYPO3/CMS/Nnhelpers/NnhelpersPinModule');
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Nnhelpers/NnhelpersBackendModule');

		$pageRenderer->addCssFile('typo3conf/ext/nnhelpers/Resources/Public/Vendor/prism/prism.css');
		$pageRenderer->addJsFile('typo3conf/ext/nnhelpers/Resources/Public/Vendor/prism/prism.js');
		$pageRenderer->addJsFile('typo3conf/ext/nnhelpers/Resources/Public/Vendor/prism/prism.download.js');

		if (\nn\t3::t3Version() >= 8) {
			$template = $view->getModuleTemplate();
			$template->setFlashMessageQueue($this->controllerContext->getFlashMessageQueue());
			$template->getDocHeaderComponent()->disable();
		}
	}

}
