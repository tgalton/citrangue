<?php 

require_once "../vendor/autoload.php";
// On initialise datafinder pour pouvoir l'utiliser partout.
use Services\AllClass\DataFinder;
$dataFinder = new DataFinder();
// $dataFinder -> pushNewUser("new", "new@new", "new");



// On lance pathsfinder comme router pour le site.
use Services\AllClass\PathsFinder;
$pathsMaster = new PathsFinder();

$pathsMaster->getAllPaths();


$path = $_GET["url"] ?? $pathsMaster::DEFAULT_PATH;

$content = $pathsMaster->router($path);

error_reporting(E_ALL);
ini_set("display_error", 1);
// phpinfo();

// Absolument necessaire de require le layout à la fin
require_once '../app/views/layout.phtml';