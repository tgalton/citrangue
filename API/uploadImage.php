<?php

require_once "../vendor/autoload.php";

$content = file_get_contents("php://input") ;
$data = json_decode($content, true) ;
var_dump($data) ;
// Moves uploaded file to a nice directory
// $targetPath = "../../app/pictures/uploadedPicturesUnits" . basename($_FILES["inpFile"]["name"]);
// move_uploaded_file($_FILES["inpFile"]["name"], $targetPath);
use Services\AllClass\Uploads;
if(isset($data) && $data['name'] != '') {
    $dossier = "public";
    $upload = new Uploads;
    $errors = [];
    $upload->upload($data, $dossier, $errors);
}
