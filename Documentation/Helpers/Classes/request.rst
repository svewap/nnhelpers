
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

\\nn\\t3::Request()->getUri(``$varName = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

return request URI. Basically the URL / GET string
in the browser URL bar, which is stored in ``$_SERVER['REQUEST_URI']``

.. code-block:: php

	\nn\t3::Request()->getUri();

| ``@return string``

