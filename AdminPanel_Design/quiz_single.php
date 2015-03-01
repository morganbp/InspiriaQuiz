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
    <?php
    // Get the questions from the quiz selected

    // http://www.joeldare.com/wiki/php:post_with_file_get_contents_from_php

    $postdata = http_build_query(array('QuizID' => $_GET['QuizID']));
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        ));

    // Create the POST context
    $context  = stream_context_create($opts);

    $jsonString = file_get_contents('http://localhost/InspiriaQuiz/API/quiz_get.php', false, $context);
    $jsonQuiz = json_decode($jsonString);
    //var_dump($jsonQuiz);
    ?>
    
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
            <h1><?php echo $jsonQuiz->QuizName; ?></h1>
            
            <div class='panel'>
                <div class='panel-header'>Spørsmål i <?php echo $jsonQuiz->QuizName; ?></div>
                
                    <table id='question-list'>
                        <?php 
                        foreach($jsonQuiz->Questions as $qKey => $json){
                            echo "<tr class='question-top'>";
                                echo "<th>Spørsmål ".($qKey+1)."</th>";
                            echo "</tr>";
                            echo '<tr class="question-single">';
                                echo '<td>';
                                    echo '<input class="question-text" type="text" value="'.$json->QuestionText.'"/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr class="question-single">';
                                foreach($json->Alternatives as $aKey => $alternative){
                                    echo '<tr class="alternatives">';
                                        echo '<td>';
                                            echo '<input class="alternative-text" type="text" value="'.$alternative->AlternativeText.'"/>';
                                            echo '<a href="#"><i class="flaticon-cross93"></i></a>';
                                            
                                            if($aKey == count($json->Alternatives)-1)
                                                echo '<a href="#"><i class="flaticon-plus24"></i></a>';
                                        echo '</td>';
                                    echo '</tr>';
                                }
                            echo '</tr>';
                        }
                        ?>
                    </table>
                
            </div>
        </div>
    </div>
</body>
</html>