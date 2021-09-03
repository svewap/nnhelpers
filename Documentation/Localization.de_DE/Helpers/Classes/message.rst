
.. include:: ../../Includes.txt

.. _Message:

==============================================
Message
==============================================

\\nn\\t3::Message()
----------------------------------------------

Vereinfacht die Verwendung der FlashMessages.

Im Backend: FlashMessages werden automatisch ganz oben ausgegeben

.. code-block:: php

	\nn\t3::Message()->OK('Titel', 'Infotext');
	\nn\t3::Message()->ERROR('Titel', 'Infotext');

Im Frontend: FlashMessages können über ViewHelper ausgegeben werden

.. code-block:: php

	\nn\t3::Message()->OK('Titel', 'Infotext');
	<nnt3:flashMessages />
	<f:flashMessages queueIdentifier='core.template.flashMessages' />
	
	\nn\t3::Message()->setId('oben')->OK('Titel', 'Infotext');
	<nnt3:flashMessages id='oben' />
	<f:flashMessages queueIdentifier='oben' />

... oder als HTML gerendert und zurückgegeben werden:

.. code-block:: php

	echo \nn\t3::Message()->render('oben');
	echo \nn\t3::Message()->render();

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Message()->ERROR(``$title = '', $text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt eine "ERROR" Flash-Message aus

.. code-block:: php

	\nn\t3::Message()->ERROR('Titel', 'Infotext');

| ``@return void``

\\nn\\t3::Message()->OK(``$title = '', $text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt eine "OK" Flash-Message aus

.. code-block:: php

	\nn\t3::Message()->OK('Titel', 'Infotext');

| ``@return void``

\\nn\\t3::Message()->WARNING(``$title = '', $text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt eine "WARNING" Flash-Message aus

.. code-block:: php

	\nn\t3::Message()->WARNING('Titel', 'Infotext');

| ``@return void``

\\nn\\t3::Message()->flash(``$title = '', $text = '', $type = 'OK', $queueID = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Speichert eine Flash-Message in den Message-Queue für Frontend oder Backend.
| ``@return void``

\\nn\\t3::Message()->flush(``$queueID = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Löscht alle Flash-Messages
Optional kann eine Queue-ID angegeben werden.

.. code-block:: php

	\nn\t3::Message()->flush('oben');
	\nn\t3::Message()->flush();

| ``@return array``

\\nn\\t3::Message()->render(``$queueID = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Rendert die Flash-Messages in der Queue
Simples Beispiel:

.. code-block:: php

	\nn\t3::Message()->OK('Ja', 'Nein');
	echo \nn\t3::Message()->render();

Beispiel mit einer Queue-ID:

.. code-block:: php

	\nn\t3::Message()->setId('oben')->OK('Ja', 'Nein');
	echo \nn\t3::Message()->render('oben');

Ausgabe im Fluid über den ViewHelper:

.. code-block:: php

	<nnt3:flashMessages id="oben" />
	{nnt3:flashMessages()}

| ``@return string``

\\nn\\t3::Message()->setId(``$name = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Legt fest, welcher MessageQueue verwendet werden soll

.. code-block:: php

	\nn\t3::Message()->setId('oben')->OK('Titel', 'Infotext');

Ausgabe in Fluid per ViewHelper:

.. code-block:: php

	<nnt3:flashMessages id="oben" />
	{nnt3:flashMessages(id:'oben')}

| ``@return void``

