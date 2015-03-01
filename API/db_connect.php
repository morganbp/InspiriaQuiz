<?php
// Database info
//$host="localhost";
$host="frigg.hiof.no";
$username="bo15g21";
$password="bo15g21QUIZ";
$db_name="bo15g21";

// Connect to mysql and select the database
$mysqli = new mysqli("$host", "$username", "$password", "$db_name"); 

if(mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	die();
}

mysqli_set_charset($mysqli, 'utf8');
?>