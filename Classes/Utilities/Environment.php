<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use Psr\Http\Message\ServerRequestInterface;

use TYPO3\CMS\Core\Routing\SiteMatcher;
use TYPO3\CMS\Core\Site\SiteFinder;

/**
 * Alles, was man über die Umgebung der Anwendung wissen muss.
 * Von Sprach-ID des Users, der baseUrl bis zu der Frage, welche Extensions am Start sind.
 */
class Environment implements SingletonInterface {
   
	/**
	 * Das aktuelle `Site` Object holen.
	 * Über dieses Object kann z.B. ab TYPO3 9 auf die Konfiguration aus der site YAML-Datei zugegriffen werden.
	 *  
	 * Im Kontext einer MiddleWare ist evtl. die `site` noch nicht geparsed / geladen.
	 * In diesem Fall kann der `$request` aus der MiddleWare übergeben werden, um die Site zu ermitteln. 
	 * 
	 * Siehe auch `\nn\t3::Settings()->getSiteConfig()`, um die site-Konfiguration auszulesen.
	 * 
	 * ```
	 * \nn\t3::Environment()->getSite();
	 * \nn\t3::Environment()->getSite( $request );
	 * 
	 * \nn\t3::Environment()->getSite()->getConfiguration();
	 * \nn\t3::Environment()->getSite()->getIdentifier();
	 * ```
	 * @return \TYPO3\CMS\Core\Site\Entity\Site
	 */
	public function getSite ( $request = null ) {

		if (\nn\t3::t3Version() < 9) return [];
		$request = $request ?: $GLOBALS['TYPO3_REQUEST'] ?? false;

		if (!$request) return [];
		$site = $request->getAttribute('site');
		
		if (!$site) {
			$matcher = GeneralUtility::makeInstance( SiteMatcher::class, GeneralUtility::makeInstance(SiteFinder::class));
			$routeResult = $matcher->matchRequest($request);
			$site = $routeResult->getSite();	
		}

		return $site;
	}
	
	/**
	 * 	Die aktuelle Sprache (als Zahl) des Frontends holen.
	 *	```
	 *	\nn\t3::Environment()->getLanguage();
	 *	```
	 * 	@return int
	 */
	public function getLanguage () {
		if (\nn\t3::t3Version() < 9) {
			return $GLOBALS['TSFE']->sys_language_uid;
		}
		$languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
		return $languageAspect->getId();
	}

	/**
	 * 	Die aktuelle Sprache (als Kürzel wie "de") im Frontend holen
	 *	```
	 *	\nn\t3::Environment()->getLanguageKey();
	 *	```
	 * 	@return string
	 */
	public function getLanguageKey () {
		if ($GLOBALS['TYPO3_REQUEST'] instanceof ServerRequestInterface) {
			$data = $GLOBALS['TYPO3_REQUEST']->getAttribute('language', null);
			return $data->getTwoLetterIsoCode();
		}
		return '';
	}

	/**
	 *  Gibt die baseUrl (`config.baseURL`) zurück, inkl. http(s) Protokoll z.B. https://www.webseite.de/
	 *	```
	 *	\nn\t3::Environment()->getBaseURL();
	 *	```
	 * 	@return string
	 */
	public function getBaseURL () {
		if ($baseUrl = $GLOBALS['TSFE']->baseUrl ?? false) return $baseUrl;
		$setup = \nn\t3::Settings()->getFullTyposcript();
		if ($baseUrl = $setup['config']['baseURL'] ?? false) return $baseUrl;
		$server = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . "://{$_SERVER['HTTP_HOST']}/";
		return $server;
	}

	/**
	 * 	Die Domain holen z.B. www.webseite.de
	 *	```
	 *	\nn\t3::Environment()->getDomain();
	 *	```
	 * 	@return string
	 */
	public function getDomain () {
		$domain = preg_replace('/(http)([s]*)(:)\/\//i', '', $this->getBaseURL());
		return rtrim($domain, '/');
	}
	
	/**
	 * 	Prüft, ob Installation auf lokalem Server läuft
	 *	```
	 *	\nn\t3::Environment()->isLocalhost()
	 *	```
	 * 	@return boolean
	 */
	public function isLocalhost () {
		$localhost = ['127.0.0.1', '::1'];
		return in_array($_SERVER['REMOTE_ADDR'], $localhost);
	}

