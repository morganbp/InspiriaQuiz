<?php
header('Content-type: application/json; charset=utf-8;');

include("db_connect.php"); // Make connection as $stmt

if($stmt = $mysqli -> prepare('SELECT GroupID, GroupName, GroupLeaderName, QuizID, 
    (SELECT COUNT(*) FROM User AS t2 WHERE t2.GroupID = t1.GroupID) AS GroupUsers
    FROM UserGroup AS t1
    ORDER BY GroupName;')) {
    
    $stmt -> execute();
    $result = $stmt -> get_result();
    
    // Bind results to output-variable
    while($row = $result -> fetch_assoc()){
        $output[] = $row;
    }
    $stmt -> free_result();
    $stmt -> close();
}else{
    echo "Failed to prepare statement";
    http_response_code(500);
    die();
}

echo json_encode($output);
?>