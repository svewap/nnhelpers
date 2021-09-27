<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage;
use TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
use TYPO3\CMS\Extbase\Domain\Model\FileReference as FalFileReference;
use TYPO3\CMS\Extbase\Reflection\ReflectionService;
use Nng\Nnhelpers\Domain\Model\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Alles, was man für Objects und Models braucht.
 */
class Obj implements SingletonInterface {
   
	/**
	 * 	@var mixed
	 */
	protected $initialArgument;
	
	/**
	 * 	Klasse konstruieren.
	 */
	public function __construct ( $obj = null ) {
		$this->initialArgument = $obj;
		return $this;
	}

	/**
	 * 	Merge eines Arrays in ein Object
	 * 	```
	 *	\nn\t3::Obj( \My\Doman\Model )->merge(['title'=>'Neuer Titel']);
	 *	```
	 *	Damit können sogar FileReferences geschrieben / überschrieben werden.
	 *	In diesem Beispiel wird `$data` mit einem existierende Model gemerged. 
	 *	`falMedia` ist im Beispiel eine ObjectStorage. Das erste Element in `falMedia` exisitert 
	 *	bereits in der Datenbank (`uid = 12`). Hier wird nur der Titel aktualisiert. 
	 * 	Das zweite Element im Array (ohne `uid`) ist neu. Dafür wird automatisch eine neue 
	 * 	`sys_file_reference` in der Datenbank erzeugt.
	 *	```
	 *	$data = [
	 *		'uid' => 10,
	 *		'title' => 'Der Titel',
	 *		'falMedia' => [
	 *			['uid'=>12, 'title'=>'1. Bildtitel'],
	 *			['title'=>'NEU Bildtitel', 'publicUrl'=>'fileadmin/_tests/5e505e6b6143a.jpg'],
	 *		]
	 *	];
	 *	$oldModel = $repository->findByUid( $data['uid'] );
	 *	$mergedModel = \nn\t3::Obj($oldModel)->merge($data);
	 *	```
	 *	__Hinweis__
	 * 	Um ein neues Model mit Daten aus einem Array zu erzeugen gibt
	 *	es die Methode `$newModel = \nn\t3::Convert($data)->toModel( \My\Model\Name::class );`
	 *	
	 *	@return Object
	 */
	public function merge( $obj = null, $overlay = null ) {

		$overlay = $this->initialArgument !== null ? $obj : $overlay;
		$obj = $this->initialArgument !== null ? $this->initialArgument : $obj;

		if (is_array($overlay)) {

			// Storages etc. umwandeln, damit über getter/setter darauf zugegriffen werden kann
			$overlayObject = \nn\t3::Convert($overlay)->toModel( get_class($obj), $obj );

			// Wenn etwas schief ging, dann Fallback auf das overlay-array
			if ($overlayObject === false) $overlayObject = $overlay;

			unset($overlay['uid']);
			foreach ($overlay as $k=>$v) {
				if (is_string($v)) {
					$val = $v;
				} else {
					$val = \nn\t3::Obj()->get( $overlayObject, $k );
				}
				\nn\t3::Obj()->set( $obj, $k, $val );
			}
		}
		return $obj;
	}

	/**
	 * Prüft, ob es sich bei dem Object um eine Storage handelt.
	 * ```
	 * \nn\t3::Obj()->isStorage( $obj );
	 * ```
	 * @return boolean
	 */
	public function isStorage ( $obj ) {
		if (!is_object($obj) || is_string($obj)) return false;
		$type = get_class($obj);
		return is_a($obj, ObjectStorage::class) || $type == LazyObjectStorage::class || $type == ObjectStorage::class || $type == \TYPO3\CMS\Extbase\Persistence\ObjectStorage::class;
	}
	
