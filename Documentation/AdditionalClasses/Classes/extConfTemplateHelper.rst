
.. include:: ../../Includes.txt

.. _ExtConfTemplateHelper:

==============================================
ExtConfTemplateHelper
==============================================

\\nn\\t3::ExtConfTemplateHelper()
----------------------------------------------

Extension for the extension manager form.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::ExtConfTemplateHelper()->textfield(``$conf = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Show multiline textbox/textarea in extension manager configurator.
Use this line in ``ext_conf_template.txt`` of your own extension:

.. code-block:: php

	# cat=basic; type=user[Nng\Nnhelpers\Helpers\ExtConfTemplateHelper->textfield]; label=my label.
	myfieldName =

| ``@return string``

