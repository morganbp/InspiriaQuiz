<?php

include("db_connect.php"); // Make connection as $stmt

$imageID = $_POST['ImageID'];

if($stmt = $mysqli -> prepare("UPDATE Image SET Active = 0 WHERE ImageID = ?")) {
    $stmt -> bind_param("i", $imageID);
    $stmt -> execute();
}else{
    echo "Failed to prepare statement";
    http_response_code(500);
    die();
}

?>