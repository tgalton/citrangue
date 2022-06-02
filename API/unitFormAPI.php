<?php
require_once "../vendor/autoload.php";

$content = file_get_contents("php://input");
$data = json_decode($content, true);


// Validation 
$newUnitName = $data['newNameUnit'];
$existingUnitName = $data['existingUnitName'];
$unitLvl = $data['unitLvl'];


use App\Models\UnitsMaster ;
$unitsMaster = new UnitsMaster ;
$unitsMaster-> unitFormProcessoring(
    $newUnitName,
    $existingUnitName
);

$errorGeneralUnitName = $unitsMaster -> unitRegistrationErrors["general"] ;
$errorNewUnitName = $unitsMaster -> unitRegistrationErrors["new"] ;
$errorExistingUnitName = $unitsMaster -> unitRegistrationErrors["current"] ;

$chosenUnitID = $unitsMaster -> chosenUnitID ;
$chosenUnitName = $unitsMaster -> chosenUnitName ; 
// Must find all the corresponding Notions.
// It depend also on Level ID -> need to convert unitLvl into lvlID
use App\Models\LevelMaster ;
$levelMaster = new LevelMaster ;
$levelId = $levelMaster -> findLevelIdByNumber($unitLvl) ;


use App\Models\NotionsMaster ;
$notionsMaster = new NotionsMaster ;
$availablesNotions = $notionsMaster -> notionsByUnitIDAndLvl ($chosenUnitID, $levelId["level_id"]) ;
// echo var_dump($availablesNotions) ;

$res = [
    "errorGeneralUnitName" => $errorGeneralUnitName,
    "errorNewUnitName" => $errorNewUnitName,
    "errorExistingUnitName" => $errorExistingUnitName,
    "chosenUnitID" => $chosenUnitID,
    "chosenUnitName" => $chosenUnitName,
    "availableNotions" => $availablesNotions,
    "lvlId" => $levelId
];

echo json_encode($res);


