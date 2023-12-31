.. include:: ../Includes.txt

.. _installation:

============
Installation
============

Nothing really special about the installation. Simply do, what you always do to get the extension up and running. 

**No need to add any TypoScript Templates.**

You love the Extension Manager?
-------------------------------
Press the Retrieve/Update button and search for the extension key `nnhelpers` and import the extension from the repository. Start coding. Have fun.

Nothing beats handwork?
-----------------------
You can always get current version from `https://extensions.typo3.org/extension/nnhelpers/ <https://extensions.typo3.org/extension/nnhelpers/>`_.
Download the t3x or zip version. Upload the file afterwards in the Extension Manager.

composer is your friend?
-------------------------
In case you are in a composer mode installation of typo3, you can require the latest release from packagist with

.. code-block:: bash

   composer require nng/nnhelpers


Want to git it?
-----------------------
You can get the latest version from bitbucket.org by using the git command:

.. code-block:: bash

   git clone https://bitbucket.org/99grad/nnhelpers/src/master/


Defining dependencies
========================

If you want to use `nnhelpers` in your own extension, make sure to define the dependeny in your `ext_emconf.php` and `composer.json`:

This goes in the `ext_emconf.php` of your extension:

.. code-block:: php

   $EM_CONF[$_EXTKEY] = [
      ...
      'constraints' => [
         'depends' => [
            'nnhelpers' => '1.7.0-0.0.0',
         ],
      ],
   ];

And this is the part for the `composer.json` of your extension:

.. code-block:: json

   {
      ...
      "require": {
         "nng/nnhelpers": "^1.6"
      },
   }