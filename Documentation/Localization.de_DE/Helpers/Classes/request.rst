
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

\\nn\\t3::Request()->GET(``$url = '', $queryParams = [], $headers = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sendet einen GET Request (per curl) an einen Server

.. code-block:: php

	\nn\t3::Request()->GET( 'https://...', ['a'=>'123'] );
	\nn\t3::Request()->GET( 'https://...', ['a'=>'123'], ['Accept-Encoding'=>'gzip, deflate'] );

| ``@param string $url``
| ``@param array $queryParams``
| ``@param array $headers``
| ``@return array``

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
	\nn\t3::Request()->POST( 'https://...', ['a'=>'123'], ['Accept-Encoding'=>'gzip, deflate'] );

| ``@param string $url``
| ``@param array $postData``
| ``@param array $headers``
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

\\nn\\t3::Request()->getAuthorizationHeader();
"""""""""""""""""""""""""""""""""""""""""""""""

Den Authorization-Header aus dem Request auslesen.

.. code-block:: php

	\nn\t3::Request()->getAuthorizationHeader();

Wichtig: Wenn das hier nicht funktioniert, fehlt in der .htaccess
wahrscheinlich folgende Zeile:

.. code-block:: php

	# nnhelpers: Verwenden, wenn PHP im PHP-CGI-Mode ausgeführt wird
	RewriteRule . - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization},L]

| ``@return string``

\\nn\\t3::Request()->getBasicAuth();
"""""""""""""""""""""""""""""""""""""""""""""""

Den Basic Authorization Header aus dem Request auslesen.
Falls vorhanden, wird der Username und das Passwort zurückgeben.

.. code-block:: php

	$credentials = \nn\t3::Request()->getBasicAuth(); // ['username'=>'...', 'password'=>'...']

Beispiel-Aufruf von einem Testscript aus:

.. code-block:: php

	echo file_get_contents('https://username:password@www.testsite.com');

| ``@return array``

\\nn\\t3::Request()->getBearerToken();
"""""""""""""""""""""""""""""""""""""""""""""""

Den ``Bearer``-Header auslesen.
Wird u.a. verwendet, um ein JWT (Json Web Token) zu übertragen.

.. code-block:: php

	\nn\t3::Request()->getBearerToken();

| ``@return string|null``

\\nn\\t3::Request()->getJwt();
"""""""""""""""""""""""""""""""""""""""""""""""

Den JWT (Json Web Token) aus dem Request auslesen, validieren und bei
erfolgreichem Prüfen der Signatur den Payload des JWT zurückgeben.

.. code-block:: php

	\nn\t3::Request()->getJwt();

| ``@return array|string``

\\nn\\t3::Request()->getUri(``$varName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Request-URI zurückgeben. Im Prinzip die URL / der GET-String
in der Browser URL-Leiste, der in ``$_SERVER['REQUEST_URI']``
gespeichert wird.

.. code-block:: php

	\nn\t3::Request()->getUri();

| ``@return string``

\\nn\\t3::Request()->mergeGetParams(``$url = '', $getParams = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

