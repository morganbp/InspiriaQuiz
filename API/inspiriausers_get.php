<?php
header('Content-type: application/json');

include("db_connect.php");

if($stmt = $mysqli -> prepare("SELECT UserID, UserEmail
    FROM InspiriaUser
    ORDER BY UserEmail ASC")) {
    
    $stmt -> execute();
    $result = $stmt -> get_result();
    
    // Bind results to output-variable
    while($row = $result -> fetch_assoc()){
        $output[] = $row;
    }
    $stmt -> free_result();
    $stmt -> close();
    
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}else{
    echo "Failed to prepare statement";
}
?>