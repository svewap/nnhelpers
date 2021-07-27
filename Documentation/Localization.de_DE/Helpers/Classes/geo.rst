
.. include:: ../../Includes.txt

.. _Geo:

==============================================
Geo
==============================================

\\nn\\t3::Geo()
----------------------------------------------

Berechnungen und Konvertieren von Geopositionen und Daten

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Geo()->getAddress(``$lng = 50.0804734, $lat = 8.2487459, $returnAll = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Geo-Koordinaten in Adress-Daten umwandeln

.. code-block:: php

	\nn\t3::Geo()->getAddress( 50.0804734, 8.2487459 );

| ``@return array``

\\nn\\t3::Geo()->getCoordinates(``$address``);
"""""""""""""""""""""""""""""""""""""""""""""""

Adressdaten in Geo-Koordinaten umwandeln.
Erfordert zur Zeit (noch) die Extension ``nnaddress``.

.. code-block:: php

	\nn\t3::Geo()->getCoordinates( $address );

| ``@return array``

\\nn\\t3::Geo()->toGps(``$coordinate, $hemisphere``);
"""""""""""""""""""""""""""""""""""""""""""""""

GPS-Koordinaten in lesbare Latitude/Longitude-Koordinaten umrechnen

.. code-block:: php

	\nn\t3::Geo()->toGps( ['50/1', '4/1', '172932/3125'], 'W' );

| ``@return array``

