<?php

// app\controllers\asideController.php


// ****** UNIT  //
// We want to create a list of all options (Units) to display them on class selection
use App\Models\UnitsMaster ;
$unitsMaster = new UnitsMaster ;
$existingUnits = $unitsMaster -> returnAllUnits("unit_name") ;
for($i = 0 ; $i < count($existingUnits) ; $i++) {
    $existingUnits[$i]["unit_name"] = htmlspecialchars($existingUnits[$i]["unit_name"]) ;
}


require_once "../app/views/class.phtml";



