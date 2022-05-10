<?php

// ****** UNIT SELECTION ****** //
// We want to create a list of all options (Units) for a select
use App\Models\UnitsMaster ;
$frozenUnitID = NULL;
$frozenUnitName = NULL;
$unitsMaster = new UnitsMaster ;
$existingUnits = $unitsMaster -> returnAllUnits("unit_name") ;
$listOfExistingUnit = [] ;
$i = 0;
foreach($existingUnits as &$existingUnit) {
    $option = $existingUnit['unit_name'];
    array_push($listOfExistingUnit, "<option value = $option> $option </option>");
    $i++;
}


// Validation 

if (isset($_POST['registUnit'])){
    $unitsMaster-> unitFormProcessoring(
        $_POST["newUnitName"],
        $_POST["existingUnitName"]
    );
    $frozenUnitID = $unitsMaster -> frozenUnitID;
    $frozenUnitName = $unitsMaster -> frozenUnitName;
}

if (isset($POST['changeUnit'])){
    $frozenUnitID = NULL;
    $frozenUnitName = NULL;
    $unitsMaster -> frozenUnitID = NULL;
    $unitsMaster -> frozenUnitName = NULL;
}


// Log errors for Units

$errorGeneralUnitName = $unitsMaster -> unitRegistrationErrors["general"];
$errorNewUnitName = $unitsMaster -> unitRegistrationErrors["new"];
$errorExistingUnitName = $unitsMaster -> unitRegistrationErrors["current"];


use App\Models\NotionsMaster ;
$notionsMaster = new NotionsMaster;
$UnitID = 42;
$selectedNotions = $notionsMaster -> notionsByUnitID($UnitID);

// ****** UNIT SELECTION ****** //

require_once '../app/views/formAddQuestion.phtml';