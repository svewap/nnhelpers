
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Encrypt\HashViewHelper:

=======================================
encrypt.hash
=======================================

Description
---------------------------------------

<nnt3:encrypt.hash />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Generates a hash from a string or number.

.. code-block:: php

	{secret->nnt3:encrypt.hash()}
	{nnt3:encrypt(value:secret)}

Helpful if, for example, a mail is to be sent with confirmation link.

The UID of the record is also passed as a hash. The controller then checks üft,
whether the ``hash`` can be generated from the ``uid``
If not, the ``uid`` has been tampered with.

.. code-block:: php

	<f:link.action action="validate" arguments="{uid:uid, checksum:'{uid->nnt3:encrypt.hash()}'}">
	  ...
	</f:link.action>

| ``@return string``

