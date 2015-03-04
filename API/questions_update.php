<?php
//header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

var_dump($_POST);

if(!isset($_POST['QuizID'])){
    http_response_code(404);
    die();
}
if(!isset($_POST['QuestionText'])){
    http_response_code(404);
    die();
}
if(!isset($_POST['Alternative'])){
    http_response_code(404);
    die();
}
$quizID = intval($_POST['QuizID']);
$questionText = $_POST['QuestionText'];
$questionID = $_POST['QuestionID'];
$alternativeText = $_POST['Alternative'];
$alternativeID = $_POST['AlternativeID'];
$correct = $_POST['Correct'];

//Setup for correct-array. Fill in 0 for the checkboxes that were not submitted.
foreach($alternativeID as $aKey => $aValue){
	foreach($aValue as $bKey => $bValue){
		if(isset($correct[$aKey][$bKey])){
			$correctAlternatives[$aKey][$bKey] = 1;
		}else{
			$correctAlternatives[$aKey][$bKey] = 0;
		}
	}
}

var_dump($correctAlternatives);
//die();

if($stmt = $mysqli -> prepare('UPDATE Question SET QuestionText = ? WHERE QuestionID = ?;')) {
	foreach($questionText as $key => $q){
		$qID = intval($questionID[$key]);
		$stmt -> bind_param("si", $q, $qID);
		$stmt -> execute();
	}
}else{
    echo "Failed to prepare statement";
    http_response_code(500);
    die();
}

//die();

if($stmt = $mysqli -> prepare('UPDATE Alternative SET AlternativeText = ?, AlternativeCorrect = ? WHERE AlternativeID = ?;')) {
	foreach($alternativeText as $qKey => $question){
		foreach($question as $aKey => $alternative){
			$aID = intval($alternativeID[$qKey][$aKey]);
			$stmt -> bind_param("sii", $alternative, $correctAlternatives[$qKey][$aKey], $aID);
			$stmt -> execute();
		}
	}
}else{
    echo "Failed to prepare statement";
    http_response_code(500);
    die();
}
?>