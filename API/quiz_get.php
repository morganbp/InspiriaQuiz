<?php
header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

if(!isset($_POST['QuizID'])){
    http_response_code(404);
    die();
}
$inputQuizID = $_POST['QuizID'];


if($stmt = $mysqli -> prepare("SELECT QuizID, QuizName FROM Quiz WHERE QuizID = ?")){
    $stmt -> bind_param("i", $inputQuizID);
    $stmt -> execute();

    $stmt -> bind_result($quizID, $quizName);
    while($stmt->fetch()){
        $output["QuizID"] = $quizID;
        $output["QuizName"] = $quizName;
    }
    $stmt -> close();
    
}else{
    echo "Failed to prepare statement";
    http_response_code(500);
}

if($stmt = $mysqli -> prepare("SELECT Quiz.QuizID, Quiz.QuizName, 
    Question.QuestionID, Question.QuestionText, Question.ImageID, 
    AlternativeText, AlternativeCorrect, AlternativeID FROM Question 
    JOIN Alternative ON Question.QuestionID = Alternative.QuestionID  
	JOIN Quiz ON Quiz.QuizID = Question.QuizID
    WHERE Question.QuizID = ?")) {
    $stmt -> bind_param("i", $inputQuizID);
    $stmt -> execute();

    $result = $stmt -> get_result();
    // Bind results to output-variable
    while($row = $result -> fetch_assoc()){
        $mysql_data[] = $row;
    }
    $stmt -> free_result();
    $stmt -> close();
	
    
    if(empty($mysql_data)){
        $output["Questions"] = [];
    }else{
        // Structure the JSON based on QuestionID
        foreach($mysql_data as $key => $alternative){
            $temporary_data[$alternative['QuestionID']] = array(
                'QuestionID' => $alternative['QuestionID'], 
                'QuestionText' => $alternative['QuestionText'],
                'ImageID' => $alternative['ImageID']);
        }

        foreach($mysql_data as $key => $alternative){
            $temporary_data[$alternative['QuestionID']]['Alternatives'][] = array(
                    'AlternativeText' => $alternative['AlternativeText'],
                    'AlternativeCorrect' => $alternative['AlternativeCorrect'],
                    'AlternativeID' => $alternative['AlternativeID']);
        }

        // Remove unwanted indexes used for structuring the JSON.
        foreach($temporary_data as $temp){
            $output["Questions"][] = $temp;
        }
    }
}else{
    echo "Failed to prepare statement";
    http_response_code(500);
}

// Print as JSON and set status OK
if(isset($_GET['prettyPrint']))
    echo json_encode($output, JSON_PRETTY_PRINT);
else
    echo json_encode($output, JSON_UNESCAPED_UNICODE);

http_response_code(200);
?>