<?php
//header("Content-type: application/json; charset=utf-8");

include("db_connect.php");

var_dump($_POST);

if(!isset($_POST['action'])) {
	echo "No action set.\n\n";
	echo "POST parameter 'action' (required): \n 'select' or 'insert'\n\n";
	echo "POST parameter 'prettyPrint' (optional): \n true\n\n";
	die();
}

switch($_POST['action']){
	case 'select':
		$quizID = $_POST['QuizID'];
		
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
			
			// Insert questions in array
			foreach($mysql_data as $key => $alternative){
				$temporary_data[$alternative['QuestionID']] = array(
					'QuestionID' => $alternative['QuestionID'], 
					'QuestionText' => $alternative['QuestionText']);
			}
			// Insert alternatives based on QuestionID
			foreach($mysql_data as $key => $alternative){
				$temporary_data[$alternative['QuestionID']]['Alternatives'][] = array(
						'AlternativeText' => $alternative['AlternativeText'],
						'AlternativeCorrect' => $alternative['AlternativeCorrect']);
			}
			
			// Remove unwanted indexes used for structuring the JSON.
			foreach($temporary_data as $temp){
				$output[] = $temp;
			}
			
			if(isset($_POST['prettyPrint']))
				echo json_encode($output, JSON_PRETTY_PRINT);
			else
				echo json_encode($output, JSON_UNESCAPED_UNICODE);
		}else{
			echo "Failed to prepare statement";
		}
	break;
	
	case 'insert':
		$quizID = $_POST['QuizID'];
		$questionText = $_POST['QuestionText'];
		
		foreach($_POST as $key => $value){
			if(substr($key,0,11) == "Alternative"){
				$alternativeNumber = substr($key,11);
				$alternatives[] = $value;
				
				if(isset($_POST['Correct'.$alternativeNumber])){
					$correct[$alternativeNumber] = 1;
				}else{
					$correct[$alternativeNumber] = 0;
				}
			}else if(substr($key,0,7) == "Correct"){
				$correct[] = $value;
			}
		}
		var_dump($alternatives);
		var_dump($correct);
		//die();
		
		
		if($stmt = $mysqli -> prepare("INSERT INTO Question(QuestionText, QuestionPosition, QuizID, ExhibitionID) VALUES(?, 1, ?, 1)")) {
			$stmt -> bind_param("si", $questionText, $quizID);
			$stmt -> execute();
			$stmt -> close();

			echo "OK";
			$questionID = $mysqli->insert_id; // Get the questionID which was just inserted/generated
		}else{
			echo "Failed to prepare statement for question.";
		}
		
		if(!$questionID){ // questionID == null means question-insertion failed
			die("QuestionID does not exist.");
		}else{
			if($stmt = $mysqli -> prepare("INSERT INTO Alternative(AlternativeText, AlternativeCorrect, QuestionID) VALUES(?, ?, ?)")) {
				foreach($alternatives as $key => $alternativeText){
					$stmt -> bind_param("sii", $alternativeText, $correct[$key], $questionID);
					$stmt -> execute();
				}
				$stmt -> close();
			}else{
				echo "Failed to prepare statement for alternatives.";
			}
		}
	break;
}

$mysqli -> close();
?>