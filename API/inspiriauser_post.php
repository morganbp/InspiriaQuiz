<?php
header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt
include("../API/crypt.php");

if(!isset($_POST['RegisterEmail']) || !isset($_POST['RegisterPassword'])){
	echo json_encode(array("Error" => "Invalid url arguments"), JSON_UNESCAPED_UNICODE);
	http_response_code(400);
	die();
}
$regEmail = $_POST['RegisterEmail'];
$regPassword = $_POST['RegisterPassword'];
$hashedPassword = encryptInspiriaPassword($regPassword);

if($stmt = $mysqli -> prepare("INSERT INTO InspiriaUser (UserEmail, UserPassword) VALUES (?,?)")) {
    $stmt -> bind_param("ss", $regEmail, $hashedPassword);
    $stmt -> execute();
    $id = $stmt -> insert_id;
    $stmt -> close();
    
    header("Location: ../AdminPanel/users.php");
}else{
    echo json_encode(array("Error" => "Failed to prepare statement"), JSON_UNESCAPED_UNICODE);
    http_response_code(500);
}

?>