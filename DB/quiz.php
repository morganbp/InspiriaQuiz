<?php
header('Content-type: application/json');

include("db_connect.php");
if(!isset($_GET['action'])) {
	echo "No action set.\n\n";
	echo "GET parameter 'action' (required): \n 'select' or 'insert'\n\n";
	echo "GET parameter 'quizName' (required at inserts): \n Name of the quiz\n\n";
	echo "GET parameter 'prettyPrint' (optional): \n anything\n\n";
	die();
}
switch($_GET['action']){
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

			echo json_encode($output, (isset($_GET['prettyPrint'])?JSON_PRETTY_PRINT:0));
		}else{
			echo "Failed to prepare statement";
		}
	break;
	
	case 'insert':
		$quizName = $_GET['quizName'];

		if($stmt = $mysqli -> prepare("INSERT INTO quiz(QuizName) VALUES(?)")) {
			$stmt -> bind_param("s", $quizName);

			$stmt -> execute();
			$stmt -> close();
			echo "Quiz inserted";
		}else{
			echo "Failed to prepare statement";
		}
		$mysqli -> close();
	break;
}
?>