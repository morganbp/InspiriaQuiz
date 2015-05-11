<?php
header('Content-type: application/json');

include("db_connect.php");

if($stmt = $mysqli -> prepare("SELECT QuizID, QuizName, CreatedOn, Active, QuizOfTheDay,
        (SELECT COUNT(*) FROM Question WHERE Quiz.QuizID = Question.QuizID) AS Questions 
        FROM Quiz
        WHERE Active = 1
        ORDER BY Quiz.QuizName")) {
    
    $stmt -> execute();

    $result = $stmt -> get_result();
    // Bind results to output-variable
    while($row = $result -> fetch_assoc()){
        $output[] = $row;
    }
    $stmt -> free_result();
    $stmt -> close();

    if(isset($_GET['prettyPrint']))
        echo json_encode($output, JSON_PRETTY_PRINT);
    else
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
}else{
	echo json_encode('{"Error":"Failed to prepare statement"}', JSON_UNESCAPED_UNICODE);
}
?>