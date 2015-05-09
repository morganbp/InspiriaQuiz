<?php
header('Content-type: application/json');

include("db_connect.php");

if (!isset($_POST['ExhibitName']) || !isset($_POST['ExhibitDescription']) || !isset($_POST['ImageID'])){
    http_response_code(400);
    die();
}


$exhibitName = $_POST['ExhibitName'];
$exhibitDescription = $_POST['ExhibitDescription'];
$imageID = ($_POST['ImageID'] == -1) ? null : $_POST['ImageID'];


if($stmt = $mysqli -> prepare("INSERT INTO Exhibit(ExhibitName, ExhibitDescription, ImageID)
    VALUES(?, ?, ?);")) {

    $stmt -> bind_param("ssi", $exhibitName, $exhibitDescription, $imageID);
    $stmt -> execute();
    $stmt -> close();
    
}else{
    echo "Failed to prepare statement";
}

header("Location: ../AdminPanel/exhibits.php");
?>