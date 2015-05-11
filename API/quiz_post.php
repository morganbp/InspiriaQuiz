<?php
<<<<<<< HEAD
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
=======
header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

if(!isset($_GET['QuizName'])){ 
	echo json_encode(array("Error" => "Invalid url arguments"), JSON_UNESCAPED_UNICODE);
    http_response_code(404);
    die();
}
$quizName = $_GET['QuizName'];
$createdOn = (isset($_GET['CreatedOn'])) ? $_GET['CreatedOn'] : date("Y-m-d H:i:s"); 
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

>>>>>>> 51d73952d2ac1c28b4d57a69ed16cf4328ee9795
?>