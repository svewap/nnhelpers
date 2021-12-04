
.. include:: ../../Includes.txt

.. _Errors:

==============================================
Errors
==============================================

\\nn\\t3::Errors()
----------------------------------------------

Fehler und Exceptions ausgeben

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Errors()->Error(``$message, $code = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Einen Error werfen mit Backtrace

.. code-block:: php

	\nn\t3::Errors()->Error('Damn', 1234);

Ist ein Alias zu:

.. code-block:: php

	\nn\t3::Error('Damn', 1234);

| ``@return void``

\\nn\\t3::Errors()->Exception(``$message, $code = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine Typo3-Exception werfen mit Backtrace

.. code-block:: php

	\nn\t3::Errors()->Exception('Damn', 1234);

Ist ein Alias zu:

.. code-block:: php

	\nn\t3::Exception('Damn', 1234);

| ``@return void``

