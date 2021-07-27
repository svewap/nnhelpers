
.. include:: ../../Includes.txt

.. _Mail:

==============================================
Mail
==============================================

\\nn\\t3::Mail()
----------------------------------------------

Helferlein für den Mailversand

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Mail()->send(``$paramOverrides = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine E-Mail senden.

.. code-block:: php

	$html = \nn\t3::Template()->render('MailTemplate', ['varKey'=>'varValue'], 'tx_extname_plugin');
	
	\nn\t3::Mail()->send([
	    'html'          => $html,
	    'plaintext'     => Optional: Text-Version
	    'fromEmail'     => Absender-Email
	    'fromName'      => Absender-Name
	    'toEmail'       => Empfänger-Email
	    'subject'       => Betreff
	    'attachments'   => [...],
	    'emogrify'      => CSS-Stile in Inline-Styles umwandeln (default: `true`)
	    'absPrefix'     => Relative Pfade in absolute umwandeln (default: `true`)
	]);

Bilder einbetten mit    ``<img data-embed="1" src="..." />``
Dateianhänge mit        ``<a data-embed="1" href="..." />``
| ``@return void``

