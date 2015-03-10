<?php

$pages["index.php"] = "<i class='flaticon-home63'></i>Dashboard";
$pages["quiz_list.php"] = "<i class='flaticon-question1'></i>Quizer";
$pages["logout.php"] = "<i class='flaticon-log'></i>Logg ut";

foreach($pages as $url => $page){
    if($url == $activepage)
        echo "<li><a href=".$url." class='selected'>".$page."</a></li>";
    else
        echo "<li><a href=".$url.">".$page."</a></li>";
}

?>