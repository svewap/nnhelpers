
.. include:: ../../Includes.txt

.. _Encrypt:

==============================================
Encrypt
==============================================

\\nn\\t3::Encrypt()
----------------------------------------------

Verschlüsseln und Hashen von Passworten

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Encrypt()->checkPassword(``$password = '', $passwordHash = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob Hash eines Passwortes und ein Passwort übereinstimmen.
Anwendung: Passwort-Hash eines fe_users in der Datenbank mit übergebenem Passwort
vergleichen.

.. code-block:: php

	\nn\t3::Encrypt()->checkPassword('99grad', '$1$wtnFi81H$mco6DrrtdeqiziRJyisdK1.');

| ``@return boolean``

\\nn\\t3::Encrypt()->getHashInstance(``$passwordHash = '', $loginType = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt den Klassen-Names des aktuellen Hash-Algorithmus eines verschlüsselten Passwortes wieder,
z.B. um beim fe_user zu wissen, wie das Passwort in der DB verschlüsselt wurde.

.. code-block:: php

	\nn\t3::Encrypt()->getHashInstance('$P$CIz84Y3r6.0HX3saRwYg0ff5M0a4X1.');
	// => \TYPO3\CMS\Core\Crypto\PasswordHashing\PhpassPasswordHash

| ``@return class``

\\nn\\t3::Encrypt()->hash(``$string = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einfaches Hashing, z.B. beim Check einer uid gegen ein Hash.

.. code-block:: php

	\nn\t3::Encrypt()->hash( $uid );

Existiert auch als ViewHelper:

.. code-block:: php

	{something->nnt3:encrypt.hash()}

| ``@return string``

\\nn\\t3::Encrypt()->hashNeedsUpdate(``$passwordHash = '', $loginType = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob Hash aktualisiert werden muss, weil er nicht dem aktuellen Verschlüsselungs-Algorithmus enspricht.
Beim Update von Typo3 in eine neue LTS wird gerne auch der Hashing-Algorithmus der Passwörter in der Datenbank
verbessert. Diese Methode prüft, ob der übergebene Hash noch aktuell ist oder aktualisert werden muss.

Gibt ``true`` zurück, falls ein Update erforderlich ist.

.. code-block:: php

	\nn\t3::Encrypt()->hashNeedsUpdate('$P$CIz84Y3r6.0HX3saRwYg0ff5M0a4X1.');    // true

Ein automatisches Update des Passwortes könnte in einem manuellen FE-User Authentification-Service so aussehen:

.. code-block:: php

	$uid = $user['uid'];    // uid des FE-Users
	$authResult = \nn\t3::Encrypt()->checkPassword( $passwordHashInDatabase, $clearTextPassword );
	if ($authResult & \nn\t3::Encrypt()->hashNeedsUpdate( $passwordHashInDatabase )) {
	    \nn\t3::FrontendUserAuthentication()->setPassword( $uid, $clearTextPassword );
	}

| ``@return boolean``

\\nn\\t3::Encrypt()->password(``$clearTextPassword = '', $context = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Hashing eines Passwortes nach Typo3-Prinzip.
Anwendung: Passwort eines fe_users in der Datenbank überschreiben

.. code-block:: php

	\nn\t3::Encrypt()->password('99grad');

| ``@return string``

