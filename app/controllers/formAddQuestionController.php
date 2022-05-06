<?php

use App\Models\NotionsMaster ;
$notionsMaster = new NotionsMaster;
$UnitID = 42;
$selectedNotions = $notionsMaster -> notionsByUnitID($UnitID);
// var_dump($selectedNotions);

// We want to create a list of all options (Units) for a select
use App\Models\UnitsMaster ;
$unitsMaster = new UnitsMaster ;
$existingUnits = $unitsMaster -> returnAllUnits("unit_name") ;
$listOfExistingUnit = [] ;
$i = 0;
foreach($existingUnits as &$existingUnit) {
    $option = $existingUnit['unit_name'];
    array_push($listOfExistingUnit, "<option value = $option> $option </option>");
    var_dump($existingUnit['unit_name']);
    $i++;
}

// Log errors for Units
$errorGeneralUnitName = $unitsMaster -> unitRegistrationErrors["general"];
$errorNewUnitName = $unitsMaster -> unitRegistrationErrors["new"];
$errorExistingUnitName = $unitsMaster -> unitRegistrationErrors["current"];

// Validation 
if (isset($_POST['registUnit'])){
    var_dump("Something");
    $unitsMaster-> unitFormProcessoring(
        $_POST["newUnitName"],
        $_POST["existingUnitName"]
    );
}
require_once '../app/views/formAddQuestion.phtml';