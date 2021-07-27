
.. include:: ../../Includes.txt

.. _JsonHelper:

==============================================
JsonHelper
==============================================

\\nn\\t3::JsonHelper()
----------------------------------------------

Das Script hilft beim Konvertieren und Parsen von JavaScript-Objekt-Strings in ein Array.

.. code-block:: php

	$data = \Nng\Nnhelpers\Helpers\JsonHelper::decode( "{title:'Test', cat:[2,3,4]}" );
	print_r($data);

Der Helper ermöglicht es, im TypoScript die JavaScript-Object-Schreibweise zu nutzen und über den ``{nnt3:parse.json()}`` ViewHelper in ein Array zu konvertieren.
Das ist praktisch, wenn z.B. Slider-Konfigurationen oder andere JavaScript-Objekte im TypoScript definiert werden sollen, um sie später in JavaScript zu nutzen.

Anderes Anwendungsbeispiel: Man möchte die "normalen" JS-Syntax in einer ``.json``-Datei nutzen, statt dem JSON-Syntax.
Schauen wir uns ein Beispiel an. Dieser Text wurde in eine Textdatei geschrieben und soll per PHP geparsed werden:

.. code-block:: php

	// Inhalte einer Textdatei.
	{
	    beispiel: ['eins', 'zwei', 'drei']
	}

PHP würde bei diesem Beispiel mit ``json_decode()`` einen Fehler melden: Der String enthält Kommentare, Umbrüche und die Keys und Values sind nicht in doppelte Anführungszeichen eingeschlossen. Der JsonHelper bzw. der ViewHelper ``$jsonHelper->decode()`` kann es aber problemlos umwandeln.

So könnte man im TypoScript Setup ein JS-Object definieren:

.. code-block:: php

	// Inhalt im TS-Setup
	my_conf.data (
	  {
	     dots: true,
	     sizes: [1, 2, 3]
	  }
	)

Die Mischung irritiert ein wenig: ``my_conf.data (...)`` öffnet im TypoScript einen Abschnitt für mehrzeiligen Code.
Zwischen den ``(...)`` steht dann ein "normales" JavaScript-Object.
Das lässt sich im Fluid-Template dann einfach als Array nutzen:

.. code-block:: php

	{nnt3:ts.setup(path:'my_conf.data')->f:variable(name:'myConfig')}
	{myConfig->nnt3:parse.json()->f:debug()}

Oder als data-Attribut an ein Element hängen, um es später per JavaScript zu parsen:

.. code-block:: php

	{nnt3:ts.setup(path:'my_conf.data')->f:variable(name:'myConfig')}
	<div data-config="{myConfig->nnt3:parse.json()->nnt3:format.attrEncode()}">...</div>

Dieses Script basiert überwiegend auf der Arbeit von https://bit.ly/3eZuNu2 und
wurde von uns für PHP 7+ optimiert.Alles an Ruhm und Ehre bitte in diese Richtung.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::JsonHelper()->decode(``$str, $useArray = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Wandelt einen JS-Object-String in ein Array um.

.. code-block:: php

	$data = \Nng\Nnhelpers\Helpers\JsonHelper::decode( "{title:'Test', cat:[2,3,4]}" );
	print_r($data);

Die PHP-Funktion ``json_decode()`` funktioniert nur bei der JSON-Syntax: ``{"key":"value"}``. Im JSON sind weder Zeilenumbrüche, noch Kommentare erlaubt.
Mit dieser Funktion können auch Strings in der JavaScript-Schreibweise geparsed werden.

| ``@return array|string``

\\nn\\t3::JsonHelper()->encode(``$var``);
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert eine Variable ins JSON Format.
Relikt der ursprünglichen Klasse, vermutlich aus einer Zeit als es ``json_encode()`` noch nicht gab.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\JsonHelper::encode(['a'=>1, 'b'=>2]);

| ``@return string;``

\\nn\\t3::JsonHelper()->removeCommentsAndDecode(``$str, $useArray = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Entfernt Kommentare aus dem Code und parsed den String.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\JsonHelper::removeCommentsAndDecode( "// Kommentar\n{title:'Test', cat:[2,3,4]}" )

| ``@return array|string``

