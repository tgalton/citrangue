<?php
require_once '../router/router.php'; 
// if there are none selected link => home

$path = $_GET['url'] ?? DEFAULT_PATH;
var_dump($path);
$content = router($path);

// Alway need the layout at the end
require_once '../views/layout.phtml';

