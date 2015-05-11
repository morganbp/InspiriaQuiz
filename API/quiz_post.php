<?php
header('Content-type: application/json');

include("db_connect.php");

if (!isset($_POST['QuizName'])){
    http_response_code(400);
    die();
}

$quizName = $_POST['QuizName'];


if($stmt = $mysqli -> prepare("INSERT INTO Quiz(QuizName) VALUES(?);")) {

    $stmt -> bind_param("s", $quizName);
    $stmt -> execute();
    
    $quizID = $stmt -> insert_id;
    
    $stmt -> close();
    
}else{
    echo "Failed to prepare statement";
}

header("Location: ../AdminPanel/quiz_single.php?QuizID=".$quizID);
?>