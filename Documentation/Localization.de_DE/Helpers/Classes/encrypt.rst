
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

\\nn\\t3::Encrypt()->createJwtSignature(``$header = [], $payload = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Signatur für ein JWT (Json Web Token) erzeugen.
Die Signatur wird später als Teil des Tokens mit vom User übertragen.

.. code-block:: php

	$signature = \nn\t3::Encrypt()->createJwtSignature(['alg'=>'HS256', 'typ'=>'JWT'], ['test'=>123]);

| ``@param array $header``
| ``@param array $payload``
| ``@return string``

\\nn\\t3::Encrypt()->decode(``$data = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Entschlüsselt einen String oder ein Array.
Zum Verschlüsseln der Daten kann ``\nn\t3::Encrypt()->encode()`` verwendet werden.
Siehe ``\nn\t3::Encrypt()->encode()`` für ein komplettes Beispiel.

.. code-block:: php

	\nn\t3::Encrypt()->decode( '...' );

| ``@return string``

\\nn\\t3::Encrypt()->encode(``$data = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Verschlüsselt einen String oder ein Array.

Im Gegensatz zu ``\nn\t3::Encrypt()->hash()`` kann ein verschlüsselter Wert per ``\nn\t3::Encrypt()->decode()``
wieder entschlüsselt werden. Diese Methods eignet sich daher nicht, um sensible Daten wie z.B. Passworte
in einer Datenbank zu speichern. Dennoch ist der Schutz relativ hoch, da selbst identische Daten, die mit
dem gleichen Salting-Key verschlüsselt wurden, unterschiedlich aussehen.

Für die Verschlüsselung wird ein Salting Key generiert und in dem Extension Manager von ``nnhelpers`` gespeichert.
Dieser Key ist für jede Installation einmalig. Wird er verändert, dann können bereits verschlüsselte Daten nicht
wieder entschlüsselt werden.

.. code-block:: php

	\nn\t3::Encrypt()->encode( 'mySecretSomething' );
	\nn\t3::Encrypt()->encode( ['some'=>'secret'] );

Komplettes Beispiel mit Verschlüsselung und Entschlüsselung:

.. code-block:: php

	$encryptedResult = \nn\t3::Encrypt()->encode( ['password'=>'mysecretsomething'] );
	echo \nn\t3::Encrypt()->decode( $encryptedResult )['password'];
	
	$encryptedResult = \nn\t3::Encrypt()->encode( 'some_secret_phrase' );
	echo \nn\t3::Encrypt()->decode( $encryptedResult );

| ``@return string``

\\nn\\t3::Encrypt()->getHashInstance(``$passwordHash = '', $loginType = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gibt den Klassen-Names des aktuellen Hash-Algorithmus eines verschlüsselten Passwortes wieder,
z.B. um beim fe_user zu wissen, wie das Passwort in der DB verschlüsselt wurde.

.. code-block:: php

	\nn\t3::Encrypt()->getHashInstance('$P$CIz84Y3r6.0HX3saRwYg0ff5M0a4X1.');
	// => \TYPO3\CMS\Core\Crypto\PasswordHashing\PhpassPasswordHash

| ``@return class``

\\nn\\t3::Encrypt()->getSaltingKey();
"""""""""""""""""""""""""""""""""""""""""""""""

Holt den Enryption / Salting Key aus der Extension Konfiguration für ``nnhelpers``.
Falls im Extension Manager noch kein Key gesetzt wurde, wird er automatisch generiert
und in der ``LocalConfiguration.php`` gespeichert.

.. code-block:: php

	\nn\t3::Encrypt()->getSaltingKey();

| ``@return string``

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

\\nn\\t3::Encrypt()->hashSessionId(``$sessionId = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Session-Hash für ``fe_sessions.ses_id`` holen.
Enspricht dem Wert, der für den Cookie ``fe_typo_user`` in der Datenbank gespeichert wird.

In TYPO3 < v10 wird hier ein unveränderter Wert zurückgegeben. Ab TYPO3 v10 wird die Session-ID im
Cookie ``fe_typo_user`` nicht mehr direkt in der Datenbank gespeichert, sondern gehashed.
Siehe: ``TYPO3\CMS\Core\Session\Backend\DatabaseSessionBackend->hash()``.

.. code-block:: php

	\nn\t3::Encrypt()->hashSessionId( $sessionIdFromCookie );

Beispiel:

.. code-block:: php

	$cookie = $_COOKIE['fe_typo_user'];
	$hash = \nn\t3::Encrypt()->hashSessionId( $cookie );
	$sessionFromDatabase = \nn\t3::Db()->findOneByValues('fe_sessions', ['ses_id'=>$hash]);

Wird unter anderen verwendet von: ``\nn\t3::FrontendUserAuthentication()->loginBySessionId()``.

| ``@return string``

\\nn\\t3::Encrypt()->jwt(``$payload = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein JWT (Json Web Token) erzeugen, signieren und ``base64``-Encoded zurückgeben.

Nicht vergessen: Ein JWT ist zwar "fälschungssicher", weil der Signatur-Hash nur mit
dem korrekten Key/Salt erzeugt werden kann – aber alle Daten im JWT sind für jeden
durch ``base64_decode()`` einsehbar. Ein JWT eignet sich keinesfalls, um sensible Daten wie
Passwörter oder Logins zu speichern!

.. code-block:: php

	\nn\t3::Encrypt()->jwt(['test'=>123]);

| ``@param array $payload``
| ``@return string``

\\nn\\t3::Encrypt()->parseJwt(``$token = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein JWT (Json Web Token) parsen und die Signatur überprüfen.
Falls die Signatur valide ist (und damit der Payload nicht manipuliert wurde), wird der
Payload zurückgegeben. Bei ungültiger Signatur wird ``FALSE`` zurückgegeben.

.. code-block:: php

	\nn\t3::Encrypt()->parseJwt('adhjdf.fsdfkjds.HKdfgfksfdsf');

| ``@param string $token``
| ``@return array|false``

\\nn\\t3::Encrypt()->password(``$clearTextPassword = '', $context = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Hashing eines Passwortes nach Typo3-Prinzip.
Anwendung: Passwort eines fe_users in der Datenbank überschreiben

.. code-block:: php

	\nn\t3::Encrypt()->password('99grad');

| ``@return string``

