<?php
//header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

if(empty($_POST['SubmitJSON'])){
    die("No changes submitted.");
}else{
    $submitJSON = $_POST['SubmitJSON'];
    //print_r($_POST['SubmitJSON']);
}


if(!empty($submitJSON['Delete']))
   $delete = $submitJSON['Delete'];

if(!empty($submitJSON['Update']))
   $update = $submitJSON['Update'];

if(!empty($submitJSON['Insert']))
   $insert = $submitJSON['Insert'];

// DELETE SINGLE ALTERNATIVES
if(isset($delete))
if(count($delete['Alternatives']) > 0){
    if($stmt = $mysqli -> prepare('DELETE FROM Alternative WHERE AlternativeID = ?;')) {
        foreach($delete['Alternatives'] as $a){
            //$qID = $a;
            $stmt -> bind_param("i", $a);
            $stmt -> execute();
        }
    }else{
        echo "Failed to prepare statement";
        http_response_code(500);
        die();
    }
}

// INSERT SINGLE ALTERNATIVES
if(isset($insert))
if(count($insert['Alternatives']) > 0){
    if($stmt = $mysqli -> prepare('INSERT INTO Alternative(QuestionID, AlternativeText, AlternativeCorrect) VALUES(?, ?, ?);')) {
        foreach($insert['Alternatives'] as $alt){
            $qID = intval($alt['QuestionID']);
            $stmt -> bind_param("isi", $qID, $alt['AlternativeText'], $alt['AlternativeCorrect']);
            $stmt -> execute();
            print_r($alt);
        }
    }else{
        echo "Failed to prepare statement";
        http_response_code(500);
        die();
    }
}

if(isset($update)){
    if(isset($update['QuizName'])){
        if($stmt = $mysqli -> prepare('UPDATE Quiz SET QuizName = ? WHERE QuizID = ?;')) {
            print_r($update);
            $stmt -> bind_param("si", $update['QuizName'], $update['QuizID']);
            $stmt -> execute();
        }else{
            echo "Failed to prepare statement";
            http_response_code(500);
            die();
        }
    }
    
    if(isset($update['Questions']))
    if(count($update['Questions']) > 0){
        if($stmt = $mysqli -> prepare('UPDATE Question SET QuestionText = ? WHERE QuestionID = ?;')) {
            print_r($update);
            foreach($update['Questions'] as $question){
                $stmt -> bind_param("si", $question['QuestionText'], $question['QuestionID']);
                $stmt -> execute();
            }
        }else{
            echo "Failed to prepare statement";
            http_response_code(500);
            die();
        }
    }
    
    if(isset($update['Alternatives']))
    if(count($update['Alternatives']) > 0){
        if($stmt = $mysqli -> prepare('UPDATE Alternative SET AlternativeText = ?, AlternativeCorrect = ? WHERE AlternativeID = ?;')) {
            foreach($update['Alternatives'] as $alt){
                $altText = $alt['AlternativeText'];
                $altCorrect = intval($alt['AlternativeCorrect']);
                $altID = intval($alt['AlternativeID']);
                $stmt -> bind_param("sii", $altText, $altCorrect, $altID);
                $stmt -> execute();
            }
        }else{
            echo "Failed to prepare statement";
            http_response_code(500);
            die();
        }
    }
	
	if(isset($update['QuizOfTheDay']) && $update['QuizOfTheDay'])
		if($stmt = $mysqli -> prepare('UPDATE Quiz SET QuizOfTheDay = 0 WHERE QuizOfTheDay = 1 AND QuizID != -1;')) {
            print_r($update);
            $stmt -> execute();
			if($stmt = $mysqli->prepare('UPDATE Quiz SET QuizOfTheDay = ? WHERE QuizID = ?')){
				$stmt -> bind_param("ii", $update['QuizOfTheDay'], $submitJSON['QuizID']);
				$stmt -> execute();
			}else{
				echo "Failed to prepare statement";
				http_response_code(500);
				die();
			}
        }else{
            echo "Failed to prepare statement";
            http_response_code(500);
            die();
        }
}
?>