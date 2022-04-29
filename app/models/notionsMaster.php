<?php

namespace App\Models;
use Services\AllClass\DataWizard ;

class NotionsMaster extends DataWizard 
{
    public $actualTable =  "NotionsMaster"; 
    public function notionsByUnitID($unitID)
    {
        $valueForSelection = $unitID;
        $whatever = "notion_id, LevelsMaster_level_id, UnitsMaster_unit_id, notion_name";
        $table = $this -> actualTable;
        $paramForSelection = "UnitsMaster_unit_id";
        $request = $this -> getManyElements(
            $whatever,
            $table, 
            $paramForSelection, 
            $valueForSelection
        );
        // $whatever = what is search; example $whatever = "user_name, inscription_date"
        // $table = database table where you search
        // $paramForSelection = column like user_id
        // $valueForSelection = value inside the column like 42  
        return $request; 
    }
    
} 

