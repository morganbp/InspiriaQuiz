<?php

$target_path = "../UploadedImages/";
$extension = "." . end((explode(".", $_FILES["ImageFile"]["name"])));

do{
    $image_filename = generateRandomString() . $extension;
}while(file_exists($target_path . $image_filename));

$target_path = $target_path . $image_filename;

if(move_uploaded_file($_FILES['ImageFile']['tmp_name'], $target_path)) {
    //echo "The file ".basename($_FILES['ImageFile']['name'])." has been saved to ".$target_path;
}else{
    die("There was an error uploading the file, please try again.");
}


include("db_connect.php"); // Make connection as $stmt
$image_name = $_POST['ImageName'];

if($stmt = $mysqli -> prepare('INSERT INTO Image(ImageName, ImageFilename) VALUES(?, ?);')) {
    $stmt -> bind_param("ss", $image_name, $image_filename);
    $stmt -> execute();
}else{
    echo "Failed to prepare statement";
    http_response_code(500);
    die();
}


function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

header("Location: ../AdminPanel/images.php");
?>