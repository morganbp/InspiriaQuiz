
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
            Insert: {Alternatives: [], Questions: []}, 
            Update: {Alternatives: [], Questions: []}, 
            Delete: {Alternatives: [], Questions: []}
        };
        
        $( document ).ready(function() {
            fetchQuiz(<?php echo $_GET['QuizID'];?>);
        });
        
        function addCheckboxClickListeners(){
            $(".correct-checkbox").each(function(){
                $(this).change(function(){
                    $(this).prev().toggleClass("alternative-text-correct");
                });
            });
        }
        function removeCheckboxClickListeners(){
            $(".correct-checkbox").each(function(){
                $(this).off("change");
            });
        }
        function refreshCheckboxClickListeners(){
            removeCheckboxClickListeners();
            addCheckboxClickListeners();
        }
        
        function toggleAlternativeCorrect(){
            $(this).prev().toggleClass("alternative-text-correct");
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
            $('.content').prepend("<h1>Endrer quizen: " + quizJSON.QuizName + "</h1>");
            var submitButton = "<button id='submit-quiz' type='button' onclick='submitQuiz()'>Lagre endringene</button>";
            $('.panel').append("<div class='panel-header'>Quiz tittel: <input id='quiz-name' type='text' name='quizName' value='" + quizJSON.QuizName + "'/>" + submitButton + "</div>");
            $('.panel').append("<table id='question-list'>");
            $('.panel').append("</table>");
            
            
            var questionsJSON = quizJSON.Questions;
            for(var i=0; i<questionsJSON.length; i++){
                $('#question-list').append(questionSection(i));
            }
        }
        
        // Functions for divs inside the table for better readability in code above.
        // Returns a question with all fields
        function questionSection(i){
            //return questionHeaderRow(i) + questionTextInputRow(i) + questionAlternatives(i);
            return "<table class='question-section'>" + questionHeaderRow(i) + questionTextInputRow(i) + questionAlternatives(i) + "</table>";
        }
        
        function questionHeaderRow(i){
            return "<tr class='question-top'><th>" + quizJSON.Questions[i].QuestionText + "</th></tr>";
        }
        
        function questionTextInputRow(i){
            var startRow = "<tr class='question-single'><td>";
            var hiddenInput = "<input type='hidden' name='QuestionID' value='" + quizJSON.Questions[i].QuestionID + "'/>";
            var shownInput = "<input class='question-text' type='text' name='QuestionText["+i+"]' value='" + quizJSON.Questions[i].QuestionText + "'/>";
            var endRow = "</td></tr>";
            
            return startRow + hiddenInput + shownInput + endRow;
        }
        
        function questionAlternatives(i){
            var alternativesText = "";
            var altJSON = quizJSON.Questions[i].Alternatives;
            
            
            for(var j=0; j<altJSON.length; j++){
                alternativesText += questionAlternative(i, j);
            }
            
            alternativesText += questionAlternativePlus();
            
            return alternativesText;
        }
        
        function questionAlternative(i, j){
            var altText = quizJSON.Questions[i].Alternatives[j].AlternativeText;
            var altID = quizJSON.Questions[i].Alternatives[j].AlternativeID;
            var correct = quizJSON.Questions[i].Alternatives[j].AlternativeCorrect;
            
            var startRow = "<tr class='alternatives'><td>";
            var checkboxCorrect = "<input class='correct-checkbox' type='checkbox' id='Correct["+i+"]["+j+"]' name='Correct["+i+"]["+j+"]' " + (correct?"checked='checked'":"") + ">";
            var checkboxCorrectLabel = "<label for='Correct["+i+"]["+j+"]'></label>";
            var shownInput = "<input class='alternative-text " + (correct?"alternative-text-correct":"")+ "' type='text' name='Alternative["+i+"]["+j+"]' value='" + altText + "'>"
            var deleteButton = "<i class='flaticon-cross93' onclick='removeAlternative(this, "+i+", "+j+")'></i>";
            var endRow = "</td></tr>";

            return startRow + shownInput + checkboxCorrect + checkboxCorrectLabel + deleteButton + endRow;
        }
        
        function questionNewAlternative(){
            var startRow = "<tr class='alternatives'><td>";
            var checkboxCorrect = "<input class='correct-checkbox' type='checkbox' id='NewCorrect' name='NewCorrect'>";
            var checkboxCorrectLabel = "<label for='NewCorrect'></label>";
            var shownInput = "<input class='alternative-text' type='text' name='NewAlternative' placeholder='...'>"
            var deleteButton = "<i class='flaticon-cross93' onclick='removeNewAlternative(this)'></i>";
            var endRow = "</td></tr>";

            return startRow + shownInput + checkboxCorrect + checkboxCorrectLabel + deleteButton + endRow;
        }
        
        function questionAlternativePlus(){
            var startRow = "<tr class='alternatives'><td>";
            var addButton = "<i class='flaticon-plus24' onclick='addAlternative(this)'></i>";
            var endRow = "</td></tr>";
            
            return startRow + addButton + endRow;
        }
        
        /* QUIZ MANIPULATION SECTION */
        // When the user clicks on the X behind an alternative
        function removeAlternative(element, qNum, aNum){
            var altID = quizJSON.Questions[qNum].Alternatives[aNum].AlternativeID;
            submitJSON.Delete.Alternatives.push(altID);
            $(element).closest("tr").remove();
            console.log(submitJSON);
        }
        
        // When the user clicks on the X behind an alternative that does not have an ID (a new alternative)
        function removeNewAlternative(element){
            $(element).closest("tr").remove();
        }
        
        // When the user clicks on the + behind the last alternative
        function addAlternative(element){
            var tr = $(element).closest("tr");
            while(!tr.is(".question-single"))
                tr = tr.prev();
            
            var numberOfAlternatives = tr.nextUntil(".question-top").length-1;
            
            if(numberOfAlternatives < 4){
                $(element).closest("tr").before(questionNewAlternative());
                
                refreshCheckboxClickListeners();
            }
        }
        
        /* SUBMIT */
        function submitQuiz(){
            // TODO Compare question title as well
            
            $("#submit-quiz").html("Lagrer...");
            
            var quizName = $("#quiz-name").val();
            if(quizJSON.QuizName != quizName){
                submitJSON.Update.QuizID = quizJSON.QuizID;
                submitJSON.Update.QuizName = quizName;
            }
            
            $(".question-section").each(function(outer){
                //console.log(this);
                $(this).find(".alternative-text:not(input[name=NewAlternative])").each(function(inner){
                    // Find json array indexes
                    var pattern = /\d+/g;
                    var nameProperty = $(this).prop("name");
                    var indexes = nameProperty.match(pattern);
                    var questionIndex = indexes[0];     // json[THIS_INDEX][]
                    var alternativeIndex = indexes[1];  // json[][THIS_INDEX]
                    
                    // Compare value to quizJSON
                    var newAlternativeText = $(this).val();
                    var oldAlternativeText = quizJSON.Questions[questionIndex].Alternatives[alternativeIndex].AlternativeText;
                    var alternativeID = quizJSON.Questions[questionIndex].Alternatives[alternativeIndex].AlternativeID;
                    
                    // Compare correct to quizJSON
                    var newCorrectBoolean = $(this).next("input[type=checkbox]").prop("checked");
                    var newCorrectValue = (newCorrectBoolean==true)?1:0;
                    var oldCorrectValue = quizJSON.Questions[questionIndex].Alternatives[alternativeIndex].AlternativeCorrect;
                    
                    // Add to submitJSON if not the same
                    if(newAlternativeText != oldAlternativeText || newCorrectValue != oldCorrectValue){
                        // Add to submitJSON
                        console.log(newCorrectValue+"!="+oldCorrectValue);
                        submitJSON.Update.Alternatives.push({
                            "AlternativeID": alternativeID, 
                            "AlternativeText": newAlternativeText, 
                            "AlternativeCorrect": newCorrectValue
                            });
                    }
                });
            });
            //console.log(submitJSON);
            
            // Add new alternatives and correct-values to submitJSON
            $("input[name=NewAlternative]").each(function(index){
                var alt = $(this).val();
                var correctBoolean = $(this).next("input[name=NewCorrect]").prop("checked");
                var cor = (correctBoolean==true)?1:0;
                var qID = $(this).closest("tr").prevAll(".question-single:first").find("input[name=QuestionID]").val();
                
                submitJSON.Insert.Alternatives.push({"QuestionID": qID, "AlternativeText": alt, "AlternativeCorrect": cor});
            });
            console.log(submitJSON);
            
            
            $.ajax({
                url: "http://localhost/InspiriaQuiz/API/quiz_update.php",
                type: "POST",
                data: {SubmitJSON: submitJSON},
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(errorThrown);
                    $("#submit-quiz").html("Lagre endringene");
                    alert("Quiz could not be updated.");
                },
                success: function(data){
                    console.log(data);
                    $("#submit-quiz").html("Lagret");
                    //alert("Quiz has been updated.");
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