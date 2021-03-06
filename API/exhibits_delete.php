<?php
header('Content-type: application/json');

include("db_connect.php");

if (!isset($_POST['ExhibitID'])){
    echo json_encode(array("Error" => "Invalid arguments"), JSON_UNESCAPED_UNICODE);
    http_response_code(400);
    die();
}

$exhibitID = intval($_POST['ExhibitID']);


if($stmt = $mysqli -> prepare("DELETE FROM Exhibit WHERE ExhibitID = ?;")) {
    $stmt -> bind_param("i", $exhibitID);
    $stmt -> execute();
    $stmt -> close();
    
    echo json_encode(array("Success" => "User deleted"), JSON_UNESCAPED_UNICODE);
    http_response_code(204);
}else{ 	
    echo json_encode(array("Error" => "Failed to prepare statement"), JSON_UNESCAPED_UNICODE);
    http_response_code(500);
}
?>