<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * 	Methoden, um im Frontend zu prüfen, ob ein User im Typo3-Backend eingeloggt ist und z.B. Admin-Rechte besitzt.
 * 	Methoden, um einen Backend-User zu starten, falls er nicht existiert (z.B. während eines Scheduler-Jobs).
 */
class BackendUser implements SingletonInterface {

	/**
	 * 	Prüft, ob ein BE-User eingeloggt ist.
	 * 	Beispiel: Im Frontend bestimmte Inhalte nur zeigen, wenn der User im Backend eingeloggt ist.
	 * 	Früher: `$GLOBALS['TSFE']->beUserLogin`
	 * 	```
	 *	\nn\t3::BackendUser()->isLoggedIn();
	 * 	```
	 * 
	 * 	@return bool
	 */
	public function isLoggedIn() {
		if (\nn\t3::t3Version() < 9) return $GLOBALS['TSFE']->beUserLogin;
		$context = GeneralUtility::makeInstance(Context::class);
		return $context->getPropertyFromAspect('backend.user', 'isLoggedIn');
	}
	
	/**
	 * 	Prüft, ob der BE-User ein Admin ist.
	 * 	Früher: `$GLOBALS['TSFE']->beUserLogin`
	 *	``` 
	 *	\nn\t3::BackendUser()->isAdmin();
	 *	```
	 *
	 * 	@return bool
	 */
	public function isAdmin() {
		if (\nn\t3::t3Version() < 9) return $GLOBALS['BE_USER']->user['admin'];
		$context = GeneralUtility::makeInstance(Context::class);
		return $context->getPropertyFromAspect('backend.user', 'isAdmin');
	}


	/**
	 *	Starte (faken) Backend-User.
	 *	Löst das Problem, das z.B. aus dem Scheduler bestimmte Funktionen
	 *	wie `log()` nicht möglich sind, wenn kein aktiver BE-User existiert.
	 *	```
	 *	\nn\t3::BackendUser()->start();
	 * 	```
	 * 	@return \TYPO3\CMS\Backend\FrontendBackendUserAuthentication
	 */		
	public function start() {
		if (!$GLOBALS['BE_USER']) {
			$GLOBALS['BE_USER'] = GeneralUtility::makeInstance( \TYPO3\CMS\Core\Authentication\BackendUserAuthentication::class );
			$GLOBALS['BE_USER']->start();
		}
		return $GLOBALS['BE_USER'];
	}
	
	/**
	 * Holt den aktuellen Backend-User.
	 * Entspricht `$GLOBALS['BE_USER']` in früheren Typo3-Versionen.
	 * ```
	 * \nn\t3::BackendUser()->get();
	 * ```
	 * @return \TYPO3\CMS\Backend\FrontendBackendUserAuthentication
	 */
	public function get() {
		return $GLOBALS['BE_USER'] ?? $this->start();
	}

	/**
	 * Speichert userspezifische Einstellungen für den aktuell eingeloggten Backend-User. 
	 * Diese Einstellungen sind auch nach Logout/Login wieder für den User verfügbar.
	 * Siehe `\nn\t3::BackendUser()->getSettings('myext')` zum Auslesen der Daten.
	 * ```
	 * \nn\t3::BackendUser()->updateSettings('myext', ['wants'=>['drink'=>'coffee']]);
	 * ```
	 * @return array
	 */
	public function updateSettings( $moduleName = 'nnhelpers', $settings = [] ) {
		if ($beUser = $this->get()) {
			if (!isset($beUser->uc[$moduleName])) {
				$beUser->uc[$moduleName] = [];
			}
			foreach ($settings as $k=>$v) {
				$beUser->uc[$moduleName][$k] = $v;
			}
			$beUser->writeUC();
			return $beUser->uc[$moduleName];
		}
		return [];
	}

	/**
	 * Holt userspezifische Einstellungen für den aktuell eingeloggten Backend-User. 
	 * Siehe `\nn\t3::BackendUser()->updateSettings()` zum Speichern der Daten.
	 * ```
	 * \nn\t3::BackendUser()->getSettings('myext');					// => ['wants'=>['drink'=>'coffee']]
	 * \nn\t3::BackendUser()->getSettings('myext', 'wants');		// => ['drink'=>'coffee']
	 * \nn\t3::BackendUser()->getSettings('myext', 'wants.drink');	// => 'coffee'
	 * ```
	 * @return mixed
	 */
	public function getSettings( $moduleName = 'nnhelpers', $path = null ) {
		$data = $this->get()->uc[$moduleName] ?? [];
		if (!$path) return $data;
		return \nn\t3::Settings()->getFromPath( $path, $data );
	}
}