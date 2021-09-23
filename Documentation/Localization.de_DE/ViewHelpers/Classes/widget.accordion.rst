
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Widget\AccordionViewHelper:

=======================================
widget.accordion
=======================================

Description
---------------------------------------

<nnt3:widget.accordion />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Widget zur Darstellung eines Akkordeons.

Wird in ``nnhelpers`` massenhaft in den Templates des Backend-Moduls genutzt.

.. code-block:: php

	<nnt3:widget.accordion title="Titel" icon="fas fa-plus" class="nice-thing">
	  ...
	</nnt3:widget.accordion>

.. code-block:: php

	<nnt3:widget.accordion template="EXT:myext/path/to/template.html" title="Titel" icon="fas fa-plus" class="nice-thing">
	  ...
	</nnt3:widget.accordion>

.. code-block:: php

	{nnt3:widget.accordion(title:'Titel', content:'...' icon:'fas fa-plus', class:'nice-thing')}

| ``@return string``

