<?php

namespace App\Models;
use Services\AllClass\DataWizard ;

class QuestionsMaster extends DataWizard 
{
    public $actualTable =  "QuestionsMaster"; 
    public function addNewQuestion(
        $notionIdValue, 
        $isIllustratedValue, 
        $complexityIdValue, 
        $questionTextValue
        )
    {
        // $whateverToInsert = columns of insertion : All except ID
        // ID is not require because automatically generated.
        $whateverToInsert = ("notion_id, is_illustrated, complexity_id, question_text");
        $table = $actualTable;
        $valuesToBind = array($notionIdValue, $isIllustratedValue, $complexityIdValue, $questionTextValue);

        $result = $this -> insert(
            $whateverToInsert, 
            $table, 
            $valuesToBind
        );
    }
}