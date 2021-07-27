
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\ContentElementViewHelper:

=======================================
contentElement
=======================================

Description
---------------------------------------

<nnt3:contentElement />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Render a content element

The ViewHelper we probably use most.

Render a content element from the ``tt_content`` table with the ``uid: 123``.

.. code-block:: php

	{nnt3:contentElement(uid:123)}

Replace variables in rendered content element.
Allows you to create a content element in the backend that works with fluid variables – for example, for a mail template where you want the recipient name to appear in the text.

.. code-block:: php

	{nnt3:contentElement(uid:123, data:'{greeting:\'Hello!\'}')}
	{nnt3:contentElement(uid:123, data:feUser.data)}

To render the variables, it is not mandatory to pass a ``contentUid`` übergeben. HTML code can also be parsed directly:

.. code-block:: php

	{data.bodytext->nnt3:contentElement(data:'{greeting:\'Hello!\'}')}

| ``@return string``

