<?php
session_start();

include("../API/db_connect.php"); // Make connection as $stmt
include("../API/crypt.php");

$loginEmail = $_POST['LoginEmail'];
$loginPassword = $_POST['LoginPassword'];

$hashedPassword = encryptInspiriaPassword($loginPassword);

if($stmt = $mysqli -> prepare("SELECT UserEmail FROM InspiriaUser WHERE UserEmail LIKE ? AND UserPassword LIKE ?")) {
    $stmt -> bind_param("ss", $loginEmail, $hashedPassword);
    $stmt -> execute();
    $stmt -> store_result();

    $userCount = $stmt -> num_rows;
    
    $stmt -> free_result();
    $stmt -> close();
}else{
    die("Failed to prepare the statement.");
}

if($userCount > 0){
    $_SESSION['Email'] = $loginEmail;
    header("Location: index.php");
}else{
    header("Location: login.php");
}
?>