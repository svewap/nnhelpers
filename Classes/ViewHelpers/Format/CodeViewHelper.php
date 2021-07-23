<?php

namespace Nng\Nnhelpers\ViewHelpers\Format;

use Nng\Nnhelpers\ViewHelpers\AbstractViewHelper;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * Highlighted code-Abschnitte
 * siehe: https://prismjs.com/
 * 
 * Build:
 * https://prismjs.com/download.html#themes=prism-tomorrow&languages=markup+css+clike+javascript+git+markup-templating+php+php-extras+powershell+scss+sql+typoscript+yaml&plugins=toolbar+copy-to-clipboard+download-button
 * 
 * ```
 * <nnt3:format.code lang="css" download="rte.css">
 *   ... Markup ...
 * </nnt3:format.code>
 * ```
 * 
 * Sprachen für Syntax-Highlighting:
 * 
 * | ---------- | ------------- |
 * | lang 		| Interpreter	|
 * | css 		| CSS 			|
 * | typoscript | TypoScript 	|
 * | tsconfig 	| PageTsConfig 	|
 * 
 */
class CodeViewHelper extends AbstractViewHelper {

	protected $escapingInterceptorEnabled = false;

	public function initializeArguments() {
		$this->registerArgument('str', 'string', 'Code', false);
		$this->registerArgument('lang', 'string', 'Sprache', false);
		$this->registerArgument('download', 'string', 'Download Dateiname', false);
	}

	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext ) {

		$str = $arguments['str'] ?: $renderChildrenClosure();
		$lang = $arguments['lang'] ?: 'css';

		// Prism Plugin erlaubt simplen Download
		if ($download = $arguments['download']) {
			$download = 'data-src="' . $download . '" data-nndownload data-download-link-label="Download"';
		}

        return '<pre ' . $download . '><code class="language-' . $lang . '">'.trim(htmlspecialchars($str, ENT_QUOTES, 'UTF-8')).'</code></pre>';
	}
}