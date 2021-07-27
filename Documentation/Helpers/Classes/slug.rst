
.. include:: ../../Includes.txt

.. _Slug:

==============================================
Slug
==============================================

\\nn\\t3::Slug()
----------------------------------------------

URL-Pfade (Slug) generieren und manipulieren

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Slug()->create(``$model``);
"""""""""""""""""""""""""""""""""""""""""""""""

Generiert einen slug (URL-Pfad) für ein Model.
Ermittelt automatisch das TCA-Feld für den Slug.

.. code-block:: php

	\nn\t3::Slug()->create( $model );

| ``@return string``

