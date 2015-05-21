<?php
header('Content-type: text/plain');

include("db_connect.php");

if (!isset($_POST['QuizID'])){
    http_response_code(400);
    die();
}


$quizID = $_POST['QuizID'];


if($stmt = $mysqli -> prepare("UPDATE Quiz SET Active = 0 WHERE QuizID = ?;")) {
    $stmt -> bind_param("i", $quizID);
    $stmt -> execute();
    $stmt -> close();
    
    http_response_code(204);
}else{
    echo "Failed to prepare statement";
}
?>