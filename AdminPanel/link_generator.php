<?php
header('Content-type: application/json; charset=utf-8;');

include("../API/db_connect.php"); // Make connection as $stmt


if($stmt = $mysqli -> prepare("SELECT RegistrationCode FROM RegistrationCode WHERE Active = 1;")) {
    $stmt -> execute();
    
    $stmt -> bind_result($code);
    while($stmt -> fetch()){
        $codes[] = $code;
    }
}else{ 	
    echo json_encode(array("Error" => "Failed to prepare statement"), JSON_UNESCAPED_UNICODE);
    http_response_code(500);
    die();
}



do{
    $randomCode = generateRandomString();
}while(codeAlreadyExists($randomCode));


if($stmt = $mysqli -> prepare("INSERT INTO RegistrationCode(RegistrationCode, Active) VALUES(?, 1);")) {
    $stmt -> bind_param("s", $randomCode);
    $stmt -> execute();
    
    $stmt -> close();
}else{ 	
    echo json_encode(array("Error" => "Failed to prepare statement"), JSON_UNESCAPED_UNICODE);
    http_response_code(500);
    die();
}



echo json_encode(array(
    "RegistrationCode" => $randomCode,
    "RegistrationPath" => 'http://frigg.hiof.no/bo15-g21/Register/register.php?RegistrationCode=' . $randomCode),
    JSON_UNESCAPED_UNICODE);




/* FUNCTIONS */
function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function codeAlreadyExists($codeToCheck){
    global $codes;
    
    foreach($codes as $code){
        if($code == $codeToCheck)
            return true;
    }
    return false;
}
?>