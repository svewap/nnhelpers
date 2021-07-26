
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Video\EmbedUrlViewHelper:

=======================================
video.embedUrl
=======================================

Description
---------------------------------------

<nnt3:video.embedUrl />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Converts a youTube URL to the watch variant, e.g. for embedding in an iFrame.

.. code-block:: php

	{my.videourl->nnt3:video.embedUrl()}

.. code-block:: php

	<iframe src="{my.videourl->nnt3:video.embedUrl()}"></iframe>

