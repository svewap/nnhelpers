<?php
namespace Nng\Nnhelpers\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Frontend\ContentObject\RecordsContentObject;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Ein Content-Element rendern
 * 
 * Der von uns wahrscheinlich meist genutzte ViewHelper.
 * 
 * Content-Element aus der Tabelle `tt_content` mit der `uid: 123` rendern.
 * ```
 * {nnt3:contentElement(uid:123)}
 * ```
 * Variablen im gerenderten Content-Element ersetzen.
 * Erlaubt es, im Backend ein Inhaltselement anzulegen, das mit Fluid-Variablen arbeitet – z.B. für ein Mail-Template, bei dem der Empfänger-Name im Text erscheinen soll.
 * ```
 * {nnt3:contentElement(uid:123, data:'{greeting:\'Hallo!\'}')}
 * {nnt3:contentElement(uid:123, data:feUser.data)}
 * ```
 * Zum Rendern der Variablen muss nicht zwingend eine `contentUid` übergeben werden. Es kann auch direkt HTML-Code geparsed werden:
 * ```
 * {data.bodytext->nnt3:contentElement(data:'{greeting:\'Hallo!\'}')}
 * ```
 * @return string	
 */
class ContentElementViewHelper extends AbstractViewHelper {

	use CompileWithRenderStatic;

	protected $escapeOutput = false;

	public function initializeArguments() {
	   $this->registerArgument('content', 'string', 'String, der über Fluid geparsed werden soll', false);
	   $this->registerArgument('uid', 'int', 'UID des Inhaltselementes, das gerendert werden soll', false);
	   $this->registerArgument('data', 'array', 'Data', false);
   }

	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext ) {
		
		$content = $arguments['content'] ?: $renderChildrenClosure() ?: '';
		$uid = $arguments['uid'];
		$data = $arguments['data'];

		if (!$uid) {
			$html = \nn\t3::Template()->renderHtml( $content, $data );
		} else {
			$html = \nn\t3::Content()->render( $uid, $data );
		}

		return $html;
	}
    
}
