
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Uri\PageViewHelper:

=======================================
uri.page
=======================================

Description
---------------------------------------

<nnt3:uri.page />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Creates a URL to a page in the frontend.
Corresponds almost exactly to the Typo3 ViewHelper ``{f:uri.page()}`` - but can also be used in a context where no frontend (``TSFE``) exists.
where no frontend (``TSFE``) exists, e.g. in the template of a backend module or in
Mail templates of a scheduler job.

.. code-block:: php

	{nnt3:uri.page(pageUid:1, additionalParams:'...')}

