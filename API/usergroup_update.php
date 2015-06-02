<?php
header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

if(!isset($_POST['QuizID']) || $_POST['QuizID'] == '' ||
    !isset($_POST['GroupID']) || $_POST['GroupID'] == ''){
	echo json_encode(array("Error" => "Invalid url arguments"), JSON_UNESCAPED_UNICODE);
	http_response_code(400);
	die();
}

$groupID = $_POST['GroupID'];
$quizID = $_POST['QuizID'];
if($quizID == 0)
    $quizID = null;

if($stmt = $mysqli -> prepare("UPDATE UserGroup SET QuizID = ? WHERE GroupID = ?;")) {
    $stmt -> bind_param("ii", $quizID, $groupID);
    $stmt -> execute();
}else{ 	
    echo json_encode(array("Error" => "Failed to prepare statement"), JSON_UNESCAPED_UNICODE);
    http_response_code(500);
    die();
}

echo json_encode(array("GroupID" => $groupID, "QuizID" => $quizID), JSON_UNESCAPED_UNICODE);
?>