<html>
<head>
    <title>Inspiria Quiz Admin</title>
    <meta charset='utf-8'/>
    <link rel='stylesheet' type='text/css' href='styles/style.css'/>
    <link rel='stylesheet' type='text/css' href='styles/flaticon/flaticon.css'/>
    <?php
    
    $activepage = "login.php";
    
    ?>
</head>
<body>
    <?php include 'header.php'; ?>

    <div id='container'>
        <div class='sidebar'>
            <nav>
                <ul id='nav'>
                    <?php $activepage = 'login.php'; ?>
                    <?php include 'nav.php'; ?>
                </ul>
            </nav>
        </div>
        <div class='content'>
            <h1>Logg inn</h1>
            <p>Velkommen til admin-panelet for Inspirias Quizer!</p>
            
            <div class='panel'>
                <div class='panel-header'>Logg inn</div>
                <div class='panel-body'>
                    <form id="login" method="post" action="login_check.php">
                        <p>E-mail</p>
                        <p><input type="text" name="LoginEmail" /></p>
                        <p>Passord</p>
                        <p><input type="password" name="LoginPassword" /></p>
                        <p><input type="submit" value="Logg inn" /></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>