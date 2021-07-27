
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Video\EmbedUrlViewHelper:

=======================================
video.embedUrl
=======================================

Description
---------------------------------------

<nnt3:video.embedUrl />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Konvertiert eine youTube-URL in die watch-Variante, z.B. für die Einbindung in ein iFrame.

.. code-block:: php

	{my.videourl->nnt3:video.embedUrl()}

.. code-block:: php

	<iframe src="{my.videourl->nnt3:video.embedUrl()}"></iframe>

