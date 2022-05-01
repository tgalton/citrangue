<?php

use App\Models\NotionsMaster ;
$notionsMaster = new NotionsMaster;
$UnitID = 42;
$selectedNotions = $notionsMaster -> notionsByUnitID($UnitID);
var_dump($selectedNotions);

// We want to create a list of all options (Units) for a select
use App\Models\UnitsMaster ;
$unitsMaster = new UnitsMaster ;
$existingUnits = $unitsMaster -> returnAllUnits("unit_name") ;
$listOfExistingUnit = [] ;
foreach($existingUnits as &$existingUnit) {
    array_push($listOfExistingUnit, "<option value = $existingUnit> $existingUnit </option>");
}


require_once '../app/views/formAddQuestion.phtml';