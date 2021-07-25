<?php
namespace Nng\Nnhelpers\Helpers;

/**
 * Übersetzungsmanagement per Deep-L
 * 
 * ```
 * // Übersetzer aktivieren
 * $translationHelper = \nn\t3::injectClass( \Nng\Nnhelpers\Helpers\TranslationHelper::class );
 * 
 * // Übersetzung per Deep-L erlauben
 * $translationHelper->setEnableApi( true );

 * // Zielsprache festlegen
 * $translationHelper->setTargetLanguage( 'EN' );
 * 
 * // Max. Anzahl der Übersetzungen erlauben (zwecks Debugging)
 * $translationHelper->setMaxTranslations( 2 );
 * 
 * // Pfad, in dem die l18n-Dateien gespeichert / gecached werden sollen
 * $translationHelper->setL18nFolderpath( 'EXT:nnhelpers/Resources/Private/Language/' );
 * 
 * // Übersetzung starten
 * $text = $translationHelper->translate('my.example.key', 'Das ist der Text, der übersetzt werden soll');
 * ```
 */
class TranslationHelper {
	
	/**
	 * Pfad zum Ordner mit den Übersetzungsdateien (JSON)
	 * @var string
	 */
	protected $l18nFolderpath = 'typo3conf/l10n/nnhelpers/';
	
	/**
	 * Zielsprache der Übersetzung
	 * @var string
	 */
	protected $targetLanguage = 'EN';

	/**
	 * Nicht übersetzte Texte automatisch per Deep-L übersetzen?
	 * @var boolean
	 */
	protected $enableApi = false;

	/**
	 * Cache der Übersetzungen
	 * @var array
	 */
	protected $l18nCache = [];
	
	/**
	 * Maximale Anzahl an Übersetzungen
	 * @var integer
	 */
	protected $maxTranslations = 0;

	/**
	 * Anzahl an Übersetzungen
	 * @var integer
	 */
	protected $numTranslations = 0;


	/**
	 * @return  boolean
	 */
	public function getEnableApi() {
		return $this->enableApi;
	}

	/**
	 * @param   boolean  $enableApi
	 * @return  self
	 */
	public function setEnableApi($enableApi) {
		$this->enableApi = $enableApi;
		return $this;
	}

	/**
	 * @return  string
	 */
	public function getL18nFolderpath() {
		return $this->l18nFolderpath;
	}

	/**
	 * @param   string  $l18nFolderpath  Pfad zum Ordner mit den Übersetzungsdateien (JSON)
	 * @return  self
	 */
	public function setL18nFolderpath($l18nFolderpath) {
		$this->l18nFolderpath = $l18nFolderpath;
		return $this;
	}

	/**
	 * @return  string
	 */
	public function getTargetLanguage() {
		return $this->targetLanguage;
	}

	/**
	 * @param   string  $targetLanguage  Zielsprache der Übersetzung
	 * @return  self
	 */
	public function setTargetLanguage($targetLanguage) {
		$this->targetLanguage = $targetLanguage;
		return $this;
	}

	/**
	 * @return 
	 */
	public function getMaxTranslations() {
		return $this->maxTranslations;
	}

	/**
	 * @param   $maxTranslations
	 * @return  self
	 */
	public function setMaxTranslations($maxTranslations) {
		$this->maxTranslations = $maxTranslations;
		return $this;
	}

	/**
	 * Absoluten Pfad zur l18n-Cache-Datei zurückgeben
	 * @return string
	 */
	public function getL18nPath() {
		$path = rtrim($this->getL18nFolderpath(), '/').'/';
		$file = \nn\t3::File()->absPath( $path . strtolower($this->targetLanguage) . '.autotranslated.json' );
		return $file;
	}

	/**
	 * Sprach-Datei laden und cachen
	 * @return array
	 */
	public function loadL18nData() {
		if ($cache = $this->l18nCache) return $cache;
		$path = $this->getL18nPath();
		$data = json_decode( \nn\t3::File()->read($path), true ) ?: [];
		return $this->l18nCache = $data;
	}

	/**
	 * Sprach-Datei speichern
	 * @return boolean
	 */
	public function saveL18nData( $data = [] ) {
		$path = $this->getL18nPath();
		$success = \nn\t3::File()->write($path, json_encode($data));
		if (!$success) {
			\nn\t3::Exception('l18n-Datei konnte nicht geschrieben werden: ' . $path);
		}
		$this->l18nCache = $data;
		return $path;
	}

	/**
	 * Übersetzen eines Textes.
	 * @return string
	 */
	public function translate( $key, $text = '' ) {

		$keyHash = $this->createKeyHash( $key );
		$textHash = $this->createTextHash( $text );
		$l18nData = $this->loadL18nData();

		$translation = $l18nData[$keyHash] ?? ['_cs'=>false];
		$textChanged = $translation['_cs'] != $textHash;
		
		$autoTranslateEnabled = $this->enableApi && ($this->maxTranslations == 0 || $this->maxTranslations > $this->numTranslations );

		// Text wurde übersetzt und hat sich nicht geändert
		if (!$textChanged) {
			return $translation['text'];
		}
		
		// Text wurde nicht übersetzt und Deep-L Übersetzung ist deaktiviert
		if (!$autoTranslateEnabled) {
			if ($translation['_cs'] !== false) {
				return "[Translation needs {$this->targetLanguage} update] " . $text;
			}	
			return "[Translate to {$this->targetLanguage}] " . $text;
		}

		$this->numTranslations++;		
		echo "Translating via Deep-L: {$this->numTranslations} / {$this->maxTranslations} [$keyHash] " . json_encode($key) . "\n";

		$result = \nn\t3::LL()->translate( $text, $this->targetLanguage );

		$l18nData[$keyHash] = [
			'_cs' => $textHash,
			'text' => $result,
		];

		$this->saveL18nData( $l18nData );
		return $result;
	}

	/**
	 * Key-Hash erzeugen
	 * @return string
	 */
	public function createKeyHash( $param = '' ) {
		return md5(json_encode(['_'=>$param]));
	}
	
	/**
	 * Text-Hash erzeugen.
	 * Ignoriert Whitespaces und Tags.
	 * @return string
	 */
	public function createTextHash( $text = '' ) {
		$text = strtolower(preg_replace('/\s+/', '', strip_tags( $text )));
		return md5($text);
	}


}