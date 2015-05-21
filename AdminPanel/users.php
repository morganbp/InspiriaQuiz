<html>
<head>
    <title>Inspiria Quiz Admin</title>
    <meta charset='utf-8'/>
    <link rel='stylesheet' type='text/css' href='styles/style.css'/>
    <link rel='stylesheet' type='text/css' href='styles/flaticon/flaticon.css'/>
    
    <script src="jquery-2.1.3.js"></script>
    <script type='text/javascript'>
        function deleteUser(userID){
            
            if(!confirm("Er du sikker på du vil slette denne brukeren?")) {
                return;
            }
            
            $.ajax({
                url: "../API/inspiriauser_delete.php",
                type: "POST",
                data: {UserID: userID},
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(textStatus);
                    alert("Brukeren kunne ikke bli slettet.");
                },
                success: function(data){
                    console.log(data);
                    location.reload();
                }
            });
        }
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div id='container'>
        <div class='sidebar'>
            <nav>
                <ul id='nav'>
                    <?php $activepage = 'users.php'; ?>
                    <?php include 'nav.php'; ?>
                </ul>
            </nav>
        </div>
        <div class='content'>
            <h1>Brukere</h1>
            <p>Her kan du legge til og slette brukere for administasjonspanelet.</p>
            
            <div class='panel'>
                <div class='panel-header'>Ny bruker</div>
                <div class='panel-body'>
                    <form action="../API/inspiriauser_post.php" method="POST" id='create-form'>
                        <input type="email" name="RegisterEmail" placeholder="E-mail" />
                        <input type="password" name="RegisterPassword" placeholder="Passord" />
                        <input type="submit" value="Opprett"></input>
                    </form>
                </div>
            </div>
            
            <div class='panel'>
                <div class='panel-header'>Quizer</div>
                
                <table id='quiz-list'>
                    <tr class='quiz-top'>
                        <th class='email'>E-mail</th>
                        <th class='delete'>Slett</th>
                    </tr>
                    <?php
                    // Get the quizes and feed it into the table
                    //$jsonString = file_get_contents('http://localhost/InspiriaQuiz/API/inspiriausers_get.php');
                    $jsonString = file_get_contents('http://frigg.hiof.no/bo15-g21/API/inspiriausers_get.php');
                    $jsonQuiz = json_decode($jsonString);

                    foreach($jsonQuiz as $json){
                        echo '<tr class="quiz-single">';
                            echo '<td class="title">'.$json->UserEmail.'</td>';
                            echo '<td class="delete"><i class="flaticon-cross93" onclick="deleteUser('.$json->UserID.')"></i></td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
                
            </div>
        </div>
    </div>
</body>
</html>