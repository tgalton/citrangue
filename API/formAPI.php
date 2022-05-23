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

$errorGeneralUnitName = $unitsMaster -> unitRegistrationErrors["general"];
$errorNewUnitName = $unitsMaster -> unitRegistrationErrors["new"];
$errorExistingUnitName = $unitsMaster -> unitRegistrationErrors["current"];

$chosenUnitID = $unitsMaster -> chosenUnitID;
$chosenUnitName = $unitsMaster -> chosenUnitName;

$res = [
    "errorGeneralUnitName" => $errorGeneralUnitName,
    "errorNewUnitName" => $errorNewUnitName,
    "errorExistingUnitName" => $errorExistingUnitName,
    "chosenUnitID" => $chosenUnitID,
    "chosenUnitName" => $chosenUnitName
];

echo json_encode($res);
// echo json_encode($unitLvl);

