<?php

if(isset($_GET['RegistrationCode']))
    $registrationCode = $_GET['RegistrationCode'];

include("../API/db_connect.php");
if($stmt = $mysqli -> prepare("SELECT RegistrationCode 
    FROM RegistrationCode 
    WHERE RegistrationCode LIKE ? AND Active = 1;")) {
    $stmt -> bind_param("s", $registrationCode);
    $stmt -> execute();
    $stmt -> store_result();

    $groupCount = $stmt -> num_rows;
    
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
    <script type="text/javascript">
        function addUser(){
            var formTags = "<td><input type='text' name='FirstName[]' /></td>"
                            + "<td><input type='text' name='LastName[]' /></td>"
                            + "<td><input type='number' name='Age[]' /></td>";
            $("<tr>" + formTags + "</tr>").insertBefore("#register-group tr:last-child");
        }
        
        function submitGroup(){
            $.post("../API/usergroup_post.php" , $("#register-group").serialize(), function(data) {
                
                // Send the GroupID and go to the register success page
                $('<form action="register_success.php" method="POST">' + 
                    '<input type="hidden" name="GroupID" value="' + data.GroupID + '">' +
                    '</form>').submit();
            })
            .fail(function(XMLHttpRequest, textStatus, errorThrown){
                console.log(errorThrown);
                alert("Kunne ikke registrere gruppen.");
            });
        }
    </script>
</head>
<body>
    <div id='container'>
        <div class='center-content'>
            <h1>Grupperegistrering</h1>
            <p>Fyll ut listen under med deltakerne i gruppen din og delta i quizen under deres besøk her på Inspiria. </p>
            
            <div class='panel'>
                <div class='panel-header'>Registrer gruppen</div>
                <div class='panel-body'>
                    <form id="register-group" method="post" action="login_check.php">
                        <?php
                        if($groupCount < 1 || !isset($_GET['RegistrationCode'])){
                            die("Ugyldig registreringskode. Er du sikker på du kopierte hele nettadressen?");
                        }

                        echo "<input type='hidden' name='RegistrationCode' value='".$_GET['RegistrationCode']."'/>";
                        ?>
                        <div class="group-info">
                            <h2>Gruppeinformasjon</h2>
                            <p>Gruppenavn</p>
                            <input type="text" name="GroupName" placeholder="F.eks. Cicignon 4A" />

                            <p>Gruppelederens navn</p>
                            <input type="text" name="GroupLeaderName" />

                            <p>Gruppelederens e-mail</p>
                            <input type="text" name="GroupLeaderEmail" />

                            <p>Gruppelederens tlf</p>
                            <input type="tel" name="GroupLeaderPhone" />
                        </div>
                        
                        <h2>Gruppemedlemmer</h2>
                        <table>
                            <tr>
                                <th>Fornavn</th>
                                <th>Etternavn</th>
                                <th>Alder</th>
                            </tr>
                            <?php

                            for($i=0; $i < 20; $i++){
                                echo "<tr>";
                                    echo "<td><input type='text' name='FirstName[]' /></td>";
                                    echo "<td><input type='text' name='LastName[]' /></td>";
                                    echo "<td><input type='number' name='Age[]' /></td>";
                                echo "</tr>";
                            }

                            ?>
                            <tr>
                                <td colspan="3">
                                    <button type="button" onclick="submitGroup()">Send</button>
                                    <button type="button" onclick="addUser()">Legg til person</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>