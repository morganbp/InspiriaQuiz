<?php
function encryptInspiriaPassword($password){
    $salt = "GM9=9UK8RTY#5WE4=S2D6)3GBT(6/TGH47(41";
    return hash('sha256', $password . $salt);
}
?>