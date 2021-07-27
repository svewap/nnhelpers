
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\ContentElementViewHelper:

=======================================
contentElement
=======================================

Description
---------------------------------------

<nnt3:contentElement />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Ein Content-Element rendern

Der von uns wahrscheinlich meist genutzte ViewHelper.

Content-Element aus der Tabelle ``tt_content`` mit der ``uid: 123`` rendern.

.. code-block:: php

	{nnt3:contentElement(uid:123)}

Variablen im gerenderten Content-Element ersetzen.
Erlaubt es, im Backend ein Inhaltselement anzulegen, das mit Fluid-Variablen arbeitet – z.B. für ein Mail-Template, bei dem der Empfänger-Name im Text erscheinen soll.

.. code-block:: php

	{nnt3:contentElement(uid:123, data:'{greeting:\'Hallo!\'}')}
	{nnt3:contentElement(uid:123, data:feUser.data)}

Zum Rendern der Variablen muss nicht zwingend eine ``contentUid`` übergeben werden. Es kann auch direkt HTML-Code geparsed werden:

.. code-block:: php

	{data.bodytext->nnt3:contentElement(data:'{greeting:\'Hallo!\'}')}

| ``@return string``

