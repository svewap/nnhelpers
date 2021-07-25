
.. include:: ../Includes.txt

.. _Geo:

============
Geo
============

\\nn\\t3::Geo()
---------------

Calculations and conversion of geopositions and data

Overview of Methods
~~~~~~~~~~~~~~~~

\\nn\\t3::Geo()->getCoordinates(``$address``);
""""""""""""""""

Convert address data to geo-coordinates.
Currently (still) requires the ``nnaddress`` extension.

.. code-block:: php

	\nn\t3::Geo()->getCoordinates( $address );

| ``@return array``

\\nn\\t3::Geo()->getAddress(``$lng = 50.0804734, $lat = 8.2487459, $returnAll = false``);
""""""""""""""""

Convert geo-coordinates to address data

.. code-block:: php

	\nn\t3::Geo()->getAddress( 50.0804734, 8.2487459 );

| ``@return array``

\\nn\\t3::Geo()->toGps(``$coordinate, $hemisphere``);
""""""""""""""""

Convert GPS coordinates to readable latitude/longitude coordinates

.. code-block:: php

	\nn\t3::Geo()->toGps( ['50/1', '4/1', '172932/3125'], 'W' );

| ``@return array``

