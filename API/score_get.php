<?php
header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

$argument = ""; // If there is a post argument, this will get stored here

// The SQL statement
$statement = "SELECT QuizScore.UserID, TotalScore, QuizScore.Date , UserAge, UserFirstName, UserLastName, UserCode, UserEmail, UserPhone, UserGender, GroupName, GroupLeaderName, GroupLeaderEmail, GroupLeaderPhone, Quiz.QuizID, QuizName, CreatedOn FROM QuizScore LEFT JOIN User ON QuizScore.UserID = User.UserID LEFT JOIN bo15g21.Group ON User.GroupID = bo15g21.Group.GroupID LEFT JOIN Quiz ON QuizScore.QuizID = Quiz.QuizID";


// Checks whether QuizID or UserID is a post value. 
// If both values are set, only QuizID will be used
if(isset($_POST['QuizID'])){
	$statement .= " WHERE QuizScore.QuizID = ?"; 
	$argument = $_POST['QuizID'];
}else if(isset($_POST['UserID'])){
	$statement .= " WHERE QuizScore.UserID = ?";
	$argument = $_POST['UserID'];
}


$statement .= " ORDER BY QuizScore.QuizID, QuizScore.TotalScore DESC";


if($stmt = $mysqli -> prepare($statement)) {
	// bind a parameter if there is one
	if($argument != ""){
    	$stmt -> bind_param("i", $argument);
	}
    $stmt -> execute();

    $result = $stmt -> get_result();
    // Bind results to output-variable
    while($row = $result -> fetch_assoc()){
        $mysql_data[] = $row;
    }
    $stmt -> free_result();
    $stmt -> close();
	
    if(empty($mysql_data)){
        http_response_code(404);
        die();
    }
	
	
    //var_dump($mysql_data);
	// Add the the quizname
	$output["QuizScore"] = [];
	
    // Structure the JSON based on QuestionID
    foreach($mysql_data as $quizScore){
		$temporary_data = array(
				'UserID' => $quizScore['UserID'],
				'TotalScore' => $quizScore['TotalScore'],
				'Date' => $quizScore['Date'],
				'UserAge' => $quizScore['UserAge'],
				'UserFirstName' => $quizScore['UserFirstName'],
				'UserLastName' => $quizScore['UserLastName'],
				'UserCode' => $quizScore['UserCode'],
				'UserEmail' => $quizScore['UserEmail'],
				'UserPhone' => $quizScore['UserPhone'],
				'UserGender' => $quizScore['UserGender'],
				'GroupName' => $quizScore['GroupName'],
				'GroupLeaderName' => $quizScore['GroupLeaderName'],
				'GroupLeaderEmail' => $quizScore['GroupLeaderEmail'],
				'GroupLeaderPhone' => $quizScore['GroupLeaderPhone'],
				'QuizID' => $quizScore['QuizID'],
				'QuizName' => $quizScore['QuizName']);
		array_push($output["QuizScore"], $temporary_data);
    }	
	
    if(isset($_GET['prettyPrint']))
        echo json_encode($output, JSON_PRETTY_PRINT);
    else
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
    http_response_code(200);
}else{
    echo "Failed to prepare statement";
    http_response_code(500);
}
?>