	/**
	 * Configuration aus `ext_conf_template.txt` holen (Backend, Extension Configuration)
	 * ```
	 * \nn\t3::Environment()->getExtConf('nnhelpers', 'varname');
	 * ```
	 * Existiert auch als ViewHelper:
	 * ```
	 * {nnt3:ts.extConf(path:'nnhelper')}
	 * {nnt3:ts.extConf(path:'nnhelper.varname')}
	 * {nnt3:ts.extConf(path:'nnhelper', key:'varname')}
	 * ```	
	 * @return mixed
	 */
	public function getExtConf ( $ext = 'nnhelpers', $param = '' ) {
		if (\nn\t3::t3Version() < 10) {
			$extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$ext]);
		} else {
			$extConfig = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][$ext];
		}
		return $param ? $extConfig[$param] : $extConfig;
	}

	/**
	 * 	Konfiguration aus der `LocalConfiguration.php` holen
	 *	```
	 *	\nn\t3::Environment()->getLocalConf('FE.cookieName');
	 *	```
	 * 	@return string
	 */
	public function getLocalConf ( $path = '' ) {
		if (!$path) return $GLOBALS['TYPO3_CONF_VARS'];
		return \nn\t3::Settings()->getFromPath( $path, $GLOBALS['TYPO3_CONF_VARS'] ) ?: '';
	}

	/**
	 * 	Die Cookie-Domain holen z.B. www.webseite.de
	 *	```
	 *	\nn\t3::Environment()->getCookieDomain()
	 *	```
	 * 	@return string
	 */
	public function getCookieDomain ( $loginType = 'FE' ) {
		$cookieDomain = $this->getLocalConf( $loginType . '.cookieDomain' ) 
			?: $this->getLocalConf( 'SYS.cookieDomain' );
		return $cookieDomain;
	}

	/**
	 * 	Absoluten Pfad zum Typo3-Root-Verzeichnis holen. z.B. `/var/www/website/`
	 *	```
	 *	\nn\t3::Environment()->getPathSite()
	 *	```
	 * 	früher: `PATH_site`
	 */
	public function getPathSite () {
		if (\nn\t3::t3Version() < 9) return PATH_site;
		return \TYPO3\CMS\Core\Core\Environment::getPublicPath().'/';
	}
	
	/**
	 * 	Relativen Pfad zum Typo3-Root-Verzeichnis holen. z.B. `../`
	 *	```
	 *	\nn\t3::Environment()->getRelPathSite()
	 *	```
	 * 	@return string
	 */
	public function getRelPathSite () {
		return \nn\t3::File()->relPath();
	}
		
	/**
	 * 	absoluten Pfad zu einer Extension holen 
	 * 	z.B. `/var/www/website/ext/nnsite/`
	 *	```
	 *	\nn\t3::Environment()->extPath('extname');
	 *	```
	 * 	@return string
	 */
	public function extPath ( $extName = '' ) {
		return ExtensionManagementUtility::extPath( $extName );
	}

	/**
	 * 	relativen Pfad (vom aktuellen Script aus) zu einer Extension holen 
	 * 	z.B. `../typo3conf/ext/nnsite/`
	 *	```
	 *	\nn\t3::Environment()->extRelPath('extname');
	 *	```
	 *	@return string
	 */
	public function extRelPath ( $extName = '' ) {
		return PathUtility::getRelativePathTo( $this->extPath($extName) );
	}
	
	/**
	 * 	Prüfen, ob Extension geladen ist.
	 *	```
	 *	\nn\t3::Environment()->extLoaded('news');
	 *	```
	 */
	public function extLoaded ( $extName = '' ) {
		return ExtensionManagementUtility::isLoaded( $extName );
	}
	
	/**
	 * 	Prüfen, ob wir uns im Frontend-Context befinden
	 *	```
	 * 	\nn\t3::Environment()->isFrontend();
	 *	```
	 * 	@return bool
	 */
	public function isFrontend () {
		return TYPO3_MODE == 'FE' && $GLOBALS['TSFE'] && $GLOBALS['TSFE']->id;
	}
	
	/**
	 * 	Prüfen, ob wir uns im Backend-Context befinden
	 *	```
	 * 	\nn\t3::Environment()->isBackend();
	 *	```
	 * 	@return bool
	 */
	public function isBackend () {
		return TYPO3_MODE == 'BE';
	}
	
	/**
	 * Die Version von Typo3 holen, als Ganzzahl, z.b "8"
	 * Alias zu `\nn\t3::t3Version()`
	 * ```
	 * \nn\t3::Environment()->t3Version();
	 * 
	 * if (\nn\t3::t3Version() >= 8) {
     * 	// nur für >= Typo3 8 LTS
	 * }
	 * ```
	 * 	@return int
	 */
	public function t3Version () {
		return \nn\t3::t3Version();
	}

	/**
	 * Alle im System verfügbaren Ländern holen
	 * ```
	 * \nn\t3::Environment()->getCountries();
	 * ```
	 * @return array
	 */
	public function getCountries ( $lang = 'de', $key = 'cn_iso_2' ) {
		if (!ExtensionManagementUtility::isLoaded('static_info_tables')) return [];
/*
		$languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
		debug( $GLOBALS['TYPO3_REQUEST']->getAttribute('language') );
*/
		$data = \nn\t3::Db()->findAll( 'static_countries' );
		return \nn\t3::Arrays($data)->key($key)->pluck('cn_short_'.$lang)->toArray();
	}

	/**
	 * 	Ein Land aus der Tabelle `static_countries` 
	 *	anhand seines Ländercodes (z.B. `DE`) holen
	 *	```
	 *	\nn\t3::Environment()->getCountryByIsocode( 'DE' );
	 *	\nn\t3::Environment()->getCountryByIsocode( 'DEU', 'cn_iso_3' );
	 *	```
	 * 	@return array
	 */
	public function getCountryByIsocode ( $cn_iso_2 = null, $field = 'cn_iso_2' ) {
		if (!ExtensionManagementUtility::isLoaded('static_info_tables')) return [];
		$data = \nn\t3::Db()->findByValues( 'static_countries', [$field=>$cn_iso_2] );
		return $data ? array_pop($data) : [];
	}

	/**
	 * Maximale Upload-Größe für Dateien aus dem Frontend zurückgeben.
	 * Diese Angabe ist der Wert, der in der php.ini festgelegt wurde und ggf.
	 * über die .htaccess überschrieben wurde.
	 * ```
	 * \nn\t3::Environment()->getPostMaxSize();  // z.B. '1048576' bei 1MB
	 * ```
	 * @return integer
	 */
	public function getPostMaxSize() {
		$postMaxSize = ini_get('post_max_size');
		return \nn\t3::Convert($postMaxSize)->toBytes();
	}
}