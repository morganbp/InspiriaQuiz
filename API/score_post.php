<?php
header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

if(!isset($_POST['QuizID']) || !isset($_POST['UserID']) || !isset($_POST['Score'])){
    http_response_code(404);
    die();
}
$quizID = $_POST['QuizID'];
$userID = $_POST['UserID'];
$score = $_POST['Score'];
$date = (isset($_POST['Date'])) ? $_POST['Date'] : date("Y-m-d H:i:s"); 

if(is_numeric($quizID) && is_numeric($userID) && is_numeric($score)){
	
	if($stmt = $mysqli -> prepare("INSERT INTO QuizScore (UserID,QuizID,TotalScore, Date) VALUES (?,?,?,?)")) {
		
		$stmt -> bind_param("iiis", $userID, $quizID, $score, $date);
		$stmt -> execute();
		$result = $stmt -> get_result();

		$stmt -> free_result();
		$stmt -> close();
		echo '{}';
		http_response_code(201);
	}else{ 	
		echo '{"error":"Failed to prepare statement"}';
		http_response_code(500);
	}
}else{
	echo '{"error":"Invalid input types"}';
	http_response_code(400);
}

?>