
.. include:: ../../Includes.txt

.. _Tsfe:

==============================================
Tsfe
==============================================

\\nn\\t3::Tsfe()
----------------------------------------------

Alles rund um das Typo3 Frontend.
Methoden zum Initialisieren des FE aus dem Backend-Context, Zugriff auf das
cObj und cObjData etc.

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

$GLOBALS['TSFE']->cObj holen.

.. code-block:: php

	\nn\t3::Tsfe()->cObj()

| ``@return \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer``

\\nn\\t3::Tsfe()->cObjData(``$var = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

$GLOBALS['TSFE']->cObj->data holen.

.. code-block:: php

	\nn\t3::Tsfe()->cObjData();          => array mit DB-row des aktuellen Content-Elementes
	\nn\t3::Tsfe()->cObjData('uid'); => uid des aktuellen Content-Elements

| ``@return mixed``

\\nn\\t3::Tsfe()->cObjGetSingle(``$type = '', $conf = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein TypoScript-Object rendern.
Früher: ``$GLOBALS['TSFE']->cObj->cObjGetSingle()``

.. code-block:: php

	\nn\t3::Tsfe()->cObjGetSingle('IMG_RESOURCE', ['file'=>'bild.jpg', 'file.'=>['maxWidth'=>200]] )

\\nn\\t3::Tsfe()->get(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

$GLOBALS['TSFE'] holen.
Falls nicht vorhanden (weil im BE) initialisieren.

.. code-block:: php

	\nn\t3::Tsfe()->get()
	\nn\t3::Tsfe()->get( $pid )

| ``@return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController``

\\nn\\t3::Tsfe()->init(``$pid = [], $typeNum = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Das TSFE initialisieren.
Funktioniert auch im Backend-Context, z.B. innerhalb eines
Backend-Moduls oder Scheduler-Jobs.

.. code-block:: php

	\nn\t3::Tsfe()->init();

