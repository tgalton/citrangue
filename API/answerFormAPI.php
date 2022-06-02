<?php
require_once "../vendor/autoload.php";

$content = file_get_contents("php://input");
$data = json_decode($content, true);

// Validation 
$txtNewAnswer = $data["txtNewAnswer"];
$isCorrect = $data["isCorrect"];
$QuestionID = $data["QuestionID"];

use App\Models\PossibleAnswersMaster ;
$possibleAnswersMaster = new PossibleAnswersMaster ;
$possibleAnswersMaster -> answerFormProcessoring(
    $txtNewAnswer,
    $isCorrect,
    $QuestionID,
    // $answerTextValue,
    // $isCorrectValue, 
    // $questionID
);

$textAnswerError = $possibleAnswersMaster -> questionRegistrationErrors["textAnswerError"];

$res = [
    "textAnswerError" => $textAnswerError
];

echo json_encode($res);