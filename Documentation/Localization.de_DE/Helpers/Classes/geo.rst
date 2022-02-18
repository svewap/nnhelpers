
.. include:: ../../Includes.txt

.. _Geo:

==============================================
Geo
==============================================

\\nn\\t3::Geo()
----------------------------------------------

Berechnungen und Konvertieren von Geopositionen und Daten.

Zum Umwandeln von Geo-Koordinaten in Adressdaten und umgekehrt, muss ein Google Maps ApiKey
erstellt werden und im Extension Manager für nnhelpers hinterlegt werden. Alternativ kann
beim Initialisieren ein eigener Api-Key angegeben werden:

.. code-block:: php

	nn\t3::Geo( $myApiKey )->getCoordinates('...');

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Geo()->getAddress(``$lng = 8.2506933201813, $lat = 50.08060702093, $returnAll = false, $language = 'de'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Geo-Koordinaten in Adress-Daten umwandeln (Reverse Geo Coding)
Falls die Extension ``nnaddress`` installiert ist, wird diese für die Auflösung verwenden.

.. code-block:: php

	// Erstes Ergebnis zurückgeben
	\nn\t3::Geo()->getAddress( 8.250693320181336, 50.08060702093021 );
	
	// ALLE Ergebnisse zurückgeben
	\nn\t3::Geo()->getAddress( 8.250693320181336, 50.08060702093021, true );
	
	// ALLE Ergebnisse in Englisch zurückgeben
	\nn\t3::Geo()->getAddress( 8.250693320181336, 50.08060702093021, true, 'en' );
	
	// $lng und $lat kann auch als Array übergeben werden
	\nn\t3::Geo()->getAddress( ['lat'=>50.08060702093021, 'lng'=>8.250693320181336] );
	
	// Eigenen API-Key verwenden?
	\nn\t3::Geo( $apiKey )->getAddress( 8.250693320181336, 50.08060702093021 );

Beispiel für Rückgabe:

.. code-block:: php

	[
	    'lat' => 50.0805069,
	    'lng' => 8.2508677,
	    'street' => 'Blumenstrass 2',
	    'zip' => '65189',
	    'city' => 'Wiesbaden',
	    ...
	]

| ``@param array|float $lng``
| ``@param float|bool $lat``
| ``@param bool $returnAll``
| ``@return array``

\\nn\\t3::Geo()->getApiKey();
"""""""""""""""""""""""""""""""""""""""""""""""

Api-Key für Methoden in dieser Klasse holen.
Der Api-Key kann entweder beim Initialisieren von ``\nn\t3::Geo()`` angegeben werden
oder im Extension Manager für ``nnhelpers``.

.. code-block:: php

	\nn\t3::Geo( $myApiKey )->getCoordinates('Blumenstrasse 2, 65189 Wiesbaden');
	\nn\t3::Geo(['apiKey'=>$myApiKey])->getCoordinates('Blumenstrasse 2, 65189 Wiesbaden');

| ``@return string``

\\nn\\t3::Geo()->getCoordinates(``$address = '', $returnAll = false, $language = 'de'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Adressdaten in Geo-Koordinaten umwandeln (Geo Coding)
Falls die Extension ``nnaddress`` installiert ist, wird diese für die Auflösung verwenden.

.. code-block:: php

	// Abfrage per String, erstes Ergebnis zurückgeben
	\nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden' );
	
	// Abfrage per Array
	\nn\t3::Geo()->getCoordinates( ['street'=>'Blumenstrasse 2', 'zip'=>'65189', 'city'=>'Wiesbaden', 'country'=>'DE'] );
	
	// Alle Ergebnisse zurückgeben
	\nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden', true );
	
	// Alle Ergebnisse in English zurückgeben
	\nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden', true, 'en' );
	
	// Eingenen Api-Key verwenden
	\nn\t3::Geo( $apiKey )->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden' );
	

Beispiel für Rückgabe:

.. code-block:: php

	[
	    'lat' => 50.0805069,
	    'lng' => 8.2508677,
	    'street' => 'Blumenstrass 2',
	    'zip' => '65189',
	    'city' => 'Wiesbaden',
	    ...
	]

| ``@param array|string $address``
| ``@return array``

\\nn\\t3::Geo()->parseAddressCompontent(``$row = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Normalisiert ein Ergebnis aus dem GeoCoding

| ``@param array $row``
| ``@return array``

\\nn\\t3::Geo()->toGps(``$coordinate, $hemisphere``);
"""""""""""""""""""""""""""""""""""""""""""""""

GPS-Koordinaten in lesbare Latitude/Longitude-Koordinaten umrechnen

.. code-block:: php

	\nn\t3::Geo()->toGps( ['50/1', '4/1', '172932/3125'], 'W' );

| ``@return array``

