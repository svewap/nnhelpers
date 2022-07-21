<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;

/**
 * Berechnungen und Konvertieren von Geopositionen und Daten.
 * 
 * Zum Umwandeln von Geo-Koordinaten in Adressdaten und umgekehrt, muss ein Google Maps ApiKey
 * erstellt werden und im Extension Manager für nnhelpers hinterlegt werden. Alternativ kann
 * beim Initialisieren ein eigener Api-Key angegeben werden:
 * 
 * ```
 * nn\t3::Geo( $myApiKey )->getCoordinates('...');
 * ```
 * 
 */
class Geo implements SingletonInterface {
   
	/**
	 * 	@var mixed
	 */
	protected $config;

	/**
	 * Konfiguration für spätere Requests festlegen.
	 * 
	 * ```
	 * \nn\t3::Geo( $myApiKey )->getCoordinates('...');
	 * \nn\t3::Geo(['apiKey'=>$myApiKey])->getCoordinates('...');
	 * ```
	 * @param string|array $config
	 * @return self
	 */
	public function __construct( $config = [] )
	{
		if ($config && is_string($config)) {
			$config = ['apiKey' => $config];
		}
		$this->config = $config ?: [];
		return $this;	
	}

	/**
	 * Api-Key für Methoden in dieser Klasse holen.
	 * Der Api-Key kann entweder beim Initialisieren von `\nn\t3::Geo()` angegeben werden
	 * oder im Extension Manager für `nnhelpers`.
	 * ```
	 * \nn\t3::Geo( $myApiKey )->getCoordinates('Blumenstrasse 2, 65189 Wiesbaden');
	 * \nn\t3::Geo(['apiKey'=>$myApiKey])->getCoordinates('Blumenstrasse 2, 65189 Wiesbaden');
	 * ```
	 * @return string 
	 */
	public function getApiKey() {
		$apiKey = $this->config['apiKey'] ?? \nn\t3::Environment()->getExtConf('nnhelpers')['googleGeoApiKey'] ?? false;
		return $apiKey;
	}

	/**
	 * Adressdaten in Geo-Koordinaten umwandeln (Geo Coding)
	 * Falls die Extension `nnaddress` installiert ist, wird diese für die Auflösung verwenden.
	 * 
	 * ```
	 * // Abfrage per String, erstes Ergebnis zurückgeben
	 * \nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden' );
	 * 
	 * // Abfrage per Array
	 * \nn\t3::Geo()->getCoordinates( ['street'=>'Blumenstrasse 2', 'zip'=>'65189', 'city'=>'Wiesbaden', 'country'=>'DE'] );
	 * 
	 * // Alle Ergebnisse zurückgeben
	 * \nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden', true );
	 * 
	 * // Alle Ergebnisse in English zurückgeben
	 * \nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden', true, 'en' );
	 * 
	 * // Eingenen Api-Key verwenden
	 * \nn\t3::Geo( $apiKey )->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden' );
	 * 
	 * ```
	 * 
	 * Beispiel für Rückgabe:
	 * ```
	 * [
	 * 	'lat' => 50.0805069,
	 * 	'lng' => 8.2508677,
	 * 	'street' => 'Blumenstrass 2',
	 * 	'zip' => '65189',
	 * 	'city' => 'Wiesbaden',
	 * 	...
	 * ]
	 * ```
	 * @param array|string $address
	 * @return array
	 */
	public function getCoordinates ( $address = '', $returnAll = false, $language = 'de' ) {

		// EXT:nnaddress verwenden, falls vorhanden
		if (\nn\t3::Environment()->extLoaded('nnaddress')) {
			$addressService = \nn\t3::injectClass( \Nng\Nnaddress\Services\AddressService::class );
			if ($coordinates = $addressService->getGeoCoordinatesForAddress( $address )) {
				return $coordinates;
			}
		}

		if (is_array($address)) {
			$address = [
				'street' 	=> $address['street'] ?? '',
				'zip' 		=> $address['zip'] ?? '',
				'city' 		=> $address['city'] ?? '',
				'country' 	=> $address['country'] ?? '',
			];
			$address = "{$address['street']}, {$address['zip']} {$address['city']}, {$address['country']}";
		}
			
		$apiKey = $this->getApiKey();
		if (!$apiKey) return [];

		$result = \nn\t3::Request()->GET( 
			'https://maps.googleapis.com/maps/api/geocode/json', [
				'address' 	=> $address, 
				'key'		=> $apiKey,
				'language'	=> $language,
			]);

		$data = json_decode( $result['content'], true );
		if ($error = $data['error_message'] ?? false) {
			\nn\t3::Exception( '\nn\t3::Geo()->getCoordinates() : ' . $error );
		}

		foreach ($data['results'] as &$result) {
			$result = $this->parseAddressCompontent( $result );
		}

		return $returnAll ? $data['results'] : array_shift( $data['results'] );
	}

