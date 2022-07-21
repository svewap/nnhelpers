
.. include:: ../../Includes.txt

.. _Geo:

==============================================
Geo
==============================================

\\nn\\t3::Geo()
----------------------------------------------

Calculate and convert geo-locations and data.

To convert geo-coordinates into address data and vice versa, a Google Maps ApiKey must be
must be created and stored in the Extension Manager for nnhelpers. Alternatively you can
can specify a custom ApiKey during initialization:

.. code-block:: php

	nn\t3::Geo( $myApiKey )->getCoordinates('...');

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Geo()->getAddress(``$lng = 8.2506933201813, $lat = 50.08060702093, $returnAll = false, $language = 'de'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert geo-coordinates to address data (reverse geo coding).
If the extension ``nnaddress`` is installed, it will be used for the resolution.

.. code-block:: php

	// Return the first result.
	\nnt3::Geo()->getAddress( 8.250693320181336, 50.08060702093021 );
	
	// Return ALL results
	\nnnnt3::Geo()->getAddress( 8.250693320181336, 50.08060702093021, true );
	
	// Return ALL results in English
	\nnt3::Geo()->getAddress( 8.250693320181336, 50.08060702093021, true, 'en' );
	
	// $lng and $lat can also be passed as an array
	\nnt3::Geo()->getAddress( ['lat'=>50.08060702093021, 'lng'=>8.250693320181336] );
	
	// Use your own API key?
	\nnt3::Geo( $apiKey )->getAddress( 8.250693320181336, 50.08060702093021 );

Example return:

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

Get api key for methods in this class.
The api key can be specified either when initializing ``nn\t3::Geo()``
or in the extension manager for ``nnhelpers``.

.. code-block:: php

	\nn\t3::Geo( $myApiKey )->getCoordinates('Blumenstrasse 2, 65189 Wiesbaden');
	\nn\t3::Geo(['apiKey'=>$myApiKey])->getCoordinates('Blumenstrasse 2, 65189 Wiesbaden');

| ``@return string``

\\nn\\t3::Geo()->getCoordinates(``$address = '', $returnAll = false, $language = 'de'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert address data to geo-coordinates (Geo Coding).
If the extension ``nnaddress`` is installed, it will be used for the resolution.

.. code-block:: php

	// Query by string, return first result.
	\nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden' );
	
	// Query by array
	\nn\t3::Geo()->getCoordinates( ['street'=>'Blumenstrasse 2', 'zip'=>'65189', 'city'=>'Wiesbaden', 'country'=>'DE'] );
	
	// Return all results
	\nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden', true );
	
	// Return all results in English
	\nn\t3::Geo()->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden', true, 'en' );
	
	// Use your own API
	\nn\t3::Geo( $apiKey )->getCoordinates( 'Blumenstrasse 2, 65189 Wiesbaden' );
	

Example for return:

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

Normalizes a result from GeoCoding

| ``@param array $row``
| ``@return array``

\\nn\\t3::Geo()->toGps(``$coordinate, $hemisphere``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert GPS coordinates to readable latitude/longitude coordinates

.. code-block:: php

	\nn\t3::Geo()->toGps( ['50/1', '4/1', '172932/3125'], 'W' );

| ``@return array``

