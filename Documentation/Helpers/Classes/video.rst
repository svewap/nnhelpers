
.. include:: ../../Includes.txt

.. _Video:

==============================================
Video
==============================================

\\nn\\t3::Video()
----------------------------------------------

Everything that is important and helpful on the subject of videos.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Video()->getEmbedUrl(``$type, $videoId = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Return embed URL based on the streaming platform.
Classically, the URL used in the src attribute of the <iframe>
is used.

.. code-block:: php

	\nn\t3::Video()->getEmbedUrl( 'youtube', 'nShlloNgM2E' );
	\nn\t3::Video()->getEmbedUrl( 'https://www.youtube.com/watch?v=wu55ZG97zeI&feature=youtu.be' );

Also acts as a ViewHelper:

.. code-block:: php

	{my.videourl->nnt3:video.embedUrl()}

| ``@return string``

\\nn\\t3::Video()->getExternalType(``$url = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns an array with info about the streaming platform and code to embed a video

.. code-block:: php

	\nn\t3::Video()->getExternalType( 'https://www.youtube.com/watch/abTAgsdjA' );

| ``@return array``

\\nn\\t3::Video()->getWatchUrl(``$type, $videoId = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Link URL to the video on the external platform.
E.g. to display an external link to the video

.. code-block:: php

	\nn\t3::Video()->getWatchUrl( $fileReference );
	\nn\t3::Video()->getWatchUrl( 'youtube', 'nShlloNgM2E' );
	\nn\t3::Video()->getWatchUrl( 'https://www.youtube.com/watch?v=wu55ZG97zeI&feature=youtu.be' );
	
	// => https://www.youtube-nocookie.com/watch?v=kV8v2GKC8WA

| ``@return string``

\\nn\\t3::Video()->isExternal(``$url = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Perceives whether the URL is an external video on YouTube or Vimeo.
Returns an array with data to embed.

.. code-block:: php

	\nn\t3::Video()->isExternal( 'https://www.youtube.com/...' );

| ``@return array``

