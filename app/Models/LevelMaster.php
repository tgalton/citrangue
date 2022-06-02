<?php

namespace App\Models;
use Services\AllClass\DataWizard ;

class LevelMaster extends DataWizard 
{
    public $actualTable = "LevelsMaster";
    public function returnAllLevels($whateverToBeSelected)
    {
        $actualTable = $this -> actualTable;
        return $this -> getAll($whateverToBeSelected, $actualTable);
    }


    public function findLevelIdByNumber($valueForSelection)
    {   
    $whatever = "level_id";
    $paramForSelection = "level_value";
    $table = $this ->actualTable;
    $result = $this -> getElement($whatever, $table, $paramForSelection, $valueForSelection);
    if($result !== FALSE){
        return($result);
    };
    // $whatever = what is search; example $whatever = "user_name, inscription_date"
    // $table = database table where you search
    // $paramForSelection = column like user_id
    // $valueForSelection = value inside the column like 42
    }
}