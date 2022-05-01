<?php

namespace App\Models;
use Services\AllClass\DataWizard ;

class UnitsMaster extends DataWizard 
{
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

    public function returnAllUnits($whateverToBeSelected)
    {
        $actualTable = $this -> actualTable;
        return $this -> getAll($whateverToBeSelected, $actualTable);
    }
}

