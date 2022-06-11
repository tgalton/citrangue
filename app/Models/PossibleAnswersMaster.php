<?php

namespace App\Models;
use Services\AllClass\DataWizard ;

class PossibleAnswersMaster extends DataWizard 
{
    public $actualTable =  "PossibleAnswersMaster"; 
    public $questionRegistrationErrors = [
        "textAnswerError" => NULL
    ] ;

    public function addNewAnswer(
        $answerTextValue,
        $isCorrectValue, 
        $questionID
    )
    {
        // $whateverToInsert = columns of insertion : All except ID
        // ID is not require because automatically generated.
        $whateverToInsert = array("answer_text", "is_correct_answer", "question_id");
        $table = $this -> actualTable;
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


    public function answerFormProcessoring(
        $answerTextValue,
        $isCorrectValue, 
        $questionID
    )
    {
        if(strlen($answerTextValue)<1020){
            $this -> addNewAnswer(
                $answerTextValue,
                $isCorrectValue, 
                $questionID
            );
            $this -> answerID = $this -> findAnswerIDbyTxtAndIsCorrect($answerTextValue, $isCorrectValue) ;
        } else {
            $this -> questionRegistrationErrors["textAnswer"] =
            "La réponse est trop longue. 1020 caractères maximum autorisé." ;
        }
    }

    public function findAnswerByQuestionId($questionId)
    {
        $valueForSelection = $questionId;
        $whatever = "possible_answer_id, answer_text, is_correct_answer";
        $table = $this -> actualTable;
        $paramForSelection = "question_id";
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

    public function findAnswerIDbyTxtAndIsCorrect($answerTextValue, $isCorrectValue)
    {   
        
        $table = $this -> actualTable;
        $connect = $this->GetPDO();
        $sql = "SELECT possible_answer_id FROM $table WHERE answer_text = :answer_text
        AND is_correct_answer = :is_correct_answer" ;
        $request = $connect->prepare($sql);
        $request->execute([
            ":answer_text" => $answerTextValue,
            ":is_correct_answer" => $isCorrectValue
        ]);
        return $request->fetch();
        

    }


}