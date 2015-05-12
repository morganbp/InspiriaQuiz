<?php
session_start();

if(!isset($_SESSION['Email']) && basename($_SERVER['REQUEST_URI']) != 'login.php')
    header("Location: login.php");
?>
<header>
    <div class='logo'>
        <a href='index.php'>Inspiria Quiz Admin Panel</a>
    </div>
</header>