	/**
	 * Geo-Koordinaten in Adress-Daten umwandeln (Reverse Geo Coding)
	 * Falls die Extension `nnaddress` installiert ist, wird diese für die Auflösung verwenden.
	 *
	 * ```
	 * // Erstes Ergebnis zurückgeben
	 * \nn\t3::Geo()->getAddress( 8.250693320181336, 50.08060702093021 );
	 * 
	 * // ALLE Ergebnisse zurückgeben
	 * \nn\t3::Geo()->getAddress( 8.250693320181336, 50.08060702093021, true );
	 * 
	 * // ALLE Ergebnisse in Englisch zurückgeben
	 * \nn\t3::Geo()->getAddress( 8.250693320181336, 50.08060702093021, true, 'en' );
	 * 
	 * // $lng und $lat kann auch als Array übergeben werden 
	 * \nn\t3::Geo()->getAddress( ['lat'=>50.08060702093021, 'lng'=>8.250693320181336] );
	 * 
	 * // Eigenen API-Key verwenden?
	 * \nn\t3::Geo( $apiKey )->getAddress( 8.250693320181336, 50.08060702093021 );
	 * ```
	 * 
	 * Beispiel für Rückgabe:
	 * ```
	 * [
	 * 	'lat' => 50.0805069,
	 * 	'lng' => 8.2508677,
	 * 	'street' => 'Blumenstrass 2',
	 * 	'zip' => '65189',
	 * 	'city' => 'Wiesbaden',
	 * 	...
	 * ]
	 * ```
	 * @param array|float $lng
	 * @param float|bool $lat
	 * @param bool $returnAll
	 * @return array
	 */
	public function getAddress ( $lng = 8.250693320181336, $lat = 50.08060702093021, $returnAll = false, $language = 'de' ) {

		$results = [];

		if (is_array($lng)) {
			$returnAll = $lat;
			$lat = $lng['lat'] ?? 0;
			$lng = $lng['lng'] ?? 0;
		}

		// EXT:nnaddress verwenden, falls vorhanden
		if (\nn\t3::Environment()->extLoaded('nnaddress')) {
			$addressService = \nn\t3::injectClass( \Nng\Nnaddress\Services\AddressService::class );
			if ($addresses = $addressService->getAddressForGeoCoordinates( ['lng'=>$lng, 'lat'=>$lat] )) {
				foreach ($addresses as $address) {
					$results[] = [
						'street' 	=> $address['street'],
						'zip' 		=> $address['postal_code'],
						'city' 		=> $address['locality'],
						'country' 	=> $address['political'],
					];
				}
			}

		} else {

			$apiKey = $this->getApiKey();
			if (!$apiKey) return [];
	
			$result = \nn\t3::Request()->GET( 
				'https://maps.googleapis.com/maps/api/geocode/json', [
					'latlng' 	=> $lat . ',' . $lng, 
					'key'		=> $apiKey,
					'language'	=> $language,
				]);
	
			$data = json_decode( $result['content'], true );
			foreach ($data['results'] as &$result) {
				$result = $this->parseAddressCompontent( $result );
			}
			$results = $data['results'];
		}

		if (!$results) return [];
		return $returnAll ? $results : array_shift($results);
	}
	
	
	/**
	 * Normalisiert ein Ergebnis aus dem GeoCoding
	 * 
	 * @param array $row
	 * @return array
	 */
	public function parseAddressCompontent( $row = [] ) {
 		
		if (!$row) $row = [];

		$address = [];
		$addressShort = [];

		foreach ($row['address_components'] as $r) {
			foreach ($r['types'] as $n) {
				$address[$n] = $r['long_name'];
				$addressShort[$n] = $r['short_name'];
			}
		}

		$address['country_short'] = $addressShort['country'] ?? '';
		$address['street'] = trim(($address['route'] ?? '') . ' ' . ($address['street_number'] ?? '') );
		$address['zip'] = $address['postal_code'] ?? '';
		$address['city'] = $address['locality'] ?? '';
		$address['formatted_phone_number'] = $address['phone'] = $row['formatted_phone_number'] ?? '';
		$address['international_phone_number'] = $row['international_phone_number'] ?? '';
		$address['lat'] = $row['geometry']['location']['lat'] ?? null;
		$address['lng'] = $row['geometry']['location']['lng'] ?? null;
		
		$address['google_id'] = $row['id'] ?? '';
		$address['google_place_id'] = $row['place_id'] ?? '';
		
		return $address;
	}

	/**
	 * GPS-Koordinaten in lesbare Latitude/Longitude-Koordinaten umrechnen
	 * ```
	 * \nn\t3::Geo()->toGps( ['50/1', '4/1', '172932/3125'], 'W' );
	 * ```
	 * @return array
	 */
	public function toGps( $coordinate, $hemisphere ) {
		if (!$coordinate || !$hemisphere) return 0;
		for ($i = 0; $i < 3; $i++) {
			$part = explode('/', $coordinate[$i]);
			if (count($part) == 1) {
				$coordinate[$i] = $part[0];
			} else if (count($part) == 2) {
				$coordinate[$i] = floatval($part[0])/floatval($part[1]);
			} else {
				$coordinate[$i] = 0;
			}
		}
		list($degrees, $minutes, $seconds) = $coordinate;
		$sign = ($hemisphere == 'W' || $hemisphere == 'S') ? -1 : 1;
		return $sign * ($degrees + $minutes/60 + $seconds/3600);
	}

}