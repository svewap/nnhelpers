
.. include:: ../../Includes.txt

.. _Log:

==============================================
Log
==============================================

\\nn\\t3::Log()
----------------------------------------------

Log to the ``sys_log``
 table.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Log()->error(``$extName = '', $message = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Write a warning in the sys_log table.
Shorthand notation for \nn\t3::Log()->log(..., 'error');

.. code-block:: php

	 \nn\t3::Log()->error( 'extname', 'text', ['die'=>'data'] );

return void

\\nn\\t3::Log()->info(``$extName = '', $message = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Write an info to the sys_log table.
Shorthand notation for \nn\t3::Log()->log(..., 'info');

.. code-block:: php

	 \nn\t3::Log()->error( 'extname', 'text', ['die'=>'data'] );

return void

\\nn\\t3::Log()->log(``$extName = 'nnhelpers', $message = NULL, $data = [], $severity = 'info'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Writes an entry in the ``sys_log`` table.
The severity level can be specified, e.g. ``info``, ``warning`` or ``error``

.. code-block:: php

	\nn\t3::Log()->log( 'extname', 'All übel.', ['nix'=>'good'], 'error' );
	\nn\t3::Log()->log( 'extname', 'All shön.' );

| ``@return mixed``

