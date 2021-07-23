<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Resource\ResourceStorage;

/**
 * Berechnungen und Konvertieren von Geopositionen und Daten
 */
class Geo implements SingletonInterface {
   
	/**
	 * Adressdaten in Geo-Koordinaten umwandeln.
	 * Erfordert zur Zeit (noch) die Extension `nnaddress`.
	 * ```
	 * \nn\t3::Geo()->getCoordinates( $address );
	 * ```
	 * @return array
	 */
	public function getCoordinates ( $address ) {

		// EXT:nnaddress verwenden, falls vorhanden
		if (\nn\t3::Environment()->extLoaded('nnaddress')) {
			$addressService = \nn\t3::injectClass( \Nng\Nnaddress\Services\AddressService::class );
			if ($coordinates = $addressService->getGeoCoordinatesForAddress( $address )) {
				return $coordinates;
			}
		}
		return [];
	}

	 /**
	 * Geo-Koordinaten in Adress-Daten umwandeln
	 * ```
	 * \nn\t3::Geo()->getAddress( 50.0804734, 8.2487459 );
	 * ```	
	 * @return array
	 */
	public function getAddress ( $lng = 50.0804734, $lat = 8.2487459, $returnAll = false ) {

		$results = [];

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
		}

		if (!$results) return [];
		return $returnAll ? $results : array_shift($results);
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