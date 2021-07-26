<?php
namespace Nng\Nnhelpers\ViewHelpers\Link;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\ViewHelpers\Link\TypolinkViewHelper;

/**
 * Link zum Editieren eines Datensatzes in einem Backend-Modul generieren.
 * ```
 * <nnt3:link.editRecord uid="{item.uid}" data="{ajax:1}" table="tx_myext_domain_model_entry" returnUrl="...">
 * 	<i class="fas fa-eye"></i>
 * </nnt3:link.editRecord>
 * ```
 * Alternativ kann auch der Core-ViewHelper genutzt werden:
 * ```
 * {namespace be=TYPO3\CMS\Backend\ViewHelpers}
 * <be:link.editRecord uid="42" table="a_table" returnUrl="foo/bar" />
 * ```
 */
class EditRecordViewHelper extends TypolinkViewHelper {
	
	public function initializeArguments() {
		parent::initializeArguments();
		$this->overrideArgument('parameter', 'string', 'Parameter für Typolink', false);
		$this->registerArgument('table', 'string', 'DB Tabellen-Name', true);
		$this->registerArgument('returnUrl', 'string', 'Nach Schließen des Editors: Zu welcher URL zurückkehren?', false);
		$this->registerArgument('uid', 'string', 'UID in Tabelle', true);
   }

	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext ) {
		$args = ['table', 'uid', 'returnUrl'];
	   
		foreach ($args as $arg) {
			$$arg = $arguments[$arg] ?? '';
		}

		if (!$returnUrl) {
			$returnUrl = \nn\t3::Request()->getUri();
		}

		$uriBuilder = \nn\t3::injectClass( \TYPO3\CMS\Backend\Routing\UriBuilder::class );

		$uri = $uriBuilder->buildUriFromRoute( 'record_edit', [
			'returnUrl'	=> $returnUrl,
			'edit' 		=> [$table=>[$uid=>'edit']]
		]);
		
		$arguments['parameter'] = $uri;
		return parent::renderStatic( $arguments, $renderChildrenClosure, $renderingContext );
	}
	
}