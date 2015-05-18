<?php
header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

// The base select statement 
$statement = "SELECT UserID, UserAge, UserFirstName, UserLastName, UserCode, UserEmail, UserPhone, UserGender, UserGroup.GroupID, GroupName, GroupLeaderName, GroupLeaderEmail, GroupLeaderPhone, QuizID FROM User JOIN UserGroup ON User.GroupID = UserGroup.GroupID";

// The data collected from post 
$data;
$datatype;
$output;
if(isset($_POST['UserID'])){
	$data = $_POST['UserID'];
	$statement .= " WHERE UserID=?";
	$datatype = "i";
}else if(isset($_POST['UserCode'])){
	$data = $_POST['UserCode'];
	$statement .= " WHERE UserCode=?";
	$datatype = "s";
}else{
	$output["Error"] = "Ugyldig input";
	echo json_encode($output, JSON_UNESCAPED_UNICODE);
	http_response_code(404);
    die();
}


if($stmt = $mysqli -> prepare($statement)) {
    $stmt -> bind_param($datatype, $data);
    $stmt -> execute();

    $result = $stmt -> get_result();
    // Bind results to output-variable
    while($row = $result -> fetch_assoc()){
        $mysql_data[] = $row;
    }
    $stmt -> free_result();
    $stmt -> close();
	
    if(empty($mysql_data)){
		$output["Error"] = "Fant ikke brukeren";
		echo json_encode($output, JSON_UNESCAPED_UNICODE);
        http_response_code(404);
        die();
    }
    //var_dump($mysql_data);
	// Add all data from the one user
	$output;
	foreach($mysql_data as $key => $columns)
		foreach($columns as $key => $columnData)
			$output[$key] = $columnData;
			
    
	
	
    if(isset($_GET['prettyPrint']))
        echo json_encode($output, JSON_PRETTY_PRINT);
    else
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
    http_response_code(200);
}else{
	$output["Error"] = "Feil på server.";
	echo json_encode($output, JSON_UNESCAPED_UNICODE);
    http_response_code(500);
}
?>