<?php

namespace Nng\Nnhelpers\Controller;

use Nng\Nnhelpers\Domain\Repository\EntryRepository;

class TestController extends \Nng\Nnhelpers\Controller\AbstractController {


	/**
	 * 	Tests vieler Funktionen.
	 * 
	 * 	Backend: 	Über Backend-Modul aufrufbar (muss im Extension-Manager aktiviert sein)
	 * 	Frontend: 	Über ?type=20190825&testID=Tsfe%3A%3Ainit (Backend-User muss eingeloggt sein)
	 *  
	 * 	@return void
	 */
	public function testAction () {
		
		if (!\nn\t3::BackendUser()->isAdmin()) {
			die('Zum Testen als Admin ins Backend einloggen.');
		}
		
		if ($testID = $_GET['testID']) {
			
			$errors = [];
			$success = [];

			$entryRepository = \nn\t3::injectClass( EntryRepository::class );
			$pathSite = \nn\t3::Environment()->getPathSite();

			$this->createTestFolder();
			$testImg = $this->createTestImage();

			switch ($testID) {

				case 'Environment::getBaseURL';

					// Sollte URL der Webseite zurückgeben, z.B. https://www.projekt.de/
					$result = \nn\t3::Environment()->getBaseURL();
					if (!trim($result)) $errors[] = 'Konnte keine baseURL ermitteln.';
					$success[] = $result;
					break;
				
				case 'Environment::getPathSite';

					// Sollte absoluten Pfad zu Typo3 zurückgeben, z.B. /var/www/.../projekt/
					$result = \nn\t3::Environment()->getPathSite();
					if (!trim($result)) $errors[] = 'Konnte keine pathSite ermitteln.';
					$success[] = $result;
					break;

				case 'Db::insert';

					// Einen Datensatz in DB einfügen
					$result = \nn\t3::Db()->insert('tx_nnhelpers_domain_model_entry', ['data'=>'insert']);
					$uid = $result['uid'];
					if (!$uid) {
						$errors[] = "Kein Datensatz eingefügt.";
					} else {
						$success[] = "Neuer Datensatz eingefügt [{$result['uid']}]";
					}

					if ($uid) {

						// Datensatz lesen anhand der uid
						$result = \nn\t3::Db()->findByUid('tx_nnhelpers_domain_model_entry', $uid);
						if (!$result) {
							$errors[] = "Lesen anhand UID fehlgeschlagen.";
						} else {
							$success[] = "Datensatz erfolgreich gelesen anhand der UID [{$result['uid']}]";
						}
						
						// Datensatz lesen anhand von Kriterien
						$result = \nn\t3::Db()->findByValues( 'tx_nnhelpers_domain_model_entry', ['data'=>'insert'], false, false );
						if (!$result) {
							$errors[] = "Lesen anhand von Kriterien fehlgeschlagen.";
						} else {
							$success[] = 'Datensatz erfolgreich gelesen anhand von Kriterien [' . count($result) . ' Zeilen]';
						}

						// Datensatz updaten anhand der uid
						$result = \nn\t3::Db()->update('tx_nnhelpers_domain_model_entry', ['data'=>'update'], $uid);
						$result = \nn\t3::Db()->findByUid('tx_nnhelpers_domain_model_entry', $uid);

						if ($result['data'] != 'update') {
							$errors[] = "Update fehlgeschlagen.";
						} else {
							$success[] = "Datensatz erfolgreich geändert [{$result['uid']}]";
						}
						
						// endtime ändern, Datensatz sollte versteckt sein, wenn Contraints NICHT ignoriert werden
						$result = \nn\t3::Db()->update('tx_nnhelpers_domain_model_entry', ['endtime'=>'9999'], $uid);
						$result = \nn\t3::Db()->findByUid('tx_nnhelpers_domain_model_entry', $uid);
						\nn\t3::Db()->update('tx_nnhelpers_domain_model_entry', ['endtime'=>'0'], $uid);

						if ($result['data']) {
							$errors[] = "Endtime wurde im Constraint nicht berücksichtigt.";
						} else {
							$success[] = "Endtime im Constraint erfolgreich berücksichtigt.";
						}
						

						// Datensatz laden, obwohl endtime gesetzt ist (true = Contraints sollten ignoriert werden)
						$result = \nn\t3::Db()->findByUid('tx_nnhelpers_domain_model_entry', $uid, true);
						if (!$result['data']) {
							$errors[] = "Datensatz konnte nicht geladen werden, obwohl Constraint deaktiviert wurde.";
						} else {
							$success[] = "Datensatz konnte geladen werden, Constraint erfolgreich entfernt.";
						}

						// Datensatz löschen, delete-Flag setzen
						$result = \nn\t3::Db()->delete( 'tx_nnhelpers_domain_model_entry', $uid );
						$result = \nn\t3::Db()->findByUid('tx_nnhelpers_domain_model_entry', $uid);
						if ($result) {
							$errors[] = "Löschen per delete-Flag fehlgeschlagen.";
						} else {
							$success[] = "Löschen per delete-Flag erfolgreich";
						}

						// Datensatz darf nie geladen werden, wenn delete-Flag gesetzt ist
						$result = \nn\t3::Db()->findByUid('tx_nnhelpers_domain_model_entry', $uid, true);
						if ($result) {
							$errors[] = "Datensatz konnte geladen werden, obwohl delete-Flag gesetzt war.";
						} else {
							$success[] = "Keine Daten geladen, wenn delete-Flag gesetzt ist.";
						}
						
						// Datensatz wiederherstellen
						$result = \nn\t3::Db()->undelete( 'tx_nnhelpers_domain_model_entry', $uid );
						$result = \nn\t3::Db()->findByUid('tx_nnhelpers_domain_model_entry', $uid, true);
						if (!$result) {
							$errors[] = "Undelete fehlgeschlagen.";
						} else {
							$success[] = "Undelete war erfolgreich";
						}

						// Datensatz WIRKLICH löschen, statt nur deleted=1 zu setzen
						$result = \nn\t3::Db()->delete( 'tx_nnhelpers_domain_model_entry', $uid, true );
						$result = \nn\t3::Db()->findByUid('tx_nnhelpers_domain_model_entry', $uid, true );
						if ($result) {
							$errors[] = "Löschen per DELETE fehlgeschlagen.";
						} else {
							$success[] = "Löschen per DELETE erfolgreich";
						}

					}

					break;

				case 'File::paths';

					// Abhängig davon, ob Test im BE oder FE läuft ist Ergebnis unterschiedlich
					$prefix = TYPO3_MODE == 'BE' ? '../' : '';

					// Relativer Pfad zu einem Ordner, von typo3/index.php aus gesehen
					$result = \nn\t3::File()->relPath( 'fileadmin' );
					if ($result != $prefix . 'fileadmin/') {
						$errors[] = "relPath('fileadmin') ergab nicht '../fileadmin/' sondern '{$result}'";
					}
					// Mit / am Ende sollte normalisiert werden (kein // am Ende)
					$result = \nn\t3::File()->relPath( 'fileadmin/' );
					if ($result != $prefix . 'fileadmin/') {
						$errors[] = "relPath('fileadmin/') ergab nicht '../fileadmin/' sondern '{$result}'";
					}
					// existierende Datei statt Ordner sollte kein / am Ende bekommen
					$result = \nn\t3::File()->relPath( 'typo3conf/LocalConfiguration.php' );
					if ($result != $prefix . 'typo3conf/LocalConfiguration.php') {
						$errors[] = "relPath('typo3conf/LocalConfiguration.php') ergab nicht '../typo3conf/LocalConfiguration.php' sondern '{$result}'";
					}
					// ... und mit ../ in Pfadangabe
					$result = \nn\t3::File()->relPath( 'fileadmin/typo3conf/../' );
					if ($result != $prefix . 'fileadmin/') {
						$errors[] = "relPath('fileadmin/typo3conf/../') ergab nicht '../fileadmin/' sondern '{$result}'";
					}
					// nicht-existierender Ordner
					$result = \nn\t3::File()->relPath( 'fileadmin/not-there/' );
					if ($result != $prefix . 'fileadmin/not-there/') {
						$errors[] = "relPath('fileadmin/not-there/') ergab nicht '../fileadmin/not-there/' sondern '{$result}'";
					}
					// Mit absoluter Pfadangabe
					$result = \nn\t3::File()->relPath( $pathSite . 'fileadmin/' );
					if ($result != $prefix . 'fileadmin/') {
						$errors[] = "relPath('/abs/pfad') ergab nicht '../fileadmin/' sondern '{$result}'";
					}

					// Mit absoluter Pfadangabe und ../ auf existierenden Ordner
					$result = \nn\t3::File()->relPath( $pathSite . 'fileadmin/../typo3conf' );
					if ($result != $prefix . 'typo3conf/') {
						$errors[] = "relPath('/abs/pfad') ergab nicht '../typo3conf/' sondern '{$result}'";
					}

					// Mit absoluter Pfadangabe auf nicht existierende Datei
					$result = \nn\t3::File()->relPath( $pathSite . 'fileadmin/not-there.txt' );
					if ($result != $prefix . 'fileadmin/not-there.txt') {
						$errors[] = "relPath('/abs/pfad') ergab nicht '../fileadmin/not-there.txt' sondern '{$result}'";
					}
					// Relativer Pfad von Root auf existierenden Ordner
					$result = \nn\t3::File()->absPath( 'fileadmin/' );
					if ($result != $pathSite . 'fileadmin/') {
						$errors[] = "absPath(...) ergab nicht '{$pathSite}fileadmin/' sondern '{$result}'";
					}
					// Absoluter Pfad von Root auf existierenden Ordner
					$result = \nn\t3::File()->absPath( $pathSite . 'fileadmin/' );
					if ($result != $pathSite . 'fileadmin/') {
						$errors[] = "absPath( /var/www/...) ergab nicht '{$pathSite}fileadmin/' sondern '{$result}'";
					}
					// Relativer Pfad auf nicht existierenden Ordner
					$result = \nn\t3::File()->absPath( 'fileadmin/not-there/' );
					if ($result != $pathSite . 'fileadmin/not-there/') {
						$errors[] = "absPath(...) ergab nicht '{$pathSite}fileadmin/not-there/' sondern '{$result}'";
					}
					// Absoluter Pfad auf nicht existierenden Ordner
					$result = \nn\t3::File()->absPath( $pathSite . 'fileadmin/not-there/' );
					if ($result != $pathSite . 'fileadmin/not-there/') {
						$errors[] = "absPath(...) ergab nicht '{$pathSite}fileadmin/not-there/' sondern '{$result}'";
					}
					// Absoluter Pfad auf nicht existierende Datei, relative Pfadangabe
					$result = \nn\t3::File()->absPath( 'fileadmin/not-there.txt' );
					if ($result != $pathSite . 'fileadmin/not-there.txt') {
						$errors[] = "absPath(...) ergab nicht '{$pathSite}fileadmin/not-there.txt' sondern '{$result}'";
					}
					// Absoluter Pfad auf existierende Datei, relative Pfadangabe
					$result = \nn\t3::File()->absPath( 'typo3conf/LocalConfiguration.php' );
					if ($result != $pathSite . 'typo3conf/LocalConfiguration.php') {
						$errors[] = "absPath(...) ergab nicht '{$pathSite}typo3conf/LocalConfiguration.php' sondern '{$result}'";
					}
					// Absoluter Pfad auf existierende Datei
					$result = \nn\t3::File()->absPath( $pathSite . 'fileadmin/not-there.txt' );
					if ($result != $pathSite . 'fileadmin/not-there.txt') {
						$errors[] = "absPath(...) ergab nicht '{$pathSite}fileadmin/not-there.txt' sondern '{$result}'";
					}
					// Absoluter Pfad auf nicht existierende Datei
					$result = \nn\t3::File()->absPath( $pathSite . 'typo3conf/LocalConfiguration.php' );
					if ($result != $pathSite . 'typo3conf/LocalConfiguration.php') {
						$errors[] = "absPath(...) ergab nicht '{$pathSite}typo3conf/LocalConfiguration.php' sondern '{$result}'";
					}

					if (!$errors) $success[] = 'Alle Pfad-Tests erfolgreich';
					break;

				case 'File::getStorage';

					// Storage für fileadmin/ sollte zurückgegeben werden
					$result = \nn\t3::File()->getStorage('fileadmin');
					if (!$result || $result->getUid() != 1) {
						$errors[] = "getStorage('fileadmin') ergab nicht uid=1";
					} else {
						$success[] = $result->getConfiguration()['basePath'] . " [{$result->getUid()}]";
					}

					// Existiert die Storage noch nicht, sollte sie angelegt werden
					$result = \nn\t3::File()->getStorage('uploads', true);
					if (!$result || !$result->getUid()) {
						$errors[] = "getStorage('uploads') wurde nicht angelegt / gefunden";
					} else {
						$success[] = $result->getConfiguration()['basePath'] . " [{$result->getUid()}]";
					}
					break;
								
				case 'File::getData':

					// Meta-Daten sollen ausgelesen werden inkl. Auflösung der lng/lat in eine Adresse über die Google API (falls nnaddress vorhanden ist)
					$result = \nn\t3::File()->getData( $testImg );
					if (!$result) $errors[] = "Data nicht ausgelesen";
					if (\nn\t3::Environment()->extLoaded('nnaddress') && !$result['lat']) $errors[] = "EXIF-Geodaten nicht ausgelesen.";
					$success[] = "Größe {$result['width']} x {$result['height']} / Exif: {$result['lng']}, {$result['lat']} / geo2address: {$result['city']}";
					break;
				
				case 'Fal::createFalFile':
					
					// Ein FAL erzeugen. $keepSrcFile = false, $forceCreateNew = true
					$fal = \nn\t3::Fal()->createFalFile( 'fileadmin/_tests/fal/', $testImg, false, true );
					$falUid = false;
					if (!$fal || !$fal->getUid()) {
						$errors[] = "FAL konnte nicht erzeugt werden";
					} else {
						$falUid = $fal->getUid();
						$success[] = "FAL [{$falUid}] in sys_file erzeugt.";
					}

					// Quelldatei sollte noch existieren, weil "forceCreateNew = true" gesetzt war
					if ($fal) {
						if (!file_exists($testImg)) {
							$errors[] = "Quellbild wurde nicht kopiert, sondern verschoben";
						}
					}

					// Bereits erzeugtes FAL darf nicht erneut erzeugt werden
					if ($falUid) {
						$fal = \nn\t3::Fal()->createFalFile( 'fileadmin/_tests/fal/', $testImg, false, false );
						if ($fal && $falUid != $fal->getUid() ) {
							$errors[] = "FAL wurde neu erzeugt, sollte aber Referenz zu bereits existierendem FAL werden. alt: {$falUid} - neu: {$fal->getUid()}";
						} else {
							$success[] = "Bereits vorhandes FAL [{$falUid}] wurde korrekt referenziert.";
						}
					}

					// Erzeugtes Fal holen
					$fal = \nn\t3::Fal()->getFalFile( $fal->getPublicUrl() );
					if (!$fal || !$fal->getUid()) {
						$errors[] = "getFalFile() File konnte nicht geladen werden";
					} else {
						$success[] = "getFalFile() erfolgreich geladen [{$fal->getUid()}]";
					}
					break;

				case 'Fal::fromFile':

					// Ein FAL aus einem Bild erzeugen und an ein Model anhängen
					$result = \nn\t3::Db()->insert('tx_nnhelpers_domain_model_entry', ['data'=>'insert']);
					
					if ($uid = $result['uid']) {
						$fal = \nn\t3::Fal()->fromFile([
							'src'			=> $testImg,
							'dest' 			=> 'fileadmin/_tests/fal/',
							'pid'			=> 1,
							'uid'			=> $uid, 
							'table'			=> 'tx_nnhelpers_domain_model_entry', 
							'field'			=> 'media',
							'copy'			=> false,
							'forceNew'		=> false,
							'single'		=> true,
						]);

						$result = $entryRepository->findByUid($uid);
						\nn\t3::Db()->delete( 'tx_nnhelpers_domain_model_entry', $uid, true );
						
						if (!$result || !count($result->getMedia())) {
							$errors[] = "FAL wurde nicht an Model angehängt.";
						} else {
							$firstMedia = $result->getFirstMedia();
							$success[] = "FAL erfolgreich an Model angehängt. [{$firstMedia->getUid()} - {$firstMedia->getOriginalResource()->getPublicUrl()}]";
						}

					}
					

					break;

				case 'File::processImage':
				
					// Bild kleiner rechnen
					$fal = \nn\t3::Fal()->getFalFile( $testImg );
					
					$result = \nn\t3::File()->processImage($testImg, ['maxWidth'=>170]);
					if (!$result) $errors[] = "Data nicht ausgelesen";
					$success[] = "Größe {$result['width']} x {$result['height']} / Exif: {$result['lng']}, {$result['lat']} / geo2address: {$result['city']}";
					break;
				
				case 'Tsfe::init':

					// TSFE aus dem Backend erzeugen
					$tsfe = \nn\t3::Tsfe()->get();

					if (!$tsfe || !$tsfe->tmpl->setup) {
						$errors[] = "TSFE nicht initialisiert.";
					} else {
						$success[] = "TSFE erfolgreich initialisiert.";
					}
					break;
				
				case 'Page':

					// Link im Backend / Frontend erzeugen
					$link = \nn\t3::Page()->getLink( 1, true );
					if (!$link) {
						$errors[] = "getLink(1) - keine URL erzeugt";
					} else {
						$success[] = "getLink(1) = {$link}";
					}

					break;

				case 'SysCategory':
					
					$sysCategories = \nn\t3::SysCategory()->findAllByUid();
					if (!($cnt = count($sysCategories))) {
						$errors[] = "findAllByUid(): Keine SysCategories gefunden.";
					} else {
						$success[] = "findAllByUid(): {$cnt} SysCategories gefunden.";
					}

					break;
				
				case 'Content':
					
					$row = \nn\t3::Db()->findOneByValues('tt_content', ['CType'=>'text']);
					$uid = $row['uid'];
					if ($uid) {
						$html = \nn\t3::Content()->render( $uid );
						if (!$html) {
							$errors[] = "render(): Fehler beim Rendern.";
						} else {
							$success[] = "render(): Erfolgreich.";
						}
					}

					break;
				
				case 'Settings':
					
					$ts = \nn\t3::Settings()->get('tx_nnhelpers', 'test.deep');
					if ($ts != 'settings-ok') {
						$errors[] = "get(): Kein Setup bekommen.";
					} else {
						$success[] = "get(): Setup bekommen.";
					}

					$ts = \nn\t3::Settings()->getPlugin('tx_nnhelpers');
					if ($ts['test'] != 'ok') {
						$errors[] = "getPlugin(): Kein Setup bekommen.";
					} else {
						$success[] = "getPlugin(): Setup bekommen.";
					}

					break;

				case 'Convert':

					$model = \nn\t3::Convert(['data'=>'insert'])->toModel(\Nng\Nnhelpers\Domain\Model\Entry::class);
					if (!$model || !$model->getData()) {
						$errors[] = "toModel(): Model konnte nicht aus Array erzeugt werden.";
					} else {
						$success[] = "toModel(): Model erfolgreich aus Array erzeugt";
					}

					\nn\t3::Fal()->setInModel( $model, 'media', [$testImg] );
					if (!$model || !count($model->getMedia())) {
						$errors[] = "setInModel(): FAL konnte nicht an Model gehängt werden.";
					} else {
						$success[] = "setInModel(): FAL erfolgreich an Model gehängt.";
					}

					if ($uid = $model->getUid()) {
						$success[] = "Model durch FAL erfolgreich persistiert.";
					} else {
						$errors[] = "Model durch FAL nicht persistiert.";
					}

					break;

				default:
					$errors[] = "Test {$testID} unbekannt.";
					break;
			}
			
			if ($testImg) {
				@unlink( $testImg );
			}

			$result = ['errors'=>$errors, 'success'=>$success];
			return json_encode($result);
		}

		$this->view->assignMultiple([
			'baseURL' => \nn\t3::Environment()->getBaseUrl()
		]);

	}

	/**
	 * 	Einen Ordner zum Testen erzeugen.
	 * 
	 * 	@return void
	 */
	public function createTestFolder () {
		\nn\t3::File()->createFolder('_tests');
	}

	/**
	 * 	Testbild erzeugen und in Testordner kopieren.
	 * 	Enthält auch EXIF-Daten, um Auslesen testen zu können.
	 *
	 * 	@return string
	 */
	public function createTestImage ( $usePHP = false ) {
		$pathSite = \nn\t3::Environment()->getPathSite();
		$testImgSrc 	= $pathSite . 'typo3conf/ext/nnhelpers/Resources/Public/Images/exif-test.jpg';
		$testImgDest 	= $pathSite . 'fileadmin/_tests/'.uniqid().'.jpg';
		if (!$usePHP) {
			$result = \nn\t3::File()->copy( $testImgSrc, $testImgDest );
		} else {
			$result = copy( $testImgSrc, $testImgDest );
		}
		if (!$result) return false;
		return $testImgDest;
	}

}
