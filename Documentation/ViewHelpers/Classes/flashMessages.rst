
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\FlashMessagesViewHelper:

=======================================
flashMessages
=======================================

Description
---------------------------------------

<nnt3:flashMessages />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Emits a flash message.

In the controller:

.. code-block:: php

	\nn\t3::Message()->OK('Title', 'Infotext');
	\nn\t3::Message()->setId('top')->ERROR('title', 'infotext');

In Fluid:

.. code-block:: php

	<nnt3:flashMessages />
	<nnt3:flashMessages id='top' />

The core functions:

.. code-block:: php

	<f:flashMessages queueIdentifier='core.template.flashMessages' />
	<f:flashMessages queueIdentifier='top' />

| ``@return string``

