<?php
header('Content-type: application/json');

include("db_connect.php");
if(!isset($_POST['action'])) {
	echo "No action set.\n\n";
	echo "POST parameter 'action' (required): \n 'select' or 'insert'\n\n";
	echo "POST parameter 'quizName' (required at inserts): \n Name of the quiz\n\n";
	echo "POST parameter 'prettyPrint' (optional): \n anything\n\n";
	die();
}
switch($_POST['action']){
	case 'select':
		if($stmt = $mysqli -> prepare("SELECT QuizID, QuizName FROM quiz")) {
			$stmt -> execute();

			$result = $stmt -> get_result();
			// Bind results to output-variable
			while($row = $result -> fetch_assoc()){
				$output[] = $row;
			}
			$stmt -> free_result();
			$stmt -> close();

			echo json_encode($output, (isset($_POST['prettyPrint'])?JSON_PRETTY_PRINT:0));
		}else{
			echo "Failed to prepare statement";
		}
	break;
	
	case 'insert':
		$quizName = $_POST['quizName'];

		if($stmt = $mysqli -> prepare("INSERT INTO quiz(QuizName) VALUES(?)")) {
			$stmt -> bind_param("s", $quizName);

			$stmt -> execute();
			$stmt -> close();
			echo "Quiz inserted.";
		}else{
			echo "Failed to prepare statement";
		}
		$mysqli -> close();
	break;
}
?>