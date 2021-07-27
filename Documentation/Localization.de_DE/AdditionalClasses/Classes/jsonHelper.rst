
.. include:: ../../Includes.txt

.. _JsonHelper:

==============================================
JsonHelper
==============================================

\\nn\\t3::JsonHelper()
----------------------------------------------

The script helps convert and parse JavaScript object strings into an array.

.. code-block:: php

	$data = \Nng\Nnhelpers\JsonHelper::decode( "{title:'Test', cat:[2,3,4]}" );
	print_r($data);

The helper makes it possible to use the JavaScript object notation in TypoScript and convert it to an array via the ``{nnt3:parse.json()}`` ViewHelper.
This is handy if, for example, slider configurations or other JavaScript objects should be defined in TypoScript to be used later in JavaScript.

Another usage example: you want to use the "normal" JS syntax in a ``.json`` file, instead of the JSON syntax.
Let's look at an example. This text was written to a text file and is to be parsed via PHP:

.. code-block:: php

	// Contents of a text file.
	{
	    Example: ['one', 'two', 'three']
	}

PHP would report an error with ``json_decode()`` for this example: The string contains comments, wraps, and the keys and values are not enclosed in double quotes. However, the JsonHelper or the ViewHelper ``$jsonHelper->decode()`` can convert it easily.

This is how you could define a JS object in the TypoScript setup:

.. code-block:: php

	// Contents in TS setup.
	my_conf.data (
	  {
	     dots: true,
	     sizes: [1, 2, 3]
	  }
	)

The mix is a little irritating: ``my_conf.data (...)`` öffnets a section in the TypoScript for multi-line code.
Between the ``(...)`` is then a "normal" JavaScript object.
This can then be easily used as an array in the Fluid template:

.. code-block:: php

	{nnt3:ts.setup(path:'my_conf.data')->f:variable(name:'myConfig')}
	{myConfig->nnt3:parse.json()->f:debug()}

Or append as a data attribute to an element to parse it later via JavaScript:

.. code-block:: php

	{nnt3:ts.setup(path:'my_conf.data')->f:variable(name:'myConfig')}
	<div data-config="{myConfig->nnt3:parse.json()->nnt3:format.attrEncode()}">...</div>

This script is based üpredominantly on the work of https://bit.ly/3eZuNu2 and
has been optimized by us for PHP 7+.All credit to that direction, please.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::JsonHelper()->decode(``$str, $useArray = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a JS object string into an array.

.. code-block:: php

	$data = \Nng\Nnhelpers\JsonHelper::decode( "{title:'Test', cat:[2,3,4]}" );
	print_r($data);

The PHP function ``json_decode()`` only works for JSON syntax: ``{"key": "value"}``. In JSON, neither line breaks nor comments are allowed.
This function can also be used to parse strings in JavaScript notation.

| ``@return array|string``

\\nn\\t3::JsonHelper()->encode(``$var``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a variable to JSON format.
Relic of the original class, presumably from a time when ``json_encode()`` did not exist.

.. code-block:: php

	\Nng\Nnhelpers\JsonHelper::encode(['a'=>1, 'b'=>2]);

| ``@return string;``

\\nn\\t3::JsonHelper()->removeCommentsAndDecode(``$str, $useArray = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Removes comments from the code and parses the string.

.. code-block:: php

	\Nng\Nnhelpers\JsonHelper::removeCommentsAndDecode( "//comments\n{title:'Test', cat:[2,3,4]}" )

| ``@return array|string``

