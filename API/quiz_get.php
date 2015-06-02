<?php
header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

if(!isset($_POST['QuizID'])){
    http_response_code(400);
    die();
}
$quizID = $_POST['QuizID'];

if($stmt = $mysqli -> prepare("SELECT Quiz.QuizID, Quiz.QuizName, Quiz.QuizOfTheDay, Quiz.Active, Question.QuestionID, QuestionText, 
    AlternativeText, AlternativeCorrect, AlternativeID, 
    QuestionImage.ImageFilename AS QuestionImageFilename, QuestionImage.ImageName AS QuestionImageName, QuestionImage.ImageID AS QuestionImageID, 
    Exhibit.ExhibitID, ExhibitName, ExhibitImage.ImageFilename AS ExhibitImageFilename, ExhibitImage.ImageName AS ExhibitImageName, ExhibitImage.ImageID AS ExhibitImageID
    FROM Question 
    LEFT JOIN Alternative ON Question.QuestionID = Alternative.QuestionID  
	RIGHT JOIN Quiz ON Quiz.QuizID = Question.QuizID
	LEFT JOIN Exhibit ON Exhibit.ExhibitID = Question.ExhibitID 
	LEFT JOIN Image AS QuestionImage ON QuestionImage.ImageID = Question.ImageID
	LEFT JOIN Image AS ExhibitImage ON ExhibitImage.ImageID = Exhibit.ImageID
    WHERE Quiz.QuizID = ?")) {
    $stmt -> bind_param("i", $quizID);
    $stmt -> execute();

    $result = $stmt -> get_result();
	
    // Bind results to output-variable
    while($row = $result -> fetch_assoc()){
        $mysql_data[] = $row;
    }
    $stmt -> free_result();
    $stmt -> close();

    // Add the the quizname
    $output["QuizID"] = $mysql_data[0]['QuizID'];
    $output["QuizName"] = $mysql_data[0]['QuizName'];
    $output["QuizOfTheDay"] = $mysql_data[0]['QuizOfTheDay'];
    $output["Active"] = $mysql_data[0]['Active'];

    // Structure the JSON based on QuestionID
    foreach($mysql_data as $key => $alternative){
        if($alternative['QuestionID'] == null){
            $output['Questions'] = [];
            break;
        }

        $temporary_data[$alternative['QuestionID']] = array(
            'QuestionID' => $alternative['QuestionID'], 
            'QuestionText' => $alternative['QuestionText'],
            'QuestionImageID' => $alternative['QuestionImageID'],
            'QuestionImageFilename' => $alternative['QuestionImageFilename'],
            'QuestionImageName' => $alternative['QuestionImageName'],
            'ExhibitID' => $alternative['ExhibitID'],
            'ExhibitName' => $alternative['ExhibitName'],
            'ExhibitImageID' => $alternative['ExhibitImageID'],
            'ExhibitImageFilename' => $alternative['ExhibitImageFilename'],
            'ExhibitImageName' => $alternative['ExhibitImageName'],
            'Alternatives' => array());
    }
    
    foreach($mysql_data as $key => $alternative){
        if(!isset($output['Questions']))
        array_push($temporary_data[$alternative['QuestionID']]['Alternatives'], array(
                    'AlternativeText' => $alternative['AlternativeText'],
                    'AlternativeCorrect' => $alternative['AlternativeCorrect'],
                    'AlternativeID' => $alternative['AlternativeID']));
    }
    
    // Remove unwanted indexes used for structuring the JSON.
    if(!isset($output['Questions']))
    foreach($temporary_data as $temp){
        $output["Questions"][] = $temp;
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