<?php

if(isset($_POST['GroupID']))
    $groupID = intval($_POST['GroupID']);


include("../API/db_connect.php");
if($stmt = $mysqli -> prepare("SELECT UserFirstName, UserLastName, UserCode 
    FROM User 
    WHERE GroupID = ?;")) {
    $stmt -> bind_param("i", $groupID);
    $stmt -> execute();
    
    $result = $stmt -> get_result();
    // Bind results to output-variable
    while($row = $result -> fetch_assoc()){
        $output[] = $row;
    }
    $stmt -> free_result();
    $stmt -> close();
}else{
    die("Failed to prepare the statement.");
}
?>

<html>
<head>
    <title>Grupperegistrering - Inspiria Quiz</title>
    <meta charset='utf-8'/>
    <link rel='stylesheet' type='text/css' href='../AdminPanel/styles/style.css'/>
    <link rel='stylesheet' type='text/css' href='../AdminPanel/styles/flaticon/flaticon.css'/>
    
    <script src="../AdminPanel/jquery-2.1.3.js"></script>
</head>
<body>
    <div id='container'>
        <div class='center-content'>
            <h1>Grupperegistrering</h1>
            <p>Grupperegisteringen er nå fullført, under finner du en liste du kan printe ut med alle brukerne som har blitt opprettet. </p>
            
            <div class='panel'>
                <div class='panel-header'>Din gruppe</div>
                <div id="register-group" class='panel-body'>
                    <?php if(!isset($output)) die("Det finnes ingen medlemmer i denne gruppen."); ?>
                    <h2>Gruppemedlemmer</h2>
                    <table id='group-overview'>
                        <tr>
                            <th>Fornavn</th>
                            <th>Etternavn</th>
                            <th>Kode</th>
                        </tr>
                        <?php
                        for($i=0; $i < count($output); $i++){
                            echo "<tr>";
                                echo "<td>".$output[$i]['UserFirstName']."</td>";
                                echo "<td>".$output[$i]['UserLastName']."</td>";
                                echo "<td>".$output[$i]['UserCode']."</td>";
                            echo "</tr>";
                        }

                        ?>
                    </table>

                </div>
            </div>
        </div>
    </div>
</body>
</html>