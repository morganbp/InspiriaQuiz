<?php
header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

if(!isset($_POST['UserFirstName']) || !isset($_POST['UserLastName']) || !isset($_POST['UserAge']) || (!isset($_POST['UserEmail']) && !isset($_POST['UserPhone'])) || !isset($_POST['UserGender'])){
	echo json_encode(array("Error" => "Invalid url arguments"), JSON_UNESCAPED_UNICODE);
	http_response_code(404);
}
$userFirstName = $_POST['UserFirstName'];
$userLastName = $_POST['UserLastName'];
$userAge = $_POST['UserAge'];
$userEmail  = (isset($_POST['UserEmail'])) ? $_POST['UserEmail'] : null;
$userPhone = (isset($_POST['UserPhone'])) ? $_POST['UserPhone'] : null;
$userGender = $_POST['UserGender'];


if(is_numeric($userAge)){
	
	if($stmt = $mysqli -> prepare("INSERT INTO User (UserFirstName,UserLastName,UserAge, UserEmail, UserPhone, UserGender) VALUES (?,?,?,?,?,?)")) {
		
		$stmt -> bind_param("ssisss", $userFirstName, $userLastName, $userAge, $userEmail, $userPhone, $userGender);
		$stmt -> execute();
		$id = $stmt -> insert_id;
		$stmt -> close();
		
		echo json_encode(array("UserID" => $id), JSON_UNESCAPED_UNICODE);
		
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