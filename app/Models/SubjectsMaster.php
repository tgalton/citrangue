<?php

namespace App\Models;
use Services\AllClass\DataWizard ;

class SubjectsMaster extends DataWizard 
{
    public $actualTable =  "SubjectsMaster"; 
    public function addNewSubject($valueOfName)
    {
        // $whateverToInsert = columns of insertion : a name.
        // ID is not require because automatically generated.
        $whateverToInsert = ("subject_name");
        $table = $actualTable;
        $valuesToBind = $valueOfName;
        $result = $this -> insert(
            $whateverToInsert, 
            $table, 
            $valuesToBind
        );
    }
}