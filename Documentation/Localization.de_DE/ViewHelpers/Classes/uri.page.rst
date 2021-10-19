
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Uri\PageViewHelper:

=======================================
uri.page
=======================================

Description
---------------------------------------

<nnt3:uri.page />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Erzeugt ein URL zu einer Seite im Frontend.
Entspricht fast exakt dem Typo3 ViewHelper ``{f:uri.page()}`` - kann allerdings auch in einem Kontext
verwendet werden, bei dem kein Frontend (``TSFE``) existiert, z.B. im Template eines Backend-Moduls oder in
Mail-Templates eines Scheduler-Jobs.

.. code-block:: php

	{nnt3:uri.page(pageUid:1, additionalParams:'...')}

