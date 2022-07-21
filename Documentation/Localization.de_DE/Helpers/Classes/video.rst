
.. include:: ../../Includes.txt

.. _Video:

==============================================
Video
==============================================

\\nn\\t3::Video()
----------------------------------------------

Alles, was zum Thema Videos wichtig und hilfreich ist.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Video()->getEmbedUrl(``$type, $videoId = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einbettungs-URL anhand der Streaming-Plattform zurückgeben.
Klassischerweise die URL, die im src-Attribut des <iframe>
verwendet wird.

.. code-block:: php

	\nn\t3::Video()->getEmbedUrl( 'youtube', 'nShlloNgM2E' );
	\nn\t3::Video()->getEmbedUrl( 'https://www.youtube.com/watch?v=wu55ZG97zeI&feature=youtu.be' );

Existiert auch als ViewHelper:

.. code-block:: php

	{my.videourl->nnt3:video.embedUrl()}

| ``@return string``

\\nn\\t3::Video()->getExternalType(``$url = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt ein Array mit Infos über die Streaming-Platform und Code zum Einbetten eines Videos zurück.

.. code-block:: php

	\nn\t3::Video()->getExternalType( 'https://www.youtube.com/watch/abTAgsdjA' );

| ``@return array``

\\nn\\t3::Video()->getWatchUrl(``$type, $videoId = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Link-URL zum Video auf der externen Plattform
z.B. um einen externen Link zum Video darzustellen

.. code-block:: php

	\nn\t3::Video()->getWatchUrl( $fileReference );
	\nn\t3::Video()->getWatchUrl( 'youtube', 'nShlloNgM2E' );
	\nn\t3::Video()->getWatchUrl( 'https://www.youtube.com/watch?v=wu55ZG97zeI&feature=youtu.be' );
	
	// => https://www.youtube-nocookie.com/watch?v=kV8v2GKC8WA

| ``@return string``

\\nn\\t3::Video()->isExternal(``$url = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob es sich bei der URL um ein externes Video auf YouTube oder Vimeo handelt.
Gibt ein Array mit Daten zum Einbetten zurück.

.. code-block:: php

	\nn\t3::Video()->isExternal( 'https://www.youtube.com/...' );

| ``@return array``

