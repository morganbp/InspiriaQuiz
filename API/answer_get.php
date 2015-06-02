<?php
header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt


// The SQL statement
$statement = "SELECT AnswerID, Answer.AlternativeID, AlternativeText, AlternativeCorrect, Alternative.QuestionID, QuestionText, Answer.UserID, UserFirstName, UserLastName, UserGender, UserAge  FROM Answer LEFT JOIN User ON Answer.UserID = User.UserID LEFT JOIN Alternative ON Answer.AlternativeID = Alternative.AlternativeID LEFT JOIN Question ON Alternative.QuestionID = Question.QuestionID";

if($stmt = $mysqli -> prepare($statement)) {
	// bind a parameter if there is one

    $stmt -> execute();

    $result = $stmt -> get_result();
    // Bind results to output-variable
    while($row = $result -> fetch_assoc()){
        $mysql_data[] = $row;
    }
    $stmt -> free_result();
    $stmt -> close();
	
    if(empty($mysql_data)){
		echo json_encode(array("QuizAnswer"=>[]), JSON_UNESCAPED_UNICODE);
        die();
    }
	
	
    //var_dump($mysql_data);
	// Add the the quizname
	$output["QuizAnswer"] = [];
	
    // Structure the JSON based on QuestionID
    foreach($mysql_data as $quizScore){
		array_push($output["QuizAnswer"], $quizScore);
    }	
	
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