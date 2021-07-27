
.. include:: ../../Includes.txt

.. _Log:

==============================================
Log
==============================================

\\nn\\t3::Log()
----------------------------------------------

Log in die Tabelle ``sys_log``

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Log()->error(``$extName = '', $message = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine Warnung in die Tabelle sys_log schreiben.
Kurzschreibweise für \nn\t3::Log()->log(..., 'error');

.. code-block:: php

	    \nn\t3::Log()->error( 'extname', 'Text', ['die'=>'daten'] );

return void

\\nn\\t3::Log()->info(``$extName = '', $message = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine Info in die Tabelle sys_log schreiben.
Kurzschreibweise für \nn\t3::Log()->log(..., 'info');

.. code-block:: php

	    \nn\t3::Log()->error( 'extname', 'Text', ['die'=>'daten'] );

return void

\\nn\\t3::Log()->log(``$extName = 'nnhelpers', $message = NULL, $data = [], $severity = 'info'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Schreibt einen Eintrag in die Tabelle ``sys_log``.
Der severity-Level kann angegeben werden, z.B. ``info``, ``warning`` oder ``error``

.. code-block:: php

	\nn\t3::Log()->log( 'extname', 'Alles übel.', ['nix'=>'gut'], 'error' );
	\nn\t3::Log()->log( 'extname', 'Alles schön.' );

| ``@return mixed``

