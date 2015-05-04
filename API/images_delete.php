<?php

include("db_connect.php"); // Make connection as $stmt

$imageID = $_POST['ImageID'];

if($stmt = $mysqli -> prepare("DELETE FROM Image WHERE ImageID = ?")) {
    $stmt -> bind_param("i", $imageID);
    $stmt -> execute();
}else{
    echo "Failed to prepare statement";
    http_response_code(500);
    die();
}

?>