<?php
require_once "../vendor/autoload.php";

$content = file_get_contents("php://input");
$data = json_decode($content, true);


// Validation 
$notionID = $data["notionID"];
$questionTypeID = $data["questionTypeID"];
$illustrated = $data["illustrated"];
$timeRequireAmount = $data["timeRequireAmount"];
$txtNewQuestion = $data["txtNewQuestion"];

use App\Models\QuestionsComplexities ;
$questionsComplexities = new QuestionsComplexities ;
$difficultyID = $questionsComplexities -> findComplexityIDByDuration($timeRequireAmount) ;

use App\Models\QuestionsMaster ;
$questionsMaster = new QuestionsMaster ;
$questionsMaster -> questionFormProcessoring(
    $notionID,
    $questionTypeID,
    $illustrated,
    $difficultyID,
    $txtNewQuestion,
);

$errorQuestionText = $questionsMaster-> questionRegistrationErrors["textQuestion"] ;
$questionID = $questionsMaster -> questionID ;

$res = [
    "errorQuestionText" => $errorQuestionText,
    "questionID" => $questionID,
];


echo json_encode($res);


