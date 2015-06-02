<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['Email']) && basename($_SERVER['REQUEST_URI']) != 'login.php')
    header("Location: login.php");
?>
<header>
    <div class='logo'>
        <a href='index.php'>Adminpanel for Inspirias quizer</a>
    </div>
</header>