	/**
	 * Prüft, ob es sich bei dem Object um eine `\TYPO3\CMS\Extbase\Domain\Model\FileReference` handelt.
	 * ```
	 * \nn\t3::Obj()->isFileReference( $obj );
	 * ```
	 * @return boolean
	 */
	public function isFileReference ( $obj ) {
		if (!is_object($obj)) return false;
		if (is_a($obj, \TYPO3\CMS\Extbase\Domain\Model\FileReference::class)) return true;
		$tableName = \nn\t3::Obj()->getTableName($obj);
		return $tableName == 'sys_file_reference';
	}
	
	/**
	 * Prüft, ob es sich bei dem Object um eine `\TYPO3\CMS\Core\Resource\FileReference` handelt.
	 * ```
	 * \nn\t3::Obj()->isFalFile( $obj );
	 * ```
	 * @return boolean
	 */
	public function isFalFile ( $obj ) {
		if (!is_object($obj)) return false;
		if (is_a($obj, \TYPO3\CMS\Core\Resource\FileReference::class)) return true;
		return false;
	}
	
	/**
	 * Prüft, ob es sich bei dem Object um ein `\TYPO3\CMS\Core\Resource\File` handelt.
	 * ```
	 * \nn\t3::Obj()->isFile( $obj );
	 * ```
	 * @return boolean
	 */
	public function isFile ( $obj ) {
		if (!is_object($obj)) return false;
		if (is_a($obj, \TYPO3\CMS\Core\Resource\File::class)) return true;
		return false;
	}
	

	/**
	 * Prüft, ob es sich bei dem Object um eine SysCategory handelt.
	 * Berücksichtigt alle Modelle, die in `sys_category` gespeichert werden.
	 * ```
	 * \nn\t3::Obj()->isSysCategory( $obj );
	 * 
	 * $cat = new \GeorgRinger\News\Domain\Model\Category();
	 * \nn\t3::Obj()->isSysCategory( $cat );
	 * ```
	 * @return boolean
	 */
	public function isSysCategory ( $obj ) {
		if (!is_object($obj)) return false;
		if (is_a($obj, \TYPO3\CMS\Extbase\Domain\Model\Category::class)) return true;
		$tableName = \nn\t3::Obj()->getTableName($obj);
		return $tableName == 'sys_category';
	}
	
	
	/**
	 * 	Gibt den DB-Tabellen-Namen für ein Model zurück
	 *
	 *	```
	 *	$model = new \Nng\MyExt\Domain\Model\Test;
	 *	\nn\t3::Obj()->getTableName( $model );	// 'tx_myext_domain_model_test'
	 *	\nn\t3::Obj()->getTableName( Test::class );	// 'tx_myext_domain_model_test'
	 *	```
	 * 	@return string
	 */
	public function getTableName ( $modelClassName = null ) {
		if (is_object($modelClassName)) {
			$modelClassName = get_class( $modelClassName );
		}
		$dataMapper = \nn\t3::injectClass( DataMapper::class );
		return $dataMapper->getDataMap($modelClassName)->getTableName();
	}

	/**
	 * 	Infos zum classSchema eines Models holen
	 * 	```
	 * 	\nn\t3::Obj()->getClassSchema( \My\Model\Name::class );
	 * 	\nn\t3::Obj()->getClassSchema( $myModel );
	 * 	```
	 * 	return DataMap
	 */
	public function getClassSchema( $modelClassName = null ) {
		if (is_object($modelClassName)) {
			$modelClassName = get_class( $modelClassName );
		}
		if ($cache = \nn\t3::Cache()->get($modelClassName, true)) {
			return $cache;
		}
		$reflectionService = \nn\t3::injectClass( ReflectionService::class);
		$schema = $reflectionService->getClassSchema($modelClassName);

		return \nn\t3::Cache()->set( $modelClassName, $schema, true );
	}

