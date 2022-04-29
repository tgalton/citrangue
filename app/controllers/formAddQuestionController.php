<?php

use App\Models\NotionsMaster ;
$notionsMaster = new NotionsMaster;
$UnitID = 42;
$selectedNotions = $notionsMaster -> notionsByUnitID($UnitID);
var_dump($selectedNotions);
require_once '../app/views/formAddQuestion.phtml';