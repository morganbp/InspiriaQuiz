<?php
session_start();

include("../API/db_connect.php"); // Make connection as $stmt

$loginEmail = $_POST['LoginEmail'];

if($stmt = $mysqli -> prepare("SELECT UserEmail FROM User WHERE UserEmail = ?")) {
    $stmt -> bind_param("s", $loginEmail);
    $stmt -> execute();
    $stmt->store_result();
    $userCount = $stmt -> num_rows;
}

if($userCount > 0){
    $_SESSION['Email'] = $loginEmail;
    header("Location: index.php");
}
?>