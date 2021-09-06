<?php
namespace Nng\Nnhelpers\ViewHelpers\Uri;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * Erzeugt ein URL zu einer Seite im Frontend.
 * Entspricht fast exakt dem Typo3 ViewHelper `{f:uri.page()}` - kann allerdings auch in einem Kontext
 * verwendet werden, bei dem kein Frontend (`TSFE`) existiert, z.B. im Template eines Backend-Moduls oder in 
 * Mail-Templates eines Scheduler-Jobs.
 * ```
 * {nnt3:uri.page(pageUid:1, additionalParams:'...')}
 * ```
 */
class PageViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Uri\PageViewHelper {
	
	public function initializeArguments() {
		parent::initializeArguments();
   }

	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext ) {

		$args = ['pageUid', 'additionalParams', 'pageType', 'absolute'];
	   
		foreach ($args as $arg) {
			$$arg = $arguments[$arg] ?? '';
		}

		if (!$additionalParams) {
			$additionalParams = [];
		}
		if ($pageType) {
			$additionalParams['type'] = $pageType;
		}
		return \nn\t3::Page()->getLink( $pageUid, $additionalParams, $absolute );
	}
	
}