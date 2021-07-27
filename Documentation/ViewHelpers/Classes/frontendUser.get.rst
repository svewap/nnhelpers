
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\FrontendUser\GetViewHelper:

=======================================
frontendUser.get
=======================================

Description
---------------------------------------

<nnt3:frontendUser.get />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Get frontend user

Returns an array with the frontend user's data, e.g. to personalize pages, mails or content

.. code-block:: php

	{nnt3:frontendUser.get(key:'first_name')}
	{nnt3:frontendUser.get()->f:variable.set(name:'feUser')}

