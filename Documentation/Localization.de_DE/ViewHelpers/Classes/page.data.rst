
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Page\DataViewHelper:

=======================================
page.data
=======================================

Description
---------------------------------------

<nnt3:page.data />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Vereinfacht den Zugriff auf Daten aus der Tabelle ``pages``.

.. code-block:: php

	{nnt3:page.data(key:'nnp_contact', slide:1)}
	{nnt3:page.data(key:'backend_layout_next_level', slide:1, override:'backend_layout')}

Wichtig, damit ``slide`` funktioniert: Falls die Tabelle ``pages`` um ein eigenes Feld erweitert wurde, muss das Feld vorher in der ``ext_localconf.php`` registriert werden.

.. code-block:: php

	\nn\t3::Registry()->rootLineFields(['logo']);

