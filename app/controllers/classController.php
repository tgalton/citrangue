<?php

// app\controllers\asideController.php


// ****** UNIT  //
// We want to create a list of all options (Units) to display them on class selection
use App\Models\UnitsMaster ;
$unitsMaster = new UnitsMaster ;
$existingUnits = $unitsMaster -> returnAllUnits("unit_name") ;


require_once "../app/views/class.phtml";



