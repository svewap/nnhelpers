
.. include:: ../../Includes.txt

.. _AnnotationHelper:

==============================================
AnnotationHelper
==============================================

\\nn\\t3::AnnotationHelper()
----------------------------------------------

Various methods for parsing PHP annotations
.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::AnnotationHelper()->parse(``$rawAnnotation = '', $namespaces = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Parse annotations and return an array containing the "normal" comment block and the
individual annotations from a DocComment.

.. code-block:: php

	\Nng\Nnhelpers\AnnotationHelper::parse( '...' );

Fetch only annotations that are in a given namespace.
In this example, only annotations that start with ``@nn\rest`` are fetched.
for example, ``@nn\rest\access ...``

.. code-block:: php

	\Nng\Nnhelpers\AnnotationHelper::parse( '...', 'nn\rest' );
	\Nng\NnhelpersHelpersAnnotationHelper::parse( '...', ['nn\rest', 'whatever'] );

| ``@return array``

