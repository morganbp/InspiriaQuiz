<?php
header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

if(!isset($_POST['AlternativeID']) || !isset($_POST['UserID'])){
	echo json_encode(array("Error" => "Invalid url arguments"), JSON_UNESCAPED_UNICODE);
    http_response_code(400);
    die();
}
$alternativeID = $_POST['AlternativeID'];
$userID = $_POST['UserID'];

if(is_numeric($alternativeID) && is_numeric($userID)){
	
	if($stmt = $mysqli -> prepare("INSERT INTO Answer (AlternativeID, UserID) VALUES (?,?)")) {
		
		$stmt -> bind_param("ii", $alternativeID, $userID);
		$stmt -> execute();
		$id = $stmt -> insert_id;
		$stmt -> close();
		echo json_encode(array("AnswerID" => $id), JSON_UNESCAPED_UNICODE);
		http_response_code(201);
	}else{ 	
		echo json_encode(array("Error" => "Failed to prepare statement"), JSON_UNESCAPED_UNICODE);
		http_response_code(500);
	}
}else{
	echo json_encode(array("Error" => "Invalid input types"), JSON_UNESCAPED_UNICODE);
	http_response_code(400);
}

?>