<?php
header('Content-type: application/json');

include("db_connect.php");

if (!isset($_POST['UserID'])){
    echo json_encode(array("Error" => "Invalid arguments"), JSON_UNESCAPED_UNICODE);
    http_response_code(400);
    die();
}

$userID = intval($_POST['UserID']);

if($stmt = $mysqli -> prepare("DELETE FROM InspiriaUser WHERE UserID = ?;")) {   
    $stmt -> bind_param("i", $userID);
    $stmt -> execute();
    $stmt -> close();
    
    echo json_encode(array("Success" => "User deleted"), JSON_UNESCAPED_UNICODE);
    http_response_code(204);
}else{ 	
    echo json_encode(array("Error" => "Failed to prepare statement"), JSON_UNESCAPED_UNICODE);
    http_response_code(500);
}
?>