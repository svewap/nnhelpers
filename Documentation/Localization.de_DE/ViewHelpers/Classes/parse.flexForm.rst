
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Parse\FlexFormViewHelper:

=======================================
parse.flexForm
=======================================

Description
---------------------------------------

<nnt3:parse.flexForm />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Parsed ein FlexForm (XML) und macht daraus ein Array.

Praktisch, falls man einen rohen Datensatz der Tabelle ``tt_content`` vor sich hat und an einen Wert aus dem FlexForm in ``pi_flexform`` braucht.

.. code-block:: php

	{row.pi_flexform->nnt3:parse.flexForm()->f:debug()}

| ``@return array``

