<?php
// Database info
$host="localhost";
$username="root";
$password="";
$db_name="inspiria_quiz";

// Connect to mysql and select the database
$mysqli = new mysqli("$host", "$username", "$password", "$db_name"); 

if(mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	die();
}

mysqli_set_charset($mysqli, 'utf8');
?>