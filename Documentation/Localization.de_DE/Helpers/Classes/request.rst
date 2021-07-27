
.. include:: ../../Includes.txt

.. _Request:

==============================================
Request
==============================================

\\nn\\t3::Request()
----------------------------------------------

Zugriff auf GET / POST Variablen, Filecontainer etc.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Request()->GP(``$varName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Merge aus $_GET und $_POST-Variablen

.. code-block:: php

	\nn\t3::Request()->GP();

| ``@return array``

\\nn\\t3::Request()->POST(``$url = '', $postData = [], $headers = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sendet einen POST Request (per CURL) an einen Server.

.. code-block:: php

	\nn\t3::Request()->POST( 'https://...', ['a'=>'123'] );

| ``@return array``

\\nn\\t3::Request()->files(``$path = NULL, $forceArray = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

File-Uploads aus ``$_FILES`` holen und normalisieren.

Normalisiert folgende File-Upload-Varianten.
Enfernt leere Datei-Uploads aus dem Array.

.. code-block:: php

	<input name="image" type="file" />
	<input name="image[key]" type="file" />
	<input name="images[]" type="file" multiple="1" />
	<input name="images[key][]" type="file" multiple="1" />

Beispiele:
ALLE Datei-Infos aus ``$_FILES``holen.

.. code-block:: php

	\nn\t3::Request()->files();
	\nn\t3::Request()->files( true ); // Array erzwingen

Datei-Infos aus ``tx_nnfesubmit_nnfesubmit[...]`` holen.

.. code-block:: php

	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit');
	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit', true);  // Array erzwingen

Nur Dateien aus ``tx_nnfesubmit_nnfesubmit[fal_media]`` holen.

.. code-block:: php

	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit.fal_media' );
	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit.fal_media', true ); // Array erzwingen

| ``@return array``

\\nn\\t3::Request()->getUri(``$varName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Request-URI zurückgeben. Im Prinzip die URL / der GET-String
in der Browser URL-Leiste, der in ``$_SERVER['REQUEST_URI']``
gespeichert wird.

.. code-block:: php

	\nn\t3::Request()->getUri();

| ``@return string``

