<?php

namespace App\Models;
use Services\AllClass\DataWizard ;

class QuestionsComplexities extends DataWizard {
    public $actualTable =  "QuestionsComplexities"; 


    public function findComplexityIDByDuration($duration)
    {
        $whatever = "complexity_id" ;
        $paramForSelection = "estimated_duration_seconds" ;
        $table = $this -> actualTable ;
        $valueForSelection = $duration ;
        $result = $this -> getElement($whatever, $table, $paramForSelection, $valueForSelection);
        return($result["$whatever"]);
    }

}