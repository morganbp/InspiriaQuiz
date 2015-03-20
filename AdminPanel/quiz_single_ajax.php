<html>
<head>
    <title>Inspiria Quiz Admin</title>
    <meta charset='utf-8'/>
    <link rel='stylesheet' type='text/css' href='styles/style.css'/>
    <link rel='stylesheet' type='text/css' href='styles/flaticon/flaticon.css'/>
    
    <script src="jquery-2.1.3.js"></script>
    <script type='text/javascript'>
        var quizJSON = null;
        var submitJSON = {
            Insert: [], 
            Update: [], 
            Delete: []
        };
        
        $( document ).ready(function() {
            fetchQuiz(2);
        });
        
        function addCheckboxClickListeners(){
            $(".correct-checkbox").change(function() {
                $(this).prev().toggleClass("alternative-text-correct");
            });
        }
        
        /* QUIZ SETUP SECTION */
        // GET data from database
        function fetchQuiz(quizId){
            "use strict";
            $.ajax({
                url: "http://localhost/InspiriaQuiz/API/quiz_get.php", //"http://frigg.hiof.no/bo15-g21/API/quiz_get.php",
                type: "POST",
                data: {QuizID: quizId},
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert("Quiz not found."); //No quiz found, or QuizID invalid.
                },
                success: function(data){
                    quizJSON = data;
                    makeQuestionTable();
                    addCheckboxClickListeners();
                }
            });
        }
        
        // Makes the question table
        function makeQuestionTable(){
            $('.content').prepend("<h1>" + quizJSON.QuizName + "</h1>");
            var submitButton = "<button class='submit-quiz' type='button'>Lagre endringene</button>";
            $('.panel').append("<div class='panel-header'>" + quizJSON.QuizName + submitButton + "</div>");
            $('.panel').append("<table id='question-list'>");
            
            
            var questionsJSON = quizJSON.Questions;
            for(var i=0; i<questionsJSON.length; i++){
                $('#question-list').append(questionSection(i));
            }
        }
        
        // Functions for divs inside the table for better readability in code above.
        // Returns a question with all fields
        function questionSection(i){
            return questionHeaderRow(i) + questionTextInputRow(i) + questionAlternatives(i);
        }
        
        function questionHeaderRow(i){
            return "<tr class='question-top'><th>" + quizJSON.Questions[i].QuestionText + "</th></tr>";
        }
        
        function questionTextInputRow(i){
            var startRow = "<tr class='question-single'><td>";
            var hiddenInput = "<input type='hidden' name='QuestionID["+i+"]' value='" + quizJSON.Questions[i].QuestionID + "'/>";
            var shownInput = "<input class='question-text' type='text' name='QuestionText["+i+"]' value='" + quizJSON.Questions[i].QuestionText + "'/>";
            var endRow = "</td></tr>";
            
            return startRow + shownInput + endRow;
        }
        
        function questionAlternatives(i){
            var alternativesText = "";
            var altJSON = quizJSON.Questions[i].Alternatives;
            
            
            for(var j=0; j<altJSON.length; j++){
                alternativesText += questionAlternative(i, j);
            }
            
            return alternativesText;
        }
        
        function questionAlternative(i, j){
            var altText = quizJSON.Questions[i].Alternatives[j].AlternativeText;
            var altID = quizJSON.Questions[i].Alternatives[j].AlternativeID;
            var correct = quizJSON.Questions[i].Alternatives[j].AlternativeCorrect;
            
            var startRow = "<tr class='alternatives'><td>";
            var checkboxCorrect = "<input class='correct-checkbox' type='checkbox' name='Correct["+i+"]["+j+"]' " + (correct?"checked='checked'":"") + ">";
            var shownInput = "<input class='alternative-text " + (correct?"alternative-text-correct":"")+ "' type='text' name='Alternative["+i+"]["+j+"]' value='" + altText + "'>"
            var deleteButton = "<i class='flaticon-cross93' onclick='removeAlternative(this, "+i+","+j+")'></i>";
            var endRow = "</td></tr>";

            return startRow + shownInput + checkboxCorrect + deleteButton + endRow;
        }
        
        /* QUIZ MANIPULATION SECTION */
        // When the user clicks on the X behind an alternative
        function removeAlternative(element, qNum, aNum){
            var altID = quizJSON.Questions[qNum].Alternatives[aNum].AlternativeID;
            //quizJSON.Questions[qNum].Alternatives.splice(aNum, 1);
            submitJSON.Delete.push(altID);
            $(element).closest("tr").remove();
            console.log(submitJSON);
        }
        
        // When the user clicks on the + behind the last alternative
        function addAlternative(qNum, aNum){
            var altID = quizJSON.Questions[qNum].Alternatives[aNum].AlternativeID;
            quizJSON.Questions[qNum].Alternatives.splice(aNum, 1);
            submitJSON.Insert.push(altID);
            console.log(submitJSON);
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
                <!-- Javascript incoming -->
            </div>
        </div>
    </div>
</body>
</html>