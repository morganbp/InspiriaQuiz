<?php

if($activepage == "login.php"){
    $icons["login.php"] = "<i class='flaticon-home63'></i>";
    
    $pages["login.php"] = "Logg inn";
}else{
    $icons["index.php"] = "<i class='flaticon-home63'></i>";
    $icons["quiz_list.php"] = "<i class='flaticon-question1'></i>";
    $icons["images.php"] = "<i class='flaticon-picture64'></i>";
    $icons["exhibits.php"] = "<i class='flaticon-place4'></i>";
    $icons["usergroups.php"] = "<i class='flaticon-multiple25'></i>";
    $icons["users.php"] = "<i class='flaticon-network60'></i>";
    $icons["logout.php"] = "<i class='flaticon-log'></i>";

    $pages["index.php"] = "Dashboard";
    $pages["quiz_list.php"] = "Quizer";
    $pages["exhibits.php"] = "Stasjoner";
    $pages["images.php"] = "Bilder";
    $pages["usergroups.php"] = "Grupper";
    $pages["users.php"] = "Brukere";
    $pages["logout.php"] = "Logg ut";
}



foreach($pages as $url => $page){
    if($url == $activepage)
        echo "<li><a href=".$url." class='selected'>".$icons[$url]."<span class='page-title'>".$page."</span></a></li>";
    else
        echo "<li><a href=".$url.">".$icons[$url]."<span class='page-title'>".$page."</span></a></li>";
}

?>