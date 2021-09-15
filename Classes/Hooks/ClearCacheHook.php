<?php

namespace Nng\Nnhelpers\Hooks;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Form\AbstractNode;

/**
 * Hook, der beim Löschen des Cache aufgerufen wird.
 * 
 */
class ClearCacheHook {

	/**
	 * Löscht alle `nnhelpers`-Caches.
	 * 
	 * Wird vom Core beim Klick auf den Blitz im Backend aufgerufen.
	 * Registriert in der `ext_localconf.php` von nnhelpers.
	 * 
	 * @return void
	 */
	public function postProcessClearCache() {
		\nn\t3::Cache()->clear();
	}

}