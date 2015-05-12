<?php
//header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

if(empty($_POST['SubmitJSON'])){
    die("No changes submitted.");
}else{
    $submitJSON = $_POST['SubmitJSON'];
    //print_r($_POST['SubmitJSON']);
    //die();
}



if(!empty($submitJSON['QuizID']))
   $quizID = intval($submitJSON['QuizID']);
else
    die("No QuizID submitted.");

if(!empty($submitJSON['Delete']))
   $delete = $submitJSON['Delete'];

if(!empty($submitJSON['Update']))
   $update = $submitJSON['Update'];

if(!empty($submitJSON['Insert']))
   $insert = $submitJSON['Insert'];

if(isset($delete)){
    // DELETE SINGLE ALTERNATIVES
    if(isset($delete['Alternatives']))
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
    
    // DELETE QUESTIONS
    if(isset($delete['Questions']))
    if(count($delete['Questions']) > 0){
        // First delete all the alternatives linked to the question
        if($stmt = $mysqli -> prepare('DELETE FROM Alternative WHERE QuestionID = ?;')) {
            foreach($delete['Questions'] as $q){
                $stmt -> bind_param("i", $q);
                $stmt -> execute();
            }
        }else{
            echo "Failed to prepare statement";
            http_response_code(500);
            die();
        }
        // Then delete the question
        if($stmt = $mysqli -> prepare('DELETE FROM Question WHERE QuestionID = ?;')) {
            foreach($delete['Questions'] as $q){
                $stmt -> bind_param("i", $q);
                $stmt -> execute();
            }
        }else{
            echo "Failed to prepare statement";
            http_response_code(500);
            die();
        }
    }
}

if(isset($insert)){
    // INSERT SINGLE ALTERNATIVES
    if(isset($insert['Alternatives']))
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
    
    if(isset($insert['Questions']))
    if(count($insert['Questions']) > 0){
        // First insert questions
        foreach($insert['Questions'] as $question){
            if($stmt = $mysqli -> prepare('INSERT INTO Question(QuestionText, QuestionPosition, QuizID, ImageID) VALUES(?, 1, ?, ?);')) {
                $imageID = intval($question['ImageID']);
                if($imageID == -1)
                    $imageID = null;
                
                $stmt -> bind_param("sii", $question['QuestionText'], $quizID, $imageID);
                $stmt -> execute();
                $insertedQuestionID = $stmt -> insert_id;
            }else{
                echo "Failed to prepare statement";
                http_response_code(500);
                die();
            }

            // Then insert alternatives
            if(isset($question['Alternatives'])) {
                echo "yepyep  ";
                if($stmt = $mysqli -> prepare('INSERT INTO Alternative(QuestionID, AlternativeText, AlternativeCorrect) VALUES(?, ?, ?);')) {
                    foreach($question['Alternatives'] as $alt){
                        $stmt -> bind_param("isi", $insertedQuestionID, $alt['AlternativeText'], $alt['AlternativeCorrect']);
                        $stmt -> execute();
                        print_r($alt);
                    }
                }else{
                    echo "Failed to prepare statement";
                    http_response_code(500);
                    die();
                }
            }
        }
    }
}


if(isset($update)){
    // UPDATE QUIZ NAME
    if(isset($update['QuizName'])){
        if($stmt = $mysqli -> prepare('UPDATE Quiz SET QuizName = ? WHERE QuizID = ?;')) {
            print_r($update);
            $stmt -> bind_param("si", $update['QuizName'], $quizID);
            $stmt -> execute();
        }else{
            echo "Failed to prepare statement";
            http_response_code(500);
            die();
        }
    }
    
    // UPDATE QUESTION TEXT
    if(isset($update['Questions']))
    if(count($update['Questions']) > 0){
        if($stmt = $mysqli -> prepare('UPDATE Question SET QuestionText = ?, ImageID = ? WHERE QuestionID = ?;')) {
            print_r($update);
            foreach($update['Questions'] as $question){
                $imageID = intval($question['ImageID']);
                if($imageID == -1)
                    $imageID = null;
                $stmt -> bind_param("sii", $question['QuestionText'], $imageID, $question['QuestionID']);
                $stmt -> execute();
            }
        }else{
            echo "Failed to prepare statement";
            http_response_code(500);
            die();
        }
    }
    
    // UPDATE ALTERNATIVES
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