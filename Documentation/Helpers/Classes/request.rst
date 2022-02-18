
.. include:: ../../Includes.txt

.. _Request:

==============================================
Request
==============================================

\\nn\\t3::Request()
----------------------------------------------

Access to GET / POST variables, filecontainer etc.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Request()->GET(``$url = '', $queryParams = [], $headers = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sends a GET request (via curl) to a server

.. code-block:: php

	\nn\t3::Request()->GET( 'https://...', ['a'=>'123'] );
	\nn\t3::Request()->GET( 'https://...', ['a'=>'123'], ['Accept-Encoding'=>'gzip, deflate'] );

| ``@param string $url``
| ``@param array $queryParams``
| ``@param array $headers``
| ``@return array``

\\nn\\t3::Request()->GP(``$varName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Merge from $_GET and $_POST variables

.. code-block:: php

	\nn\t3::Request()->GP();

| ``@return array``

\\nn\\t3::Request()->POST(``$url = '', $postData = [], $headers = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sends a POST request (via CURL) to a server.

.. code-block:: php

	\nn\t3::Request()->POST( 'https://...', ['a'=>'123'] );
	\nn\t3::Request()->POST( 'https://...', ['a'=>'123'], ['Accept-Encoding'=>'gzip, deflate'] );

| ``@param string $url``
| ``@param array $postData``
| ``@param array $headers``
| ``@return array``

\\nn\\t3::Request()->files(``$path = NULL, $forceArray = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get file uploads from ``$_FILES`` and normalize them.

Normalizes the following file upload variants.
Removes empty file uploads from the array.

.. code-block:: php

	<input name="image" type="file" />
	<input name="image[key]" type="file" />
	<input name="images[]" type="file" multiple="1" />
	<input name="images[key][]" type="file" multiple="1" />

Examples:
Get ALL file info from ``$_FILES``.

.. code-block:: php

	\nn\t3::Request()->files();
	\nn\t3::Request()->files( true ); // force array

Get file info from ``tx_nnfesubmit_nnfesubmit[...]``.

.. code-block:: php

	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit');
	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit', true); // Force array

Only get files from ``tx_nnfesubmit_nnfesubmit[fal_media]``.

.. code-block:: php

	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit.fal_media' );
	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit.fal_media', true ); // Force array

| ``@return array``

\\nn\\t3::Request()->getAuthorizationHeader();
"""""""""""""""""""""""""""""""""""""""""""""""

Read the authorization header from the request.

.. code-block:: php

	\nn\t3::Request()->getAuthorizationHeader();

Important: If this doesn't work, the following line is probably missing from the .htaccess
is probably missing the following line:

.. code-block:: php

	# nnhelpers: use when running PHP in PHP CGI mode.
	RewriteRule . - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization},L]

| ``@return string``

\\nn\\t3::Request()->getBasicAuth();
"""""""""""""""""""""""""""""""""""""""""""""""

Read the Basic Authorization header from the request.
If present, the username and password will be returned.

.. code-block:: php

	$credentials = \nn\t3::Request()->getBasicAuth(); // ['username'=>'...', 'password'=>'...']

Example call from a test script:

.. code-block:: php

	echo file_get_contents('https://username:password@www.testsite.com');

| ``@return array``

\\nn\\t3::Request()->getBearerToken();
"""""""""""""""""""""""""""""""""""""""""""""""

Read the ``Bearer`` header.
Used to transfer a JWT (Json Web Token), among other things.

.. code-block:: php

	\nn\t3::Request()->getBearerToken();

| ``@return string|null``

\\nn\\t3::Request()->getJwt();
"""""""""""""""""""""""""""""""""""""""""""""""

Read the JWT (Json Web Token) from the request, validate it and, if the signature is
validate the signature and return the payload of the JWT.

.. code-block:: php

	\nn\t3::Request()->getJwt();

| ``@return array|string``

\\nn\\t3::Request()->getUri(``$varName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

return request URI. Basically the URL / GET string
in the browser URL bar, which is stored in ``$_SERVER['REQUEST_URI']``

.. code-block:: php

	\nn\t3::Request()->getUri();

| ``@return string``

\\nn\\t3::Request()->mergeGetParams(``$url = '', $getParams = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

