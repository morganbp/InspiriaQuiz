<?php
header('Content-type: application/json');

include("db_connect.php");

if (!isset($_POST['ExhibitID'])){
    http_response_code(400);
    die();
}


$exhibitID = $_POST['ExhibitID'];


if($stmt = $mysqli -> prepare("DELETE FROM Exhibit WHERE ExhibitID = ?;")) {

    $stmt -> bind_param("i", $exhibitID);
    $stmt -> execute();
    $stmt -> close();
    
}else{
    echo "Failed to prepare statement";
}

header("Location: ../AdminPanel/exhibits.php");
?>