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
    array_push($listOfExistingUnit, "<option value = '$option'> '$option' </option>");
    $i++;
}


// Validation 

if (isset($_POST['registUnit'])){
    $unitsMaster-> unitFormProcessoring(
        $_POST["newUnitName"],
        $_POST["existingUnitName"]
    );
    // if validation is push : freaze choice of Unit
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

// level selection
use App\Models\LevelMaster ;
$levelMaster = new LevelMaster ;
$existingLvl = $levelMaster -> returnAllLevels("level_name, level_id") ;
if (isset($_POST['registUnit'])){
    $lvlValueSelected = $_POST["unitLvl"] ;
    $lvlName = $existingLvl["$lvlValueSelected"]["level_name"] ; 
    $lvlID = $existingLvl["$lvlValueSelected"]["level_id"] ; 
}

// ****** NOTION SELECTION ****** //
// We create a list of notions depending on unit and lvl
use App\Models\NotionsMaster ;
$notionsMaster = new NotionsMaster;
$existingNotionsByUnitID = $notionsMaster -> notionsByUnitIDAndLvl($frozenUnitID, $lvlID);
$listOfExistingNotions = [] ;
foreach($existingNotionsByUnitID as &$existingNotion) {
    $option = $existingNotion['notion_name'];
    array_push($listOfExistingUnit, "<option value = '$option'> '$option' </option>");
}

if (isset($_POST['registNotion'])){
    $newNameNotion = $_POST['newNotionName'];
    $selectNameNotion = $_POST['existingNotionName'];
    $notionsMaster -> notionFormProcessoring(
        $newNameNotion,
        $selectNameNotion);
}

require_once '../app/views/formAddQuestion.phtml';