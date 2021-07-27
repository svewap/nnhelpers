
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Page\TitleViewHelper:

=======================================
page.title
=======================================

Description
---------------------------------------

<nnt3:page.title />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Set current page title.

Changes the ``<title>`` tag of the current page.

Does not work if ``EXT:advancedtitle`` is enabled!

.. code-block:: php

	{nnt3:page.title(title:'page-title')}
	{entry.title->nnt3:page.title()}

