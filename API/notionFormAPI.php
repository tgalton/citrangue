<?php
require_once "../vendor/autoload.php";

$content = file_get_contents("php://input");
$data = json_decode($content, true);

// Validation
$newNotionName = $data["newNameNotion"] ;
$existingNotionName = $data["existingNotionName"] ;
$unitIDToPush = $data["unitIDToPush"] ;
$lvlIDToPush = $data["lvlIDToPush"] ;

use App\Models\NotionsMaster ;
$notionsMaster = new NotionsMaster ;
$notionsMaster -> notionFormProcessoring(
    $newNotionName,
    $existingNotionName,
    $unitIDToPush,
    $lvlIDToPush
);

$errorGeneralNotionName = $notionsMaster -> notionRegistrationErrors["general"] ;
$errorNewNotionName = $notionsMaster -> notionRegistrationErrors["new"] ;
$errorExistingNotionName = $notionsMaster -> notionRegistrationErrors["current"] ;

$chosenNotionID = $notionsMaster -> chosenNotionID ;
$chosenNotionName = $notionsMaster -> chosenNotionName ;

$res = [
    "errorGeneralNotionName" => $errorGeneralNotionName,
    "errorNewNotionName" => $errorNewNotionName,
    "errorExistingNotionName" => $errorExistingNotionName,
    "chosenNotionID" => $chosenNotionID,
    "chosenNotionName" => $chosenNotionName 
];


echo json_encode($res);

