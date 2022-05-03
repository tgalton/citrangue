<?php

namespace App\Models;
use Services\AllClass\DataWizard ;

class UnitsMaster extends DataWizard 
{
    public CONST PATTERN_UNITNAME = "/^[a-zA-Z]+$/";
    public $actualTable =  "UnitsMaster"; 
    public function addNewUnit($valueOfName)
    {
        // $whateverToInsert = columns of insertion : a name.
        // ID is not require because automatically generated.
        $whateverToInsert = ("unit_name");
        $table = $actualTable;
        $valuesToBind = $valueOfName;
        $result = $this -> insert(
            $whateverToInsert, 
            $table, 
            $valuesToBind
        );
    }

    public function findUnit($whatever, $paramForSelection, $valueForSelection)
    {
        $table = $actualTable;
        $this -> getElement($whatever, $table, $paramForSelection, $valueForSelection);
        // $whatever = what is search; example $whatever = "user_name, inscription_date"
        // $table = database table where you search
        // $paramForSelection = column like user_id
        // $valueForSelection = value inside the column like 42
    }


    public function returnAllUnits($whateverToBeSelected)
    {
        $actualTable = $this -> actualTable;
        return $this -> getAll($whateverToBeSelected, $actualTable);
    }

    public function unitFormProcessoring($newName, $selectName)
    {
        // If only one is set : push or search corresponding id.
        // If twice or none, give error.
        $unitRegistrationErrors = [
            "general" => NULL,
            "new" => NULL,
            "current" => NULL,
        ];
        if($newName =! NULL) { 
            if($selectName =! NULL){
                $unitRegistrationErrors["general"] = "Veuillez remplir un seul des deux champs.";
            } else {
                // In this case we may push a new unit.
                // Must verify name of the new unit :
                if(preg_match(self::PATTERN_UNITNAME, $newName)){
                    // Must verify if it not exist already.
                    if($itExist = itExist($this -> actualTable, "unit_name", $newName)){
                        $unitRegistrationErrors["new"] = "Cette unité existe déjà.";
                    } else {
                    $this -> addNewUnit($newName);
                    }
                } else {
                    $unitRegistrationErrors["new"] = "Veuillez utiliser seulement les caractères [A-Z][a-z] et espace.";
                } 
            }
        }else{
            if($selectName =! NULL){
                return $this -> findUnit("unit_id", "unit_name", $selectName);
                // In this case, we just need to return the ID of the selected unit.
            } else {
                $unitRegistrationErrors["general"] = "Veuillez remplir au moins un des champs.";
            }
            
            
        }

        
    }
}

