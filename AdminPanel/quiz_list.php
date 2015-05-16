<html>
<head>
    <title>Inspiria Quiz Admin</title>
    <meta charset='utf-8'/>
    <link rel='stylesheet' type='text/css' href='styles/style.css'/>
    <link rel='stylesheet' type='text/css' href='styles/flaticon/flaticon.css'/>
    
    <script src="jquery-2.1.3.js"></script>
    <script type='text/javascript'>
        function quizSingleClick(quizID){
            document.location = "quiz_single.php?QuizID=" + quizID;
        }
        
        function deleteQuiz(quizID){
            
            if(!confirm("Er du sikker på du vil slette denne quizen?")) {
                return;
            }
            
            $.ajax({
                url: "../API/quiz_delete.php",
                type: "POST",
                data: {QuizID: quizID},
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(errorThrown);
                    alert("Quizen kunne ikke bli slettet.");
                },
                success: function(data){
                    console.log(data);
                    location.reload();
                }
            });
        }
        
        function createQuiz(){
            $.post("../API/quiz_post.php" , $("#create-form").serialize(), function(data) {
                window.location.href = "quiz_single.php?QuizID="+data.QuizID;
            })
            .fail(function() {
                alert("Kunne ikke opprette quizen.");
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
                    <?php $activepage = 'quiz_list.php'; ?>
                    <?php include 'nav.php'; ?>
                </ul>
            </nav>
        </div>
        <div class='content'>
            <h1>Quizer</h1>
            <p>Her ser du en oversikt over de quizene som finnes i systemet.</p>
            
            <div class='panel'>
                <div class='panel-header'>Ny quiz</div>
                <div class='panel-body'>
                    <form action="../API/quiz_post.php" method="POST" id='create-form'>
                        <input type="text" name="QuizName" placeholder="Quiz navn" />
                        <button type="button" onclick="createQuiz()">Opprett</button>
                    </form>
                </div>
            </div>
            
            <div class='panel'>
                <div class='panel-header'>Quizer</div>
                
                    <table id='quiz-list'>
                        <tr class='quiz-top'>
                            <th class='title'>Tittel</th>
                            <th class='questions'>Antall spørsmål</th>
                            <th class='delete'>Slett</th>
                        </tr>
                        <?php
                        // Get the quizes and feed it into the table
                        $jsonString = file_get_contents('http://localhost/InspiriaQuiz/API/quizes_get.php');
                        //$jsonString = file_get_contents('http://frigg.hiof.no/bo15-g21/API/quizes_get.php');
                        $jsonQuiz = json_decode($jsonString);
                        //var_dump($jsonQuiz);
                        
                        foreach($jsonQuiz as $json){
                            echo '<tr class="quiz-single">';
                                echo '<td class="title" onclick="quizSingleClick('.$json->QuizID.');">'.$json->QuizName.'</td>';
                                echo '<td class="questions">'.$json->Questions.'</td>';
                                echo '<td class="delete"><i class="flaticon-cross93" onclick="deleteQuiz('.$json->QuizID.')"></i></td>';
                            echo '</tr>';
                        }
                        ?>
                    </table>
                
            </div>
        </div>
    </div>
</body>
</html>