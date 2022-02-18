
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

\\nn\\t3::Encrypt()->createJwtSignature(``$header = [], $payload = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Create a signature for a JWT (Json Web Token).
The signature is later transmitted as part of the token by the user.

.. code-block:: php

	$signature = \nn\t3::Encrypt()->createJwtSignature(['alg'=>'HS256', 'type'=>'JWT'], ['test'=>123]);

| ``@param array $header``
| ``@param array $payload``
| ``@return string``

\\nn\\t3::Encrypt()->decode(``$data = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Encrypts a string or an array.
To encrypt the data, ``\nn\t3::Encrypt()->encode()`` can be used.
See ``\nn\t3::Encrypt()->encode()`` for a complete example.

.. code-block:: php

	\nn\t3::Encrypt()->decode( '...' );

| ``@return string``

\\nn\\t3::Encrypt()->encode(``$data = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Encrypt a string or array.

Unlike ``\nn\t3::Encrypt()->hash()``, an encrypted value can be decrypted by ``\nn\t3::Encrypt()->decode()``
can be decrypted again. This method is therefore not suitable for storing sensitive data such as passwords
in a database. Nevertheless, the protection is relatively high, as even identical data encrypted with
encrypted with the same salting key will look different.

For encryption, a salting key is generated and stored in the extension manager of ``nnhelpers``
This key is unique for each installation. If it is changed, then already encrypted data cannot be decrypted again.
be decrypted again.

.. code-block:: php

	\nn\t3::Encrypt()->encode( 'mySecretSomething' );
	\nn\t3::Encrypt()->encode( ['some'=>'secret'] );

Complete example with encryption and decryption:

.. code-block:: php

	$encryptedResult = \nn\t3::Encrypt()->encode( ['password'=>'mysecretsomething'] );
	echo \nn\t3::Encrypt()->decode( $encryptedResult )['password'];
	
	$encryptedResult = \nn\t3::Encrypt()->encode( 'some_secret_phrase' );
	echo \nn\t3::Encrypt()->decode( $encryptedResult );

| ``@return string``

\\nn\\t3::Encrypt()->getHashInstance(``$passwordHash = '', $loginType = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the class name of the current hash algorithm of an encrypted password,
e.g., to know at fe_user how the password was encrypted in the DB.

.. code-block:: php

	\nn\t3::Encrypt()->getHashInstance('$P$CIz84Y3r6.0HX3saRwYg0ff5M0a4X1.');
	// => \TYPO3\CMS\Core\Crypto\PasswordHashing\PhpassPasswordHash

| ``@return class``

\\nn\\t3::Encrypt()->getSaltingKey();
"""""""""""""""""""""""""""""""""""""""""""""""

Gets the enryption / salting key from the extension configuration for ``nnhelpers``
If no key has been set in the extension manager yet, it will be generated automatically
and stored in the ``LocalConfiguration.php``.

.. code-block:: php

	\nn\t3::Encrypt()->getSaltingKey();

| ``@return string``

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

\\nn\\t3::Encrypt()->hashSessionId(``$sessionId = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get session hash for ``fe_sessions.ses_id``
Corresponds to the value stored in the database for the cookie ``fe_typo_user``

In TYPO3 fe_typo_user is no longer stored directly in the database, but hashed.
See: ``TYPO3\CMS\Core\Session\Backend\DatabaseSessionBackend->hash()``.

.. code-block:: php

	\nn\t3::Encrypt()->hashSessionId( $sessionIdFromCookie );

Example:

.. code-block:: php

	$cookie = $_COOKIE['fe_typo_user'];
	$hash = \nn\t3::Encrypt()->hashSessionId( $cookie );
	$sessionFromDatabase = \nn\t3::Db()->findOneByValues('fe_sessions', ['ses_id'=>$hash]);

Used by, among others: ``nn\t3::FrontendUserAuthentication()->loginBySessionId()``.

| ``@return string``
.

\\nn\\t3::Encrypt()->jwt(``$payload = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Create a JWT (Json Web Token), sign it, and return it ``base64`` encoded.

Don't forget: A JWT is "fälschungssicher", because the signature hash only with
with the correct key/salt – but all data in the JWT is für anyone.
by ``base64_decode()``. A JWT is in no way suitable for storing sensitive data such as
passwords or logins!

.. code-block:: php

	\nn\t3::Encrypt()->jwt(['test'=>123]);

| ``@param array $payload``
| ``@return string``

\\nn\\t3::Encrypt()->parseJwt(``$token = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Parse a JWT (Json Web Token) and check the signature.
If the signature is valid (and thus the payload has not been tampered with), the
payload is returned. If the signature is invalid, ``FALSE`` is returned.

.. code-block:: php

	\nn\t3::Encrypt()->parseJwt('adhjdf.fsdfkjds.HKdfgfksfdsf');

| ``@param string $token``
| ``@return array|false``

\\nn\\t3::Encrypt()->password(``$clearTextPassword = '', $context = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Hashing of a password according to Typo3 principle.
Application: Password of a fe_user in the database

.. code-block:: php

	\nn\t3::Encrypt()->password('99degree');

| ``@return string``

