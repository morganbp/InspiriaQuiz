<?php
//header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

if(empty($_POST['SubmitJSON'])){
    die("No changes submitted.");
}else{
    $submitJSON = $_POST['SubmitJSON'];
    //print_r($_POST['SubmitJSON']);
}


print_r($delete = $submitJSON['Delete']);

if($stmt = $mysqli -> prepare('DELETE FROM Alternative WHERE AlternativeID = ?;')) {
	foreach($delete['Alternatives'] as $a){
		$qID = $a;
		$stmt -> bind_param("i", $a);
		$stmt -> execute();
	}
}else{
    echo "Failed to prepare statement";
    http_response_code(500);
    die();
}

die();

if($stmt = $mysqli -> prepare('UPDATE Alternative SET AlternativeText = ?, AlternativeCorrect = ? WHERE AlternativeID = ?;')) {
	foreach($alternativeText as $qKey => $question){
		foreach($question as $aKey => $alternative){
			$aID = intval($alternativeID[$qKey][$aKey]);
			$stmt -> bind_param("sii", $alternative, $correctAlternatives[$qKey][$aKey], $aID);
			$stmt -> execute();
		}
	}
}else{
    echo "Failed to prepare statement";
    http_response_code(500);
    die();
}
?>