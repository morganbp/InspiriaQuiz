<?php
//header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

if(!isset($_POST['GroupName']) || $_POST['GroupName'] == '' ||
   !isset($_POST['GroupLeaderName']) || $_POST['GroupLeaderName'] == '' ||
   !isset($_POST['GroupLeaderEmail']) || $_POST['GroupLeaderEmail'] == '' ||
   !isset($_POST['GroupLeaderPhone']) || $_POST['GroupLeaderPhone'] == '' ||
   !isset($_POST['RegistrationCode'])){
	echo json_encode(array("Error" => "Invalid url arguments"), JSON_UNESCAPED_UNICODE);
	http_response_code(400);
	die();
}

$registrationCode = $_POST['RegistrationCode'];
$groupName = $_POST['GroupName'];
$groupLeaderName = $_POST['GroupLeaderName'];
$groupLeaderEmail = $_POST['GroupLeaderEmail'];
$groupLeaderPhone = intval($_POST['GroupLeaderPhone']);

foreach($_POST['FirstName'] as $key => $value){
    if($_POST['FirstName'][$key] == '' || $_POST['LastName'][$key] == '')
        continue;
    
    $firstName[] = $_POST['FirstName'][$key];
    $lastName[] = $_POST['LastName'][$key];
    
    // If no age is submitted for this person, set to null 
    // so that $age has the same number of elements as $firstName and $lastName
    $age[] = ($_POST['Age'][$key] == '') ? null : intval($_POST['Age'][$key]);
}

if(!isset($firstName) || !isset($lastName)){
    echo json_encode(array("Error" => "Invalid url arguments"), JSON_UNESCAPED_UNICODE);
	http_response_code(400);
    die();
}

if($stmt = $mysqli -> prepare("INSERT INTO UserGroup (GroupName, GroupLeaderName, GroupLeaderEmail, GroupLeaderPhone) VALUES (?,?,?,?)")) {
    $stmt -> bind_param("sssi", $groupName, $groupLeaderName, $groupLeaderEmail, $groupLeaderPhone);
    $stmt -> execute();
    $groupID = $stmt -> insert_id;
}else{ 	
    echo json_encode(array("Error" => "Failed to prepare statement"), JSON_UNESCAPED_UNICODE);
    http_response_code(500);
    die();
}

if($stmt = $mysqli -> prepare("INSERT INTO User (UserFirstName, UserLastName, UserAge, GroupID) VALUES (?,?,?,?)")) {
    foreach($firstName as $key => $value){
        $stmt -> bind_param("ssii", $firstName[$key], $lastName[$key], $age[$key], $groupID);
        $stmt -> execute();
    }
}else{ 	
    echo json_encode(array("Error" => "Failed to prepare statement"), JSON_UNESCAPED_UNICODE);
    http_response_code(500);
    die();
}

if($stmt = $mysqli -> prepare("UPDATE RegistrationCode SET Active = 0 WHERE RegistrationCode LIKE ?")) {
    $stmt -> bind_param("s", $registrationCode);
    $stmt -> execute();
}else{ 	
    echo json_encode(array("Error" => "Failed to prepare statement"), JSON_UNESCAPED_UNICODE);
    http_response_code(500);
    die();
}

echo json_encode(array("Success" => "Group inserted"), JSON_UNESCAPED_UNICODE);
http_response_code(201);

?>