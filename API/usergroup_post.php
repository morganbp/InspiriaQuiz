<?php
header('Content-type: application/json; charset=utf-8;');

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

// Get all user codes for duplicate-checking
if($stmt = $mysqli -> prepare("SELECT UserCode FROM User;")) {
    $stmt -> execute();
    
    $stmt -> bind_result($code);
    while($stmt -> fetch()){
        $dbCodes[] = $code;
    }
}else{ 	
    echo json_encode(array("Error" => "Failed to prepare statement"), JSON_UNESCAPED_UNICODE);
    http_response_code(500);
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
    
    do{
        $randomCode = generateRandomString(6);
    }while(codeAlreadyExists($randomCode));
    $userCode[] = $randomCode;
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

if($stmt = $mysqli -> prepare("INSERT INTO User (UserFirstName, UserLastName, UserAge, UserCode, GroupID) VALUES (?,?,?,?,?)")) {
    foreach($firstName as $key => $value){
        $stmt -> bind_param("ssisi", $firstName[$key], $lastName[$key], $age[$key], $userCode[$key], $groupID);
        $stmt -> execute();
    }
}else{ 	
    echo json_encode(array("Error" => "Failed to prepare statement"), JSON_UNESCAPED_UNICODE);
    http_response_code(500);
    die();
}

// Deactivate registration code
if($stmt = $mysqli -> prepare("UPDATE RegistrationCode SET Active = 0, GroupID = ? WHERE RegistrationCode LIKE ?")) {
    $stmt -> bind_param("is", $groupID, $registrationCode);
    $stmt -> execute();
}else{ 	
    echo json_encode(array("Error" => "Failed to prepare statement"), JSON_UNESCAPED_UNICODE);
    http_response_code(500);
    die();
}

echo json_encode(array("GroupID" => $groupID), JSON_UNESCAPED_UNICODE);
http_response_code(201);







/* FUNCTIONS */
function generateRandomString($length = 20) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function codeAlreadyExists($codeToCheck){
    global $dbCodes;
    
    foreach($dbCodes as $code){
        if($code == $codeToCheck)
            return true;
    }
    return false;
}
?>