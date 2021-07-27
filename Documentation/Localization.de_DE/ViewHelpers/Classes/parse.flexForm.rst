
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Parse\FlexFormViewHelper:

=======================================
parse.flexForm
=======================================

Description
---------------------------------------

<nnt3:parse.flexForm />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Parses a FlexForm (XML) and makes it into an array.

Practical if you have a raw record of the ``tt_content`` table in front of you and need to get to a value from the FlexForm in ``pi_flexform``.

.. code-block:: php

	{row.pi_flexform->nnt3:parse.flexForm()->f:debug()}

| ``@return array``

