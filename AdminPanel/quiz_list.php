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
                <div class='panel-header'>Quizer</div>
                
                    <table id='quiz-list'>
                        <tr class='quiz-top'>
                            <th class='quiz-list-id'>Quiz ID</th>
                            <th class='quiz-list-title'>Tittel</th>
                            <th class='quiz-list-questions'>Antall spørsmål</th>
                        </tr>
                        <?php
                        // Get the quizes and feed it into the table
                        $jsonString = file_get_contents('http://localhost/InspiriaQuiz/API/quiz_list_get.php');
                        $jsonQuiz = json_decode($jsonString);
                        //var_dump($jsonQuiz);
                        
                        foreach($jsonQuiz as $json){
                            echo '<tr class="quiz-single" onclick=\'quizSingleClick('.$json->QuizID.');\'>';
                                echo '<td class="quiz-list-id">'.$json->QuizID.'</a></td>';
                                echo '<td class="quiz-list-title">'.$json->QuizName.'</td>';
                                echo '<td class="quiz-list-questions">'.$json->Questions.'</td>';
                            echo '</tr>';
                        }
                        ?>
                    </table>
                
            </div>
        </div>
    </div>
</body>
</html>