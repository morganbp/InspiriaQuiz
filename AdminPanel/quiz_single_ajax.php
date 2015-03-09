<html>
<head>
    <title>Inspiria Quiz Admin</title>
    <meta charset='utf-8'/>
    <link rel='stylesheet' type='text/css' href='styles/style.css'/>
    <link rel='stylesheet' type='text/css' href='styles/flaticon/flaticon.css'/>
    
    <script src="jquery-2.1.3.js"></script>
    <script type='text/javascript'>
        var quizJSON = null;
        $( document ).ready(function() {
            fetchQuiz(1);
        });
        
        // GET data from database
        function fetchQuiz(quizId){
            "use strict";
            $.ajax({
                url: "http://localhost/InspiriaQuiz/API/quiz_get.php", //"http://frigg.hiof.no/bo15-g21/API/quiz_get.php",
                type: "POST",
                data: {QuizID: quizId},
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert("Quiz not found"); //No quiz found, or QuizID invalid.
                },
                success: function(data){
                    quizJSON = data;
                    feedTableWithData();
                }
            });
        }
        
        function feedTableWithData(){
            $('.content').prepend("<h1>" + quizJSON.QuizName + "</h1>");
            $('.panel').append("<div class='panel-header'>Spørsmål i " + quizJSON.QuizName + "</div>");
            $('.panel').append("<table id='question-list'>");
            
            var questionsJSON = quizJSON.Questions;
            for(var i=0; i<questionsJSON.length; i++){
                $('#question-list').append(questionHeaderRow(i));
            }
        }
        
        function questionHeaderRow(i){
            return "<tr class='question-top'><th>Spørsmål " + i + "</th></tr>";
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
            
            <div class='panel'>
                    
                
            </div>
        </div>
    </div>
</body>
</html>