	/**
	 * Konvertiert ein Object in ein Array
	 * Bei Memory-Problemen wegen Rekursionen: Max-Tiefe angebenen!
	 * 
	 * ```
	 * \nn\t3::Obj()->toArray($obj, 2, ['uid', 'title']);
	 * \nn\t3::Obj()->toArray($obj, 1, ['uid', 'title', 'parent.uid']);
	 * ```
	 * @param mixed $obj 			ObjectStorage, Model oder Array das Konvertiert werden soll
	 * @param integer $depth 		Tiefe, die konvertiert werden soll. Bei rekursivem Konvertieren unbedingt nutzen
	 * @param array $fields 		nur diese Felder aus dem Object / Array zurückgeben
	 * @param boolean $addClass 	'__class' mit Infos zur Klasse ergänzen?
	 * 
	 * @return array
	 */
	public function toArray ( $obj, $depth = 3, $fields = [], $addClass = false ) {

		$depth--;
		if ($depth < 0) return;

		if (!is_object($obj) && !is_array($obj)) {
			return $obj;
		}

		$type = is_object($obj) ? get_class($obj) : false;
		$final = [];

		if (is_a($obj, \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult::class)) {
			$obj = $obj->toArray();
		}

		if (is_a($obj, \DateTime::class)) {

			// DateTime in UTC konvertieren
			$utc = $obj->getTimestamp();
			return $utc;

		} else if ($this->isStorage($obj)) {

			// StorageObject in einfaches Array konvertieren
			$obj = $this->forceArray( $obj );
			if ($addClass) $obj['__class'] = ObjectStorage::class;

		} else if (\nn\t3::Obj()->isSysCategory($obj)) {

			// SysCategory in Array konvertieren
			$parent = $this->toArray($obj->getParent(), $depth, $fields, $addClass);

			$categoryData = ['uid' => $obj->getUid(), 'title'=>$obj->getTitle(), 'parent'=>$parent];
			if ($addClass) $categoryData['__class'] = $type;
			return $categoryData;

		} else if (\nn\t3::Obj()->isFalFile($obj)) {

			// SysFile in Array konvertieren
			$falData = ['uid' => $obj->getUid(), 'title'=>$obj->getTitle(), 'publicUrl'=>$obj->getPublicUrl()];
			if ($addClass) $falData['__class'] = $type;
			return $falData;

		} else if (\nn\t3::Obj()->isFileReference($obj)) {
			
			// FileReference in einfaches Array konvertieren
			$map = ['uid', 'pid', 'title', 'alternative', 'link', 'description', 'size', 'publicUrl', 'crop', 'type'];
			$falData = [];
			if ($originalResource = $obj->getOriginalResource()) {
				$props = $originalResource->getProperties();
				$props['publicUrl'] = $originalResource->getPublicUrl();
				foreach ($map as $k=>$v) {
					$falData[$v] = $props[$v];
				}
			}

			// Falls FAL nicht über Backend erzeugt wurde, fehlt evtl. das Feld "crop". Also: mit default nachrüsten
			if (!$falData['crop']) {
				$falData['crop'] = json_encode(['default'=>['cropArea' => ['x'=>0, 'y'=>0, 'width'=>1, 'height'=>1]]]);
			}

			if ($addClass) $falData['__class'] = FalFileReference::class;
			return $falData;

		} else if ($type) {

			// Alle anderen Objekte
			$keys = $fields ?: $this->getKeys($obj);
			foreach ($keys as $field) {
				$val = $this->prop($obj, $field);
				$val = $this->toArray($val, $depth, $fields, $addClass);
				$final[$field] = $val;
			}
			return $final;
		}

		foreach ($obj as $k=>$v) {			
			$final[$k] = $this->toArray( $v, $depth, $fields, $addClass );
		}

		return $final;		
	}
	
	/**
	 * 	Einzelne Properties eines Objects oder Arrays holen
	 *	```
	 *	\nn\t3::Obj()->props( $obj, ['uid', 'pid'] );
	 *	\nn\t3::Obj()->props( $obj, 'uid' );
	 *	```
	 *	@return array
	 */
	public function props ( $obj, $keys = [] ) {
		if (is_string($keys)) {
			$keys = [$keys];
		}
		$arr = [];
		foreach ($keys as $k) {
			$arr[$k] = $this->prop( $obj, $k );
		}
		return $arr;
	}

