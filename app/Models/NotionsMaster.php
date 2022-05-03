<?php

namespace App\Models;
use Services\AllClass\DataWizard ;

class NotionsMaster extends DataWizard 
{
    public $actualTable =  "NotionsMaster"; 
    public CONST PATTERN_NOTIONNAME = "/^[a-zA-Z]+$/";



    public function addNewNotion($valueOfName, $unitID, $unitLvl)
    {
        // $whateverToInsert = columns of insertion : a name.
        // ID is not require because automatically generated.
        $whateverToInsert = ("notion_name, UnitsMaster_unit_id,	LevelsMaster_level_id ");
        $table = $actualTable;
        $valuesToBind = array($valueOfName, $unitID, $unitLvl);
        $result = $this -> insert(
            $whateverToInsert, 
            $table, 
            $valuesToBind
        );
    }

    public function findNotion($whatever, $paramForSelection, $valueForSelection)
    {
        $table = $actualTable;
        $this -> getElement($whatever, $table, $paramForSelection, $valueForSelection);
        // $whatever = what is search; example $whatever = "user_name, inscription_date"
        // $table = database table where you search
        // $paramForSelection = column like user_id
        // $valueForSelection = value inside the column like 42
    }


    public function returnAllNotions($whateverToBeSelected)
    {
        $actualTable = $this -> actualTable;
        return $this -> getAll($whateverToBeSelected, $actualTable);
    }

    public function notionFormProcessoring($newName, $selectName)
    {
        // If only one is set : push or search corresponding id.
        // If twice or none, give error.
        $notionRegistrationErrors = [
            "general" => NULL,
            "new" => NULL,
            "current" => NULL,
        ];
        if($newName =! NULL) { 
            if($selectName =! NULL){
                $notionRegistrationErrors["general"] = "Veuillez remplir un seul des deux champs.";
            } else {
                // In this case we may push a new notion.
                // Must verify name of the new notion :
                if(preg_match(self::PATTERN_NOTIONNAME, $newName)){
                    // Must verify if it not exist already.
                    if($itExist = itExist($this -> actualTable, "notion_name", $newName)){
                        $notionRegistrationErrors["new"] = "Cette notioné existe déjà.";
                    } else {
                    $this -> addNewNotion($newName);
                    }
                } else {
                    $notionRegistrationErrors["new"] = "Veuillez utiliser seulement les caractères [A-Z][a-z] et espace.";
                } 
            }
        }else{
            if($selectName =! NULL){
                return $this -> findNotion("notion_id", "notion_name", $selectName);
                // In this case, we just need to return the ID of the selected notion.
            } else {
                $notionRegistrationErrors["general"] = "Veuillez remplir au moins un des champs.";
            } 
        }
    }
} 

