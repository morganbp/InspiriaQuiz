<?php

header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

if(!isset($_POST['QuizName'])){ 
	echo json_encode(array("Error" => "Invalid url arguments"), JSON_UNESCAPED_UNICODE);
    http_response_code(404);
    die();
}
$quizName = $_POST['QuizName'];
$createdOn = (isset($_POST['CreatedOn'])) ? $_POST['CreatedOn'] : date("Y-m-d H:i:s"); 
$active = 1;
$quizOfTheDay = 0;

if($stmt = $mysqli -> prepare("INSERT INTO Quiz (QuizName, CreatedOn, Active, QuizOfTheDay) VALUES (?,?,?,?)")) {

	$stmt -> bind_param("ssii", $quizName, $createdOn, $active, $quizOfTheDay);
	$stmt -> execute();
	$id = $stmt -> insert_id;
	$stmt -> close();
	echo json_encode(array("QuizID" => $id), JSON_UNESCAPED_UNICODE);
	http_response_code(201);
}else{ 	
	echo json_encode(array("Error" => "Failed to prepare statement"), JSON_UNESCAPED_UNICODE);
	http_response_code(500);
}
?>