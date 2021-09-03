
.. include:: ../../Includes.txt

.. _Message:

==============================================
Message
==============================================

\\nn\\t3::Message()
----------------------------------------------

Simplifies the use of FlashMessages.

On the backend: FlashMessages are automatically output at the top

.. code-block:: php

	\nn\t3::Message()->OK('Title', 'Infotext');
	\nn\t3::Message()->ERROR('Title', 'Infotext');

In the frontend: FlashMessages can be issued via ViewHelper

.. code-block:: php

	\nn\t3::Message()->OK('Title', 'Infotext');
	<nnt3:flashMessages />
	<f:flashMessages queueIdentifier='core.template.flashMessages' />
	
	\nn\t3::Message()->setId('top')->OK('title', 'info text');
	<nnt3:flashMessages id='top' />
	<f:flashMessages queueIdentifier='top' />

... or rendered as HTML and returned:

.. code-block:: php

	echo \nn\t3::Message()->render('top');
	echo \nn\t3::Message()->render();

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Message()->ERROR(``$title = '', $text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Emits an "ERROR" flash message

.. code-block:: php

	\nn\t3::Message()->ERROR('Title', 'Infotext');

| ``@return void``

\\nn\\t3::Message()->OK(``$title = '', $text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Emits an "OK" flash message

.. code-block:: php

	\nn\t3::Message()->OK('Title', 'Infotext');

| ``@return void``

\\nn\\t3::Message()->WARNING(``$title = '', $text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Emits a "WARNING" flash message

.. code-block:: php

	\nn\t3::Message()->WARNING('Title', 'Infotext');

| ``@return void``

\\nn\\t3::Message()->flash(``$title = '', $text = '', $type = 'OK', $queueID = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Saves a flash message to the message queue for frontend or backend.
| ``@return void``

\\nn\\t3::Message()->flush(``$queueID = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löll all flash messages.
Optionally, a queue ID can be specified.

.. code-block:: php

	\nn\t3::Message()->flush('above');
	\nn\t3::Message()->flush();

| ``@return array``

\\nn\\t3::Message()->render(``$queueID = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Renders the flash messages in the queue.
Simple example:

.. code-block:: php

	\nn\t3::Message()->OK('Yes', 'No');
	echo \nn\t3::Message()->render();

Example with a queue ID:

.. code-block:: php

	\nn\t3::Message()->setId('above')->OK('Yes', 'No');
	echo \nn\t3::Message()->render('top');

Output in the fluid üvia the ViewHelper:

.. code-block:: php

	<nnt3:flashMessages id="top" />
	{nnt3:flashMessages()}

| ``@return string``

\\nn\\t3::Message()->setId(``$name = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Determines which MessageQueue to use

.. code-block:: php

	\nn\t3::Message()->setId('top')->OK('title', 'infotext');

Output to Fluid via ViewHelper:

.. code-block:: php

	<nnt3:flashMessages id="top" />
	{nnt3:flashMessages(id:'top')}

| ``@return void``

