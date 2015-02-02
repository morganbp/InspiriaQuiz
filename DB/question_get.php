<?php
header("Content-type: application/json; charset=utf-8");

include("db_connect.php");

switch($_GET['action']){
	case 'select':
		if($stmt = $mysqli -> prepare("SELECT Question.QuestionID, QuestionText, AlternativeText, AlternativeCorrect FROM Question JOIN Alternative ON Question.QuestionID = Alternative.QuestionID")) {
			$stmt -> execute();

			$result = $stmt -> get_result();
			// Bind results to output-variable
			while($row = $result -> fetch_assoc()){
				$temporary_output[] = $row;
			}
			$stmt -> free_result();
			$stmt -> close();
			
			foreach($temporary_output as $key => $alternative){
				$output[$alternative['QuestionID']] = array(
					'QuestionID' => $alternative['QuestionID'], 
					'QuestionText' => $alternative['QuestionText']);
			}
			foreach($temporary_output as $key => $alternative){
				$output[$alternative['QuestionID']]['Alternatives'][] = array(
						'AlternativeText' => $alternative['AlternativeText'],
						'AlternativeCorrect' => $alternative['AlternativeCorrect']);
			}
			
			echo json_encode($output, (isset($_GET['prettyPrint'])?JSON_PRETTY_PRINT:0));
		}else{
			echo "Failed to prepare statement";
		}
	break;
}
?>