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
$quizID = $_POST['QuizID'];
$questionText = $_POST['QuestionText'];


//die();


if($stmt = $mysqli -> prepare('INSERT INTO Question(QuestionText, QuestionPosition, QuizID, ExhibitionID) 
VALUES(?, 1, ?, 1);')) {
    
    $stmt -> bind_param("si", $questionText, $quizID);
    $stmt -> execute();
    
    $questionID = $stmt -> insert_id;
}else{
    echo "Failed to prepare statement";
    http_response_code(500);
    die();
}

?>