<?php

namespace App\Models;
use Services\AllClass\DataWizard ;

class UnitsMaster extends DataWizard 
{
    // PATTERN_UNITNAME is a regex to accept or not new unitsnames
    public CONST PATTERN_UNITNAME = "/^[\p{L} -]{0,60}[0-9]{0,2}$/";
    public $actualTable =  "UnitsMaster"; 
    public $chosenUnitName = NULL;
    public $chosenUnitID = NULL;
    public $unitRegistrationErrors = [
        "general" => NULL,
        "new" => NULL,
        "current" => NULL,
    ];


    public function addNewUnit($valueOfName)
    {
        // $whateverToInsert = columns of insertion : a name.
        // ID is not require because automatically generated.
        
        $whateverToInsert = (array("unit_name"));
        $table = $this -> actualTable;
        $valuesToBind = (array($valueOfName));
        $result = $this -> insert(
            $whateverToInsert, 
            $table, 
            $valuesToBind
        );
    }

    public function findUnit($whatever, $paramForSelection, $valueForSelection)
    {   
        $table = $this ->actualTable;
        $result = $this -> getElement($whatever, $table, $paramForSelection, $valueForSelection);
        return($result["$whatever"]);
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
        file_put_contents('test.txt', $newName);
        // If only one is set : push or search corresponding id.
        // If twice or none, give error.

        if($newName ==! NULL) { 
            if($selectName != "NULL"){
                $this -> unitRegistrationErrors["general"] = "Veuillez remplir un seul des deux champs.";
            } else {
                // In this case we may push a new unit.
                // Must verify name of the new unit :
                    
                if(preg_match(self::PATTERN_UNITNAME, $newName)){
                    // Must verify if it not exist already.
                    if($itExist = $this -> itExist($this -> actualTable, "unit_name", $newName)){
                        $this -> unitRegistrationErrors["new"] = "Cette unité existe déjà.";
                    } else {
                        
                    $this -> addNewUnit($newName);
                    $this -> chosenUnitName = $newName;
                    $this -> chosenUnitID = $this -> findUnit("unit_id", "unit_name", $newName);
                    }
                } else {
                    $this -> unitRegistrationErrors["new"] = "Veuillez utiliser seulement les caractères [A-Z][a-z], accents et espaces. 60 caractères maximum. Peut finir par un nombre à deux chiffres.";
                } 
            }
        }else{
            if($selectName != "NULL"){
                $this -> chosenUnitID = $this -> findUnit("unit_id", "unit_name", $selectName);
                $this -> chosenUnitName = $selectName;
                // In this case, we just need to return the ID of the selected unit.
            } else {
                $this -> unitRegistrationErrors["general"] = "Veuillez remplir au moins un des champs.";
            }
            
            
        }

        
    }

}

