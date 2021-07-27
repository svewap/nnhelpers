
.. include:: ../../Includes.txt

.. _SysCategory:

==============================================
SysCategory
==============================================

\\nn\\t3::SysCategory()
----------------------------------------------

Simplifies the work and access to the ``sys_category`` of Typo3
.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::SysCategory()->findAll(``$branchUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get list of all sys_categories

.. code-block:: php

	\nn\t3::SysCategory()->findAll();

| ``@return array``

\\nn\\t3::SysCategory()->findAllByUid(``$branchUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get list of all sys_categories, return ``uid`` as key

.. code-block:: php

	\nn\t3::SysCategory()->findAllByUid();

| ``@return array``

\\nn\\t3::SysCategory()->findByUid(``$uidList = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

get sys_categories based on uid(s).

.. code-block:: php

	\nn\t3::SysCategory()->findByUid( 12 );
	\nn\t3::SysCategory()->findByUid( '12,11,5' );
	\nn\t3::SysCategory()->findByUid( [12, 11, 5] );

| ``@return array|\TYPO3\CMS\Extbase\Domain\Model\Category``
.

\\nn\\t3::SysCategory()->getTree(``$branchUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the entire SysCategory tree (as an array).
Each node has the attributes 'parent' and 'children', to be able to
recursively iterate through tree.

.. code-block:: php

	\nn\t3::SysCategory()->getTree();
	\nn\t3::SysCategory()->getTree( $uid );

ToDo: Check if caching makes sense

| ``@return array``

