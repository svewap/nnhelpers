
.. include:: ../../Includes.txt

.. _BackendUser:

==============================================
BackendUser
==============================================

\\nn\\t3::BackendUser()
----------------------------------------------

Methoden, um im Frontend zu prüfen, ob ein User im Typo3-Backend eingeloggt ist und z.B. Admin-Rechte besitzt.
Methoden, um einen Backend-User zu starten, falls er nicht existiert (z.B. während eines Scheduler-Jobs).

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::BackendUser()->get();
"""""""""""""""""""""""""""""""""""""""""""""""

Holt den aktuellen Backend-User.
Entspricht ``$GLOBALS['BE_USER']`` in früheren Typo3-Versionen.

.. code-block:: php

	\nn\t3::BackendUser()->get();

| ``@return \TYPO3\CMS\Backend\FrontendBackendUserAuthentication``

\\nn\\t3::BackendUser()->getSettings(``$moduleName = 'nnhelpers', $path = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Holt userspezifische Einstellungen für den aktuell eingeloggten Backend-User.
Siehe ``\nn\t3::BackendUser()->updateSettings()`` zum Speichern der Daten.

.. code-block:: php

	\nn\t3::BackendUser()->getSettings('myext');                 // => ['wants'=>['drink'=>'coffee']]
	\nn\t3::BackendUser()->getSettings('myext', 'wants');        // => ['drink'=>'coffee']
	\nn\t3::BackendUser()->getSettings('myext', 'wants.drink');  // => 'coffee'

| ``@return mixed``

\\nn\\t3::BackendUser()->isAdmin();
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob der BE-User ein Admin ist.
Früher: ``$GLOBALS['TSFE']->beUserLogin``

.. code-block:: php

	\nn\t3::BackendUser()->isAdmin();

| ``@return bool``

\\nn\\t3::BackendUser()->isLoggedIn();
"""""""""""""""""""""""""""""""""""""""""""""""

Prüft, ob ein BE-User eingeloggt ist.
Beispiel: Im Frontend bestimmte Inhalte nur zeigen, wenn der User im Backend eingeloggt ist.
Früher: ``$GLOBALS['TSFE']->beUserLogin``

.. code-block:: php

	\nn\t3::BackendUser()->isLoggedIn();

| ``@return bool``

\\nn\\t3::BackendUser()->start();
"""""""""""""""""""""""""""""""""""""""""""""""

Starte (faken) Backend-User.
Löst das Problem, das z.B. aus dem Scheduler bestimmte Funktionen
wie ``log()`` nicht möglich sind, wenn kein aktiver BE-User existiert.

.. code-block:: php

	\nn\t3::BackendUser()->start();

| ``@return \TYPO3\CMS\Backend\FrontendBackendUserAuthentication``

\\nn\\t3::BackendUser()->updateSettings(``$moduleName = 'nnhelpers', $settings = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Speichert userspezifische Einstellungen für den aktuell eingeloggten Backend-User.
Diese Einstellungen sind auch nach Logout/Login wieder für den User verfügbar.
Siehe ``\nn\t3::BackendUser()->getSettings('myext')`` zum Auslesen der Daten.

.. code-block:: php

	\nn\t3::BackendUser()->updateSettings('myext', ['wants'=>['drink'=>'coffee']]);

| ``@return array``

