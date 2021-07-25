
.. include:: ../Includes.txt

.. _Encrypt:

============
Encrypt
============

\\nn\\t3::Encrypt()
---------------

Encrypting and hashing passwords

Overview of Methods
~~~~~~~~~~~~~~~~

\\nn\\t3::Encrypt()->hash(``$string = ''``);
""""""""""""""""

Simple hashing, such as when checking a uid against a hash.

.. code-block:: php

	\nn\t3::Encrypt()->hash( $uid );

Also acts as a ViewHelper:

.. code-block:: php

	{something->nnt3:encrypt.hash()}

| ``@return string``

\\nn\\t3::Encrypt()->password(``$clearTextPassword = '', $context = 'FE'``);
""""""""""""""""

Hashing of a password according to Typo3 principle.
Application: Password of a fe_user in the database

.. code-block:: php

	\nn\t3::Encrypt()->password('99degree');

| ``@return string``

\\nn\\t3::Encrypt()->checkPassword(``$password = '', $passwordHash = NULL``);
""""""""""""""""

Checks if hash of a password and a password ümatch.
Application: compare the password hash of a fe_user in the database with a given password.

.. code-block:: php

	\nn\t3::Encrypt()->checkPassword('99grad', '$1$wtnFi81H$mco6DrrtdeqiziRJyisdK1.');

| ``@return boolean``

