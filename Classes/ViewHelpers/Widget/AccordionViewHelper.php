<?php

namespace Nng\Nnhelpers\ViewHelpers\Widget;

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * <nnt3:widget.accordion title="Titel">
 *   ...
 * </nnt3:widget.accordion>
 *
 */
class AccordionViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{

    /**
     * @var \Nng\Nnhelpers\ViewHelpers\Widget\Controller\AccordionController
     */
    protected $controller;

    /**
     * Inject controller
     *
     * @param \Nng\Nnhelpers\ViewHelpers\Widget\Controller\AccordionController $controller
     */
    public function injectController(\Nng\Nnhelpers\ViewHelpers\Widget\Controller\AccordionController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('title', 'string', 'Titel des Akkordeons');
        $this->registerArgument('icon', 'string', 'Icon-Klasse');
        $this->registerArgument('class', 'string', 'Accordeon-Klasse');
    }

    /**
     * Render everything
     *
     * @param string $title
     * @return string
     */
    public function render()
    {
        return $this->initiateSubRequest();
    }
}