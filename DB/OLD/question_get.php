<?php
header("Content-type: application/json; charset=utf-8");

include("db_connect.php");

if(!isset($_GET['action'])) {
	echo "No action set.\n\n";
	echo "GET parameter 'action' (required): \n 'select' or 'insert'\n\n";
	echo "GET parameter 'prettyPrint' (optional): \n true\n\n";
	die();
}

switch($_GET['action']){
	case 'select':
		$quizID = $_GET['QuizID'];
		
		if($stmt = $mysqli -> prepare("SELECT Question.QuestionID, QuestionText, AlternativeText, AlternativeCorrect FROM Question 
			JOIN Alternative ON Question.QuestionID = Alternative.QuestionID
			WHERE Question.QuizID = ?")) {
			$stmt -> bind_param("i", $quizID);
			$stmt -> execute();

			$result = $stmt -> get_result();
			// Bind results to output-variable
			while($row = $result -> fetch_assoc()){
				$mysql_data[] = $row;
			}
			$stmt -> free_result();
			$stmt -> close();
			
			if(empty($mysql_data)){
				die("No results returned.");
			}
			
			//var_dump($mysql_data);
			
			// Structure the JSON based on QuestionID
			foreach($mysql_data as $key => $alternative){
				$temporary_data[$alternative['QuestionID']] = array(
					'QuestionID' => $alternative['QuestionID'], 
					'QuestionText' => $alternative['QuestionText']);
			}
			foreach($mysql_data as $key => $alternative){
				$temporary_data[$alternative['QuestionID']]['Alternatives'][] = array(
						'AlternativeText' => $alternative['AlternativeText'],
						'AlternativeCorrect' => $alternative['AlternativeCorrect']);
			}
			
			// Remove unwanted indexes used for structuring the JSON.
			foreach($temporary_data as $temp){
				$output[] = $temp;
			}
			
			if(isset($_GET['prettyPrint']))
				echo json_encode($output, JSON_PRETTY_PRINT);
			else
				echo json_encode($output, JSON_UNESCAPED_UNICODE);
		}else{
			echo "Failed to prepare statement";
		}
	break;
}
?>