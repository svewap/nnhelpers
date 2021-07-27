
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\FrontendUser\GetViewHelper:

=======================================
frontendUser.get
=======================================

Description
---------------------------------------

<nnt3:frontendUser.get />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Frontend-User holen

Gibt ein Array mit den Daten des Frontend-Users zurück, z.B. um Seiten, Mails oder Inhalte zu personalisieren.

.. code-block:: php

	{nnt3:frontendUser.get(key:'first_name')}
	{nnt3:frontendUser.get()->f:variable.set(name:'feUser')}

