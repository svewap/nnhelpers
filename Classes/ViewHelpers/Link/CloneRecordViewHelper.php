<?php
namespace Nng\Nnhelpers\ViewHelpers\Link;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\ViewHelpers\Link\TypolinkViewHelper;

/**
 * Link zum Klonen eines Datensatzes für ein Backend-Modul generieren.
 * 
 * Auf gleicher Seite wie Original-Element einfügen:
 * ```
 * <nnt3:link.cloneRecord uid="{item.uid}" pid="{item.pid}" table="tx_myext_domain_model_entry" override="{title:'{item.title} (Kopie)'}">
 * 	<i class="fas fa-copy"></i>
 * </nnt3:link.cloneRecord>
 * ```
 * 
 * Auf gleicher Seite wie Original-Element einfügen, direkt hinter das Orignal-Element:
 * ```
 * <nnt3:link.cloneRecord uid="{item.uid}" after="{item.uid}" table="tx_myext_domain_model_entry" override="{title:'{item.title} (Kopie)'}">
 * 	<i class="fas fa-copy"></i>
 * </nnt3:link.cloneRecord>
 * ```
 */
class CloneRecordViewHelper extends TypolinkViewHelper {
	
	public function initializeArguments() {
		parent::initializeArguments();
		$this->overrideArgument('parameter', 'string', 'Parameter für Typolink', false);
		$this->registerArgument('table', 'string', 'DB Tabellen-Name', true);
		$this->registerArgument('uid', 'string', 'UID des zu kopierenden Datensatzes in Tabelle', true);
		$this->registerArgument('after', 'string', 'UID des zu Elementes, hinter das Kopie eingefügt werden soll.', true);
		$this->registerArgument('pid', 'string', 'Ziel-PID für Klon', false );
		$this->registerArgument('data', 'array', 'Data-Attribut', false, []);
		$this->registerArgument('override', 'array', 'Daten, die für neuen Eintrag gesetzt werden sollen', false, []);
   }

	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext ) {

		$args = ['table', 'uid', 'data', 'pid', 'override', 'after'];
		foreach ($args as $arg) {
			$$arg = $arguments[$arg] ?? '';
		}
		if (!$override) $override = [];
		foreach ($override as &$v) {
			$v = urlencode($v);
		}

		$uriBuilder = \nn\t3::injectClass( \TYPO3\CMS\Backend\Routing\UriBuilder::class );

		// Routing: siehe Configuration/Backend/AjaxRequests.php
		$uri = $uriBuilder->buildUriFromRoute( 'nnt3_record_processing', [
			'redirect' 	=> \nn\t3::Request()->getUri(),
		]);

		$pid = $pid ?: \nn\t3::Page()->getPid();
		if ($after) {
			$pid = -intval($after);
		}

		// &cmd[tx_tablename_xx][10][copy]=1
		$req = [
			'cmd' => [$table=>[$uid=>['copy' => [
				'action' => 'paste',
				'target' => $pid,
				'update' => $override
			]]]],
		];

		// data="{ajax:1}" in additionalAttributes für TypolinkViewHelper konvertieren.
		$dataAttr = [];
		foreach ($data as $k=>$v) {
			$dataAttr["data-{$k}"] = $v;
		}

		$arguments['parameter'] = $uri . '&' . urldecode(http_build_query( $req ));
		$arguments['additionalAttributes'] = array_merge( $arguments['additionalAttributes'] ?? [], $dataAttr );

		return parent::renderStatic( $arguments, $renderChildrenClosure, $renderingContext );
	}
	
}