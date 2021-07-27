
.. include:: ../../Includes.txt

.. _SysCategory:

==============================================
SysCategory
==============================================

\\nn\\t3::SysCategory()
----------------------------------------------

Vereinfacht die Arbeit und den Zugriff auf die ``sys_category`` von Typo3

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::SysCategory()->findAll(``$branchUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Liste aller sys_categories holen

.. code-block:: php

	\nn\t3::SysCategory()->findAll();

| ``@return array``

\\nn\\t3::SysCategory()->findAllByUid(``$branchUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Liste aller sys_categories holen, ``uid`` als Key zurückgeben

.. code-block:: php

	\nn\t3::SysCategory()->findAllByUid();

| ``@return array``

\\nn\\t3::SysCategory()->findByUid(``$uidList = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

sys_categories anhand von uid(s) holen.

.. code-block:: php

	\nn\t3::SysCategory()->findByUid( 12 );
	\nn\t3::SysCategory()->findByUid( '12,11,5' );
	\nn\t3::SysCategory()->findByUid( [12, 11, 5] );

| ``@return array|\TYPO3\CMS\Extbase\Domain\Model\Category``

\\nn\\t3::SysCategory()->getTree(``$branchUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Den gesamten SysCategory-Baum (als Array) holen.
Jeder Knotenpunkt hat die Attribute 'parent' und 'children', um
rekursiv durch Baum iterieren zu können.

.. code-block:: php

	\nn\t3::SysCategory()->getTree();
	\nn\t3::SysCategory()->getTree( $uid );

ToDo: Prüfen, ob Caching sinnvoll ist

| ``@return array``

