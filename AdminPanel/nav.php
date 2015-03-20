<?php

$icons["index.php"] = "<i class='flaticon-home63'></i>";
$icons["quiz_list.php"] = "<i class='flaticon-question1'></i>";
$icons["logout.php"] = "<i class='flaticon-log'></i>";

$pages["index.php"] = "Dashboard";
$pages["quiz_list.php"] = "Quizer";
$pages["logout.php"] = "Logg ut";

foreach($pages as $url => $page){
    if($url == $activepage)
        echo "<li><a href=".$url." class='selected'>".$icons[$url]."<span class='page-title'>".$page."</span></a></li>";
    else
        echo "<li><a href=".$url.">".$icons[$url]."<span class='page-title'>".$page."</span></a></li>";
}

?>