
.. include:: ../../Includes.txt

.. _Encrypt:

==============================================
Encrypt
==============================================

\\nn\\t3::Encrypt()
----------------------------------------------

Encrypting and hashing passwords

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Encrypt()->checkPassword(``$password = '', $passwordHash = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Checks if hash of a password and a password ümatch.
Application: compare the password hash of a fe_user in the database with a given password.

.. code-block:: php

	\nn\t3::Encrypt()->checkPassword('99grad', '$1$wtnFi81H$mco6DrrtdeqiziRJyisdK1.');

| ``@return boolean``

\\nn\\t3::Encrypt()->getHashInstance(``$passwordHash = '', $loginType = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the class name of the current hash algorithm of an encrypted password,
e.g., to know at fe_user how the password was encrypted in the DB.

.. code-block:: php

	\nn\t3::Encrypt()->getHashInstance('$P$CIz84Y3r6.0HX3saRwYg0ff5M0a4X1.');
	// => \TYPO3\CMS\Core\Crypto\PasswordHashing\PhpassPasswordHash

| ``@return class``

\\nn\\t3::Encrypt()->hash(``$string = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Simple hashing, such as when checking a uid against a hash.

.. code-block:: php

	\nn\t3::Encrypt()->hash( $uid );

Also acts as a ViewHelper:

.. code-block:: php

	{something->nnt3:encrypt.hash()}

| ``@return string``

\\nn\\t3::Encrypt()->hashNeedsUpdate(``$passwordHash = '', $loginType = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Check if the hash needs to be updated because it does not match the current encryption algorithm.
When updating Typo3 to a new LTS, the hashing algorithm of the passwords in the database is also often
is improved. This method checks if the given hash is still up to date or needs to be updated.

Returns ``true`` if an update is required.

.. code-block:: php

	\nn\t3::Encrypt()->hashNeedsUpdate('$P$CIz84Y3r6.0HX3saRwYg0ff5M0a4X1.'); // true

An automatic password update could look like this in a manual FE user authentication service:

.. code-block:: php

	$uid = $user['uid']; // uid of the FE user.
	$authResult = \nn\t3::Encrypt()->checkPassword( $passwordHashInDatabase, $clearTextPassword );
	if ($authResult & \nn\t3::Encrypt()->hashNeedsUpdate( $passwordHashInDatabase )) {
	    \nn\t3::FrontendUserAuthentication()->setPassword( $uid, $clearTextPassword );
	}

| ``@return boolean``

\\nn\\t3::Encrypt()->password(``$clearTextPassword = '', $context = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Hashing of a password according to Typo3 principle.
Application: Password of a fe_user in the database

.. code-block:: php

	\nn\t3::Encrypt()->password('99degree');

| ``@return string``

