
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\FlashMessagesViewHelper:

=======================================
flashMessages
=======================================

Description
---------------------------------------

<nnt3:flashMessages />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Gibt eine Flash-Message aus.

Im Controller:

.. code-block:: php

	\nn\t3::Message()->OK('Titel', 'Infotext');
	\nn\t3::Message()->setId('oben')->ERROR('Titel', 'Infotext');

Im Fluid:

.. code-block:: php

	<nnt3:flashMessages />
	<nnt3:flashMessages id='oben' />

Die Core-Funktionen:

.. code-block:: php

	<f:flashMessages queueIdentifier='core.template.flashMessages' />
	<f:flashMessages queueIdentifier='oben' />

| ``@return string``

