
.. include:: ../../Includes.txt

.. _Slug:

==============================================
Slug
==============================================

\\nn\\t3::Slug()
----------------------------------------------

Generate and manipulate URL paths (slug)

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Slug()->create(``$model``);
"""""""""""""""""""""""""""""""""""""""""""""""

Generates a slug (URL path) for a model.
Automatically determines the TCA field for the slug.

.. code-block:: php

	\nn\t3::Slug()->create( $model );

| ``@return string``

