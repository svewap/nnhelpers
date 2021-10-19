
.. include:: ../../Includes.txt

.. _ExtConfTemplateHelper:

==============================================
ExtConfTemplateHelper
==============================================

\\nn\\t3::ExtConfTemplateHelper()
----------------------------------------------

Erweiterung für das Formular des Extension-Managers.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::ExtConfTemplateHelper()->textfield(``$conf = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Mehrzeiliges Textfeld / Textarea im Extension Manager Konfigurator zeigen.
Diese Zeile in ``ext_conf_template.txt`` der eigenen Extension nutzen:

.. code-block:: php

	# cat=basic; type=user[Nng\Nnhelpers\Helpers\ExtConfTemplateHelper->textfield]; label=Mein Label
	meinFeldName =

| ``@return string``