	/**
	 * Zugriff auf einen Key in einem Object oder Array.
	 * Der Key kann auch ein Pfad sein, z.B. "img.0.uid"
	 * 
	 * \nn\t3::Obj()->prop( $obj, 'img.0.uid' );
	 * 
	 * @param mixed $obj Model oder Array
	 * @param string $key der Key, der geholt werden soll
	 * 
	 * @return mixed
	 */	
	public function prop ( $obj, $key ) {
		if ($key == '') return '';
		$key = explode('.', $key);
		if (count($key) == 1) return $this->accessSingleProperty($obj, $key[0]);
		
		foreach ($key as $k) {
			$obj = $this->accessSingleProperty($obj, $k);
			if (!$obj) return '';
		}
		return $obj;
	}
	
	
	/**
	 * 	Setzt einen Wert in einem Object oder Array.
	 *	```
	 *	\nn\t3::Obj()->set( $obj, 'title', $val );
	 *	```
	 *
	 *	@param mixed $obj 			Model oder Array
	 *	@param string $key 			der Key / Property
	 *	@param mixed $val 			der Wert, der gesetzt werden soll
	 *	@param boolean $useSetter 	setKey()-Methode zum Setzen verwenden
	 * 
	 *	@return mixed
	 */	
	public function set( $obj, $key = '', $val = '', $useSetter = true) {

		$settable = ObjectAccess::isPropertySettable($obj, $key);

		if (!$settable) {
			$key = GeneralUtility::underscoredToLowerCamelCase( $key );
			$settable = ObjectAccess::isPropertySettable($obj, $key);
		}

		if ($settable) {

			if (is_object($obj)) {
				$schema = \nn\t3::Obj()->getClassSchema($obj);
				$modelProperties = $schema->getProperties();
				if ($prop = $modelProperties[$key] ?? false) {
					$type = \nn\t3::Obj()->get( $prop, 'type' );
					switch ($type) {
						case 'int':
							$val = (int)$val;
							break;
						case 'float':
							$val = (float)$val;
							break;
					}
				}
			}
	
			if (in_array($key, ['deleted', 'hidden'])) $val = $val ? true : false;
			ObjectAccess::setProperty($obj, $key, $val, !$useSetter);
		}
		return $obj;
	}
	
	/**
	 * 	Zugriff auf einen Wert in dem Object anhand des Keys
	 * 	Alias zu `\nn\t3::Obj()->accessSingleProperty()`
	 *	```
	 *	\nn\t3::Obj()->get( $obj, 'title' );
	 *	\nn\t3::Obj()->get( $obj, 'falMedia' );
	 *	\nn\t3::Obj()->get( $obj, 'fal_media' );
	 *	```
	 *
	 *	@param mixed $obj 			Model oder Array
	 *	@param string $key 			der Key / Property
	 * 
	 *	@return mixed
	 */	
	public function get( $obj, $key = '' ) {
		return $this->accessSingleProperty($obj, $key);
	}
	
	
	/**
	 * Zugriff auf einen Key in einem Object oder Array
	 * key muss einzelner String sein, kein Pfad
	 * 
	 * \nn\t3::Obj()->accessSingleProperty( $obj, 'uid' );
	 * \nn\t3::Obj()->accessSingleProperty( $obj, 'fal_media' );
	 * \nn\t3::Obj()->accessSingleProperty( $obj, 'falMedia' );
	 * 
	 * @param mixed $obj Model oder Array
	 * @param string $key der Key, der geholt werden soll
	 * 
	 * @return mixed
	 */	
	public function accessSingleProperty ( $obj, $key ) {
		if ($key == '') return '';

		if (is_object($obj)) {
			
			if (is_numeric($key)) {
				$obj = $this->forceArray($obj);
				return $obj[intval($key)];
			}

			$gettable = ObjectAccess::isPropertyGettable($obj, $key);
			if ($gettable) return ObjectAccess::getProperty($obj, $key);

			$camelCaseKey = GeneralUtility::underscoredToLowerCamelCase( $key );
			$gettable = ObjectAccess::isPropertyGettable($obj, $camelCaseKey);
			if ($gettable) return ObjectAccess::getProperty($obj, $camelCaseKey);

			return $obj->$key;

		} else {
			if (is_array($obj)) return $obj[$key];
		}
		return [];
	}
	
	
	/**
	 * 	Zugriff auf ALLE Keys, die in einem Object zu holen sind
	 * 	```
	 *	\nn\t3::Obj()->getKeys( $model );									// ['uid', 'title', 'text', ...]
	 *	\nn\t3::Obj()->getKeys( $model );									// ['uid', 'title', 'text', ...]
	 *	\nn\t3::Obj()->getKeys( \Nng\MyExt\Domain\Model\Demo::class );		// ['uid', 'title', 'text', ...]
	 *	```
	 *	@param mixed $obj Model, Array oder Klassen-Name
	 * 	@return array
	 */	
	public function getKeys ( $obj ) {
		if (is_string($obj) && class_exists($obj)) {
			$obj = new $obj();	
		}
		$keys = [];
		if (is_object($obj)) {
			return ObjectAccess::getGettablePropertyNames($obj);
		} else if (is_array($obj)) {
			return array_keys($obj);
		}
		return [];
	}
	
