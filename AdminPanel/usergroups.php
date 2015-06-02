<html>
<head>
    <title>Inspiria Quiz Admin</title>
    <meta charset='utf-8'/>
    <link rel='stylesheet' type='text/css' href='styles/style.css'/>
    <link rel='stylesheet' type='text/css' href='styles/flaticon/flaticon.css'/>
    <script src="../AdminPanel/jquery-2.1.3.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#link-textbox").focus(function() { $(this).select(); } );
        });
        function generateLink(){
            $.ajax({
                url: "link_generator.php",
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(textStatus);
                    alert("Kunne ikke generere ny link.");
                },
                success: function(data){
                    console.log(data);
                    console.log(data.RegistrationPath);
                    
                    $("#link-textbox").val(data.RegistrationPath);
                    $("#link-displayer").slideDown();
                }
            });
        }
        
        function updateGroupQuiz(element, groupID){
            var quizID = $(element).val();
            
            $.ajax({
                url: "../API/usergroup_update.php",
                type: "POST",
                data: {QuizID: quizID, GroupID: groupID},
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(textStatus);
                    alert("Kunne ikke oppdatere gruppens quiz.");
                },
                success: function(data){
                    console.log(data);
                }
            });
        }
    </script>
    
    <?php
    $jsonString = file_get_contents('http://frigg.hiof.no/bo15-g21/API/quizes_get.php');
    $jsonQuizes = json_decode($jsonString);
    ?>
</head>
<body>
    <?php include 'header.php'; ?>

    <div id='container'>
        <div class='sidebar'>
            <nav>
                <ul id='nav'>
                    <?php $activepage = 'usergroups.php'; ?>
                    <?php include 'nav.php'; ?>
                </ul>
            </nav>
        </div>
        <div class='content'>
            <h1>Grupper</h1>
            <p>Her genererer du linker til registrering av grupper.</p>
            
            <div class='panel'>
                <div class='panel-header'>Generer ny link</div>
                <div class='panel-body'>
                    <div id="link-displayer">
                        <input id="link-textbox" type="text" />
                    </div>
                    <button type="button" onclick="generateLink()">Generer</button>
                </div>
            </div>
            
            <div class='panel'>
                <div class='panel-header'>Grupper uten quiz</div>
                
                <table id='quiz-list' class='group-list'>
                    <tr class='quiz-top'>
                        <th class='group-name'>Gruppenavn</th>
                        <th class='group-leader-name'>Gruppeleder</th>
                        <th class='group-quiz-name'>Quiz</th>
                    </tr>
                    
                    <?php
                    // Get the quizes and feed it into the table
                    //$jsonString = file_get_contents('http://localhost/bo15-g21/API/quizes_get.php');
                    $jsonString = file_get_contents('http://frigg.hiof.no/bo15-g21/API/usergroups_get.php');
                    $jsonGroup = json_decode($jsonString);

                    foreach($jsonGroup as $json){
                        if($json->QuizID != null && $json->QuizID != 0)
                            continue;
                        echo '<tr>';
                            echo '<td class="group-name">'.$json->GroupName.'</td>';
                            echo '<td class="group-leader-name">'.$json->GroupLeaderName.'</td>';
                            echo '<td class="group-quiz-name">'.getQuizSelect($json->QuizID, $json->GroupID).'</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
                
            </div>
            
            <div class='panel'>
                <div class='panel-header'>Grupper med quiz</div>
                
                <table id='quiz-list' class='group-list'>
                    <tr class='quiz-top'>
                        <th class='group-name'>Gruppenavn</th>
                        <th class='group-leader-name'>Gruppeleder</th>
                        <th class='group-quiz-name'>Quiz</th>
                    </tr>
                    <?php
                    foreach($jsonGroup as $json){
                        if($json->QuizID == null || $json->QuizID == '0')
                            continue;
                        echo '<tr>';
                            echo '<td class="group-name">'.$json->GroupName.'</td>';
                            echo '<td class="group-leader-name">'.$json->GroupLeaderName.'</td>';
                            echo '<td class="group-quiz-name">'.getQuizSelect($json->QuizID, $json->GroupID).'</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
                
            </div>
        </div>
    </div>
</body>
</html>

<?php
function getQuizSelect($selectedQuiz, $groupID){
    global $jsonQuizes;
    $quizSelect = "<select onchange='updateGroupQuiz(this, ".$groupID.")'>";
    $quizSelect .= "<option value='0'>Ingen quiz</option>";
    foreach($jsonQuizes as $json){
        $quizSelect .= "<option value='".$json->QuizID."' ".(($selectedQuiz == $json->QuizID)?"selected":"").">"
            . $json->QuizName
            . "</option>";
    }
    $quizSelect .= "</select>";
    return $quizSelect;
}
?>