<?php

namespace App\Models;
use Services\AllClass\DataWizard ;

class PossibleAnswersMaster extends DataWizard 
{
    public $actualTable =  "PossibleAnswersMaster"; 
    public function addNewAnswer(
        $answerTextValue,
        $isCorrectValue, 
        $questionID
    )
    {
        // $whateverToInsert = columns of insertion : All except ID
        // ID is not require because automatically generated.
        $whateverToInsert = ("answer_text, is_correct_answer, question_id");
        $table = $actualTable;
        $valuesToBind = array(
            $answerTextValue,
            $isCorrectValue, 
            $questionID
        );

        $result = $this -> insert(
            $whateverToInsert, 
            $table, 
            $valuesToBind
        );
    }
}