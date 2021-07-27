
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

\\nn\\t3::Encrypt()->hash(``$string = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einfaches Hashing, z.B. beim Check einer uid gegen ein Hash.

.. code-block:: php

	\nn\t3::Encrypt()->hash( $uid );

Existiert auch als ViewHelper:

.. code-block:: php

	{something->nnt3:encrypt.hash()}

| ``@return string``

\\nn\\t3::Encrypt()->password(``$clearTextPassword = '', $context = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Hashing eines Passwortes nach Typo3-Prinzip.
Anwendung: Passwort eines fe_users in der Datenbank überschreiben

.. code-block:: php

	\nn\t3::Encrypt()->password('99grad');

| ``@return string``