	/**
	 * Alle keys eines Objektes holen, die einen SETTER haben.
	 * Im Gegensatz zu `\nn\t3::Obj()->getKeys()` werden nur die Property-Keys
	 * zurückgegeben, die sich auch setzen lassen, z.B. über `setNameDerProp()`
	 * 
	 * @return array
	 */
	public function getSetableKeys( $obj ) {
		$props = $this->getProps( $obj, null, true );
		return array_keys( $props );
	}
	

	/**
	 * 	Liste der Properties eines Objects oder Models mit Typ zurückgeben.
	 * 	```
	 *	\nn\t3::Obj()->getProps( $obj );			// ['uid'=>'integer', 'title'=>'string' ...]
	 *	\nn\t3::Obj()->getProps( $obj, true );		// ['uid'=>[type=>'integer', 'private'=>TRUE]]
	 *	\nn\t3::Obj()->getProps( $obj, 'default' );	// ['uid'=>TRUE]
	 *	\nn\t3::Obj()->getProps( \Nng\MyExt\Domain\Model\Demo::class );
	 *	```
	 *	@param mixed $obj 				Model oder Klassen-Name
	 *	@param mixed $key 				Wenn TRUE wird Array mit allen Infos geholt, z.B. auch default-Wert etc.
	 *	@param boolean $onlySettable 	Nur properties holen, die auch per setName() gesetzt werden können 
	 * 	@return array
	 */	
	public function getProps ( $obj, $key = 'type', $onlySettable = true ) {
		if (is_string($obj) && class_exists($obj)) {
			$obj = new $obj();
		}
		$schema = $this->getClassSchema( $obj );
		$properties = $schema->getProperties();

		if ($onlySettable) {
			$settables = array_flip(ObjectAccess::getSettablePropertyNames($obj));
			foreach ($properties as $k=>$p) {
				if (!$settables[$k]) unset( $properties[$k] );
			}
		}

		if (\nn\t3::t3Version() < 10) {
			if ($key === true) return $properties;
			return array_combine( array_keys($properties), array_column($properties, $key) );
		} else {
			$flatProps = [];
			foreach ($properties as $name=>$property) {
				$flatProps[$name] = $this->accessSingleProperty( $property, $key );
			}
			return $flatProps;
		}
	}


	
	/**
	 * Konvertiert zu Array
	 * 
	 * @param mixed $obj
	 * 
	 * @return array
	 */	
	public function forceArray($obj) {
		if (!$obj) return [];
		if ($this->isStorage($obj)) {
			$tmp = [];
			foreach ($obj as $k=>$v) {
				$tmp[] = $v;
			}
			return $tmp;
		}
		return is_array($obj) ? $obj : [$obj];
	}
	
	
	/**
	 * Vergleicht zwei Objekte, gibt Array mit Unterschieden zurück.
	 * Existiert eine Property von objA nicht in objB, wird diese ignoriert.
	 * 
	 * ```
	 * // gibt Array mit Unterschieden zurück
	 * \nn\t3::Obj()->diff( $objA, $objB );
	 * 
	 * // ignoriert die Felder uid und title
	 * \nn\t3::Obj()->diff( $objA, $objB, ['uid', 'title'] );
	 * 
	 * // Vergleicht NUR die Felder title und bodytext
	 * \nn\t3::Obj()->diff( $objA, $objB, [], ['title', 'bodytext'] );
	 * 
	 * // Optionen
	 * \nn\t3::Obj()->diff( $objA, $objB, [], [], ['ignoreWhitespaces'=>true, 'ignoreTags'=>true, 'ignoreEncoding'=>true] );
	 * ```
	 *
	 * @param mixed $objA				Ein Object, Array oder Model
	 * @param mixed $objB				Das zu vergleichende Object oder Model
	 * @param array $fieldsToIgnore	    Liste der Properties, die ignoriert werden können. Leer = keine
	 * @param array $fieldsToCompare	Liste der Properties, die verglichen werden sollen. Leer = alle
	 * @param boolean $options  		Optionen / Toleranzen beim Vergleichen
	 * 									`ignoreWhitespaces` => Leerzeichen ignorieren
	 * 									`ignoreEncoding`	=> UTF8 / ISO-Encoding ignorieren
	 * 									`ignoreTags`		=> HTML-Tags ignorieren
	 * 
	 * @return array
	 */	
	public function diff( $objA, $objB, $fieldsToIgnore = [], $fieldsToCompare = [], $options = [] ) {

		$arrA = $this->toArray( $objA );
		$arrB = $this->toArray( $objB );

		// Keine Felder zum Vergleich angegeben? Dann alle nehmen
		if (!$fieldsToCompare) {
			$fieldsToCompare = array_keys( $arrA );
		}

		// Felder, die ignoriert werden sollen abziehen.
		$fieldsToCheck = array_diff( $fieldsToCompare, $fieldsToIgnore );

		$diff = [];
		foreach ($fieldsToCheck as $k=>$fieldName) {

			$hasDiff = false;
			$valA = $arrA[$fieldName];
			$valB = $arrB[$fieldName] ?? null;

			// Property existiert nur in objA? Dann ignorieren
			if (!isset($arrB[$fieldName])) continue;

			if (is_array($valA)) {

				// Vergleich eines Arrays
				$isStorage = is_array(\nn\t3::Arrays($valA)->first()) || is_array(\nn\t3::Arrays($valB)->first());
				if ($isStorage && count($valA) != count($valB)) {
					$hasDiff = true;
				}

				if ($arrDiff = $this->diff( $valA, $valB )) {
					$hasDiff = true;
				}

			} else {

				// Einfacher String-Vergleich

				$cmpA = $valA;
				$cmpB = $valB;
				
				if (is_string($cmpA) && is_string($cmpB)) {
					if ($options['ignoreWhitespaces'] ?? false) {
						$cmpA = preg_replace('/[\s\t]/', '', $cmpA);
						$cmpB = preg_replace('/[\s\t]/', '', $cmpB);
					}
					if ($options['ignoreTags'] ?? false) {
						$cmpA = strip_tags($cmpA);
						$cmpB = strip_tags($cmpB);
					}
					if ($options['ignoreEncoding'] ?? false) {
						$cmpA = \nn\t3::Convert($cmpA)->toUTF8();
						$cmpB = \nn\t3::Convert($cmpB)->toUTF8();
					}
				}

				$hasDiff = $cmpA != $cmpB;
			}

			// Gab es einen Unterschied? Dann diff-Array befüllen
			if ($hasDiff) {
				$diff[$fieldName] = [
					'from'	=> $valA, 
					'to'	=> $valB, 
				];
			} 

		}

		return $diff;
	}

}