
.. include:: ../../Includes.txt

.. _Mail:

==============================================
Mail
==============================================

\\nn\\t3::Mail()
----------------------------------------------

Helper for the mail dispatch

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Mail()->send(``$paramOverrides = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Send an email.

.. code-block:: php

	$html = \nn\t3::Template()->render('MailTemplate', ['varKey'=>'varValue'], 'tx_extname_plugin');
	
	\nn\t3::Mail()->send([
	    'html' => $html,
	    'plaintext' => Optional: text version
	    'fromEmail' => Sender email
	    'fromName' => Sender name
	    'toEmail' => Recipient email
	    'subject' => Subject
	    'attachments' => [..,]
	    'emogrify' => convert CSS styles to inline styles (default: `true`)
	    'absPrefix' => Convert relative paths to absolute (default: `true`)
	]);

Embed images with ``<img data-embed="1" src="..." />``
File attachments with ``<a data-embed="1" href="..." />``
| ``@return void``

