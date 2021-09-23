
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Widget\AccordionViewHelper:

=======================================
widget.accordion
=======================================

Description
---------------------------------------

<nnt3:widget.accordion />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Widget to display an accordion.

Used in ``nnhelpers`` en masse in the backend module templates.

.. code-block:: php

	<nnt3:widget.accordion title="title" icon="fas fa-plus" class="nice-thing">
	  ...
	</nnt3:widget.accordion>

.. code-block:: php

	<nnt3:widget.accordion template="EXT:myext/path/to/template.html" title="Title" icon="fas fa-plus" class="nice-thing">
	  ...
	</nnt3:widget.accordion>

.. code-block:: php

	{nnt3:widget.accordion(title:'title', content:'...' icon:'fas fa-plus', class:'nice-thing')}

| ``@return string``

