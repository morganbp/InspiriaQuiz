<?php

$icons["index.php"] = "<i class='flaticon-home63'></i>";
$icons["quiz_list.php"] = "<i class='flaticon-question1'></i>";
$icons["image_upload.php"] = "<i class='flaticon-picture64'></i>";
$icons["index.php#"] = "<i class='flaticon-log'></i>";

$pages["index.php"] = "Dashboard";
$pages["quiz_list.php"] = "Quizer";
$pages["image_upload.php"] = "Bilder";
$pages["index.php#"] = "Logg ut";

foreach($pages as $url => $page){
    if($url == $activepage)
        echo "<li><a href=".$url." class='selected'>".$icons[$url]."<span class='page-title'>".$page."</span></a></li>";
    else
        echo "<li><a href=".$url.">".$icons[$url]."<span class='page-title'>".$page."</span></a></li>";
}

?>