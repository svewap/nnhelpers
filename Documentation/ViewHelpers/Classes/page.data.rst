
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Page\DataViewHelper:

=======================================
page.data
=======================================

Description
---------------------------------------

<nnt3:page.data />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Simplifies access to data from the ``pages`` table

.. code-block:: php

	{nnt3:page.data(key:'nnp_contact', slide:1)}
	{nnt3:page.data(key:'backend_layout_next_level', slide:1, override:'backend_layout')}

Important to make ``slide`` work: If a custom field has been added to the ``pages`` table, the field must first be registered in ``ext_localconf.php``.

.. code-block:: php

	\nn\t3::Registry()->rootLineFields(['logo']);

