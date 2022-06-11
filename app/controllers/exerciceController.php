<?php

// app\controllers\asideController.php


// ****** UNIT  //
// We want need to find the ID of the selected Unity
use App\Models\UnitsMaster ;
$unitsMaster = new UnitsMaster ;
$unitName = $_GET["name"] ;
$unitID = $unitsMaster -> findUnit("unit_id", "unit_name", $unitName) ;
// var_dump($unitID) ;

// Next step : We want to find all the notions from this Unity
use App\Models\NotionsMaster ;
$notionsMaster = new NotionsMaster ;
$notionArray = $notionsMaster -> notionsByUnitID($unitID) ;
// var_dump($notionArray) ;

// Next step : We make an array with all the questions (questions -> notions ID)
use App\Models\QuestionsMaster ;
$questionsMaster = new QuestionsMaster ;
$lenghtNotionArray = count($notionArray) ;
$questionArray = [] ;
$k = 0 ;
for($i = 0 ; $i < $lenghtNotionArray ; $i++){
    
    // var_dump($questionsMaster -> findQuestionIdByNotionId($notionArray[$i]['notion_id'])) ;
    $temporaryArray = $questionsMaster -> findQuestionIdByNotionId($notionArray[$i]['notion_id']) ;
    // var_dump($temporaryArray) ;
    $lenghtTemporaryArray = count($temporaryArray) ;
    $j = 0 ;
    for($j = 0; $j < $lenghtTemporaryArray ; $j++) {
        $questionArray[$k]['question_id'] = $temporaryArray[$j]['question_id'] ;
        $questionArray[$k]['notion_id'] = $temporaryArray[$j]['notion_id'] ;
        $questionArray[$k]['question_type_id'] = $temporaryArray[$j]['question_type_id'] ;
        $questionArray[$k]['is_illustrated'] = $temporaryArray[$j]['is_illustrated'] ;
        $questionArray[$k]['complexity_id'] = $temporaryArray[$j]['complexity_id'] ;
        $questionArray[$k]['question_text'] = $temporaryArray[$j]['question_text'] ;
        $k++ ;
    }
}

// Select 20 question : one by notion and randomly after that.
$selectedQuestionArray = [] ;
    // Make a list of notion
$questionArrayLenght = count($questionArray);
$notionList = [] ;
        //If the value existe inside $notionList, continue, else write it inside. 
        // (cannot use $notionArray because notion could haven't questions)
for($i = 0; $i < $questionArrayLenght; $i++){
    if((array_search($questionArray[$i]['notion_id'], $notionList)) === FALSE){
        array_push($notionList, $questionArray[$i]['notion_id']);
    }
}

    // If there are more than 20 notions, take 20 randomly
$notionListLenght = count($notionList);
for($notionListLenght ; $notionListLenght > 20 ; $notionListLenght--) {
    shuffle($notionList);
    unset($notionList[20]);
}
// 
    // If there are 20 or less notions, take them all.

    // Take randomly 1 question by notion. Delete them from questionArray.
$finalSelectionOfQuestion = [];
function searchForId($id, $arrayOfArrays) {
    $questionsPerNotionId = [] ;
    foreach ($arrayOfArrays as $arrayKey => $val) {
        if ($val['notion_id'] === $id) {
            return $arrayOfArrays[$arrayKey];
        }
    }
    return null;
}
foreach($notionList as $id){
    $temporaryArray = [] ;
    array_push($temporaryArray, searchForId($id, $questionArray));
    // var_dump ($temporaryArray);
    shuffle($temporaryArray) ;
    array_push($finalSelectionOfQuestion, $temporaryArray[0]) ;
    // unset($questionArray, $questionArray -> $temporaryArray[0]) ;
}

    // If there are not enough questions take them one by one randomly, delete them one by one.
for($i = count($finalSelectionOfQuestion); $i<20; $i++){
    $max = count($questionArray)-1 ;
    $alea = rand(0, $max);
    array_push($finalSelectionOfQuestion, $questionArray[$alea]) ;
}
// Add responses into $finalSelectionOfQuestion
use App\Models\PossibleAnswersMaster ;
$possibleAnswersMaster = new PossibleAnswersMaster ;
$finalSelectionOfQuestionLenght = count($finalSelectionOfQuestion) ;
for($i=0 ; $i < $finalSelectionOfQuestionLenght; $i++){
    $oneQuestionId = $finalSelectionOfQuestion[$i]["question_id"] ;
    $temporaryArray = $possibleAnswersMaster -> findAnswerByQuestionId($oneQuestionId) ;
    // $temporaryArray["answer0"] = $temporaryArray[0] ;
    // $temporaryArray["answer1"] = $temporaryArray[1] ;
    // $temporaryArray["answer2"] = $temporaryArray[2] ;
    // $temporaryArray["answer3"] = $temporaryArray[3] ;
    // unset($temporaryArray[0]) ;
    // unset($temporaryArray[1]) ;
    // unset($temporaryArray[2]) ;
    // unset($temporaryArray[3]) ;
    // var_dump($temporaryArray);
    $finalSelectionOfQuestion[$i] = array_merge($finalSelectionOfQuestion[$i], $temporaryArray);
    // var_dump($finalSelectionOfQuestion[$i]);
}
// var_dump($finalSelectionOfQuestion) ;
$php_data = $finalSelectionOfQuestion ;


require_once "../app/views/exercice.phtml";