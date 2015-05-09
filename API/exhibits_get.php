<?php
header('Content-type: application/json');

include("db_connect.php");

if($stmt = $mysqli -> prepare("SELECT ExhibitID, ExhibitName, ExhibitDescription, Image.ImageID, Image.ImageFilename
    FROM Exhibit JOIN Image
    ON Exhibit.ImageID = Image.ImageID
    ORDER BY ExhibitName ASC")) {
    
    $stmt -> execute();
    $result = $stmt -> get_result();
    
    // Bind results to output-variable
    while($row = $result -> fetch_assoc()){
        $output[] = $row;
    }
    $stmt -> free_result();
    $stmt -> close();
    
    if(isset($_GET['prettyPrint']))
        echo json_encode($output, JSON_PRETTY_PRINT);
    else
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
}else{
    echo "Failed to prepare statement";
}
?>