
.. include:: ../../Includes.txt

.. _Tsfe:

==============================================
Tsfe
==============================================

\\nn\\t3::Tsfe()
----------------------------------------------

All about the Typo3 frontend.
Methods to initialize the FE from the backend context, access the
cObj and cObjData etc.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Tsfe()->bootstrap(``$conf = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Bootstrap Typo3

.. code-block:: php

	\nn\t3::Tsfe()->bootstrap();
	\nn\t3::Tsfe()->bootstrap( ['vendorName'=>'Nng', 'extensionName'=>'Nnhelpers', 'pluginName'=>'Foo'] );

\\nn\\t3::Tsfe()->cObj();
"""""""""""""""""""""""""""""""""""""""""""""""

get$GLOBALS['TSFE']->cObj.

.. code-block:: php

	\nn\t3::Tsfe()->cObj()

| ``@return \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer``

\\nn\\t3::Tsfe()->cObjData(``$var = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

$GLOBALS['TSFE']->cObj->get data.

.. code-block:: php

	\nn\t3::Tsfe()->cObjData(); => array with DB-row of the current content element.
	\nn\t3::Tsfe()->cObjData('uid'); => uid of current content element

| ``@return mixed``

\\nn\\t3::Tsfe()->cObjGetSingle(``$type = '', $conf = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Render a TypoScript object.
Früher: ``$GLOBALS['TSFE']->cObj->cObjGetSingle()``

.. code-block:: php

	\nn\t3::Tsfe()->cObjGetSingle('IMG_RESOURCE', ['file'=>'image.jpg', 'file.'=>['maxWidth'=>200]] )

\\nn\\t3::Tsfe()->get(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get$GLOBALS['TSFE'].
Initialize if not present (because in BE).

.. code-block:: php

	\nn\t3::Tsfe()->get()
	\nn\t3::Tsfe()->get( $pid )

| ``@return \TYPO3\CMS\FrontendController\TypoScriptFrontendController``

\\nn\\t3::Tsfe()->init(``$pid = [], $typeNum = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Initialize the TSFE.
Also works in the backend context, e.g. within a
Backend module or scheduler job.

.. code-block:: php

	\nn\t3::Tsfe()->init();

