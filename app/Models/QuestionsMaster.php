<?php

namespace App\Models;
use Services\AllClass\DataWizard ;

class QuestionsMaster extends DataWizard 
{
    public $actualTable =  "QuestionsMaster"; 
    public $questionID = NULL ;
    public $questionRegistrationErrors = [
        "textQuestion" => NULL
    ] ;

    public function addNewQuestion(
        $notionIdValue, 
        $questionTypeID,
        $isIllustratedValue, 
        $complexityIdValue, 
        $questionTextValue
        )
    {
        // $whateverToInsert = columns of insertion : All except ID
        // ID is not require because automatically generated.
        $whateverToInsert = (array("notion_id" , "question_type_id", "is_illustrated", "complexity_id", "question_text"));
        $table = $this -> actualTable;
        $valuesToBind = array($notionIdValue, $questionTypeID, $isIllustratedValue, $complexityIdValue, $questionTextValue);
        // Use insert form DataWizard
        $result = $this -> insert(
            $whateverToInsert, 
            $table, 
            $valuesToBind
        );
    }


    public function findQuestionIDbyTxt($txtNewQuestion)
    {
        $whatever = "question_id" ;
        $paramForSelection = "question_text" ;
        $table = $this -> actualTable ;
        $valueForSelection = $txtNewQuestion ;
        $result = $this -> getElement($whatever, $table, $paramForSelection, $valueForSelection);
        return($result["$whatever"]);
    }


    public function questionFormProcessoring(
        $notionID,
        $questionTypeID,
        $illustrated,
        $timeRequireAmount,
        $txtNewQuestion
    )
    {
        if(strlen($txtNewQuestion)<600){
            $this -> addNewQuestion(
                $notionID,
                $questionTypeID,
                $illustrated,
                $timeRequireAmount,
                $txtNewQuestion
            );
            $this -> questionID = $this -> findQuestionIDbyTxt($txtNewQuestion) ;
        } else {
            $this -> questionRegistrationErrors["textQuestion"] =
            "La question est trop longue. 600 caractères maximum autorisé." ;
        }
    }

    public function findQuestionIdByNotionId($notionId)
    {
        $valueForSelection = $notionId;
        $whatever = "question_id, notion_id, question_type_id, is_illustrated, complexity_id, question_text";
        $table = $this -> actualTable;
        $paramForSelection = "notion_id";
        $result = $this -> getManyElements(
            $whatever,
            $table, 
            $paramForSelection, 
            $valueForSelection
        );
        // $whatever = what is search; example $whatever = "user_name, inscription_date"
        // $table = database table where you search
        // $paramForSelection = column like user_id
        // $valueForSelection = value inside the column like 42  
        return $result;        
    }
}