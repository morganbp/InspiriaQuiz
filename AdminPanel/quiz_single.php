
<html>
<head>
    <title>Inspiria Quiz Admin</title>
    <meta charset='utf-8'/>
    <link rel='stylesheet' type='text/css' href='styles/style.css'/>
    <link rel='stylesheet' type='text/css' href='styles/flaticon/flaticon.css'/>
    
    <script src="jquery-2.1.3.js"></script>
    <script type='text/javascript'>
        var quizJSON = null;
        var imagesJSON = null;
        var highestQuestionIndex = 0;
        var optionList = "<option value='-1'>Ingen bilde valgt</option>";
        
        var submitJSON = {
            QuizID: <?php echo $_GET['QuizID'];?>,
            Insert: {Alternatives: [], Questions: []}, 
            Update: {Alternatives: [], Questions: []}, 
            Delete: {Alternatives: [], Questions: []}
        };
        
        $( document ).ready(function() {
            fetchQuiz(<?php echo $_GET['QuizID'];?>);
        });
        
        /* CHECKBOXES */
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
            $.ajax({
                //url: "http://localhost/InspiriaQuiz/API/quiz_get.php",
				url: "../API/quiz_get.php",
                type: "POST",
                data: {QuizID: quizId},
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert("Quiz with ID " + quizId + " was not found."); //No quiz found, or QuizID invalid.
					window.location.href = "quiz_list.php";
                },
                success: function(data){
					submitJSON.QuizID = data.QuizID;
                    quizJSON = data;
                    highestQuestionIndex = quizJSON.Questions.length;
                    makeQuestionTable();
                    addCheckboxClickListeners();
                    fetchImages();
                    
                    console.log(quizJSON);
                }
            });
        }
        
        function findQuestionIndexByID(id){
            for(var i=0; i<quizJSON.Questions.length; i++){
                if(quizJSON.Questions[i].QuestionID == id)
                    return i;
            }
            return -1;
        }
        
        
        function fetchImages(){
            $.ajax({
                //url: "http://localhost/InspiriaQuiz/API/images_get.php",
                url: "../API/images_get.php",
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert("Images not found.");
                },
                success: function(images){
                    imagesJSON = images;
                    for(var i=0; i<images.length; i++){
                        optionList += "<option value='" + images[i].ImageID + "'>"
                            +images[i].ImageName
                            +"</option>";
                    }
                    $(".question-image select").each(function(){
                        $(this).html(optionList);
                        var questionID = $(this).closest('.question-section').find('input[name=QuestionID]').val();
                        var questionIndex = findQuestionIndexByID(questionID);
                        var imageIndex = quizJSON.Questions[questionIndex].QuestionImageID;
                        
                        console.log(imageIndex);
                        
                        if(imageIndex == null)
                            imageIndex = -1;

                        $(this).val(imageIndex);
                        $(this).change(refreshImagePreview);
                    });
                }
            });
        }
        
        function refreshImagePreview(){
            var imageRow = $(this).closest(".question-section").find(".question-image-preview");
            var imageIndex = $(this).find(":selected").val();
            if(imageIndex == -1){
                imageRow.fadeOut();
            }else{
                var imageFilename = imagesJSON[findImageIndexByID(imageIndex)].ImageFilename;
                var imageTag = imageRow.find("img");

                imageTag.attr("src", "../UploadedImages/"+imageFilename)
                imageRow.fadeIn();
            }
        }
        
        function findImageIndexByID(imageID){
            for(var i=0; imagesJSON.length; i++)
                if(imagesJSON[i].ImageID == imageID)
                    return i;
            return -1;
        }
        
        // Makes the question table
        function makeQuestionTable(){
            $('.content').prepend("<h1>Endrer quizen: " + quizJSON.QuizName + "</h1>");
            var submitButton = "<button id='submit-quiz' type='button' onclick='submitQuiz()'>Lagre endringene</button>";
            $('#question-panel').append("<div class='panel-header'>Quiz tittel: <input id='quiz-name' type='text' name='quizName' value='" + quizJSON.QuizName + "'/>" + submitButton + "</div>");
            $('#question-panel').append("<table id='question-list'>");
            $('#question-panel').append("</table>");
            
            
            var questionsJSON = quizJSON.Questions;
            for(var i=0; i<questionsJSON.length; i++){
                $('#question-list').append(questionSection(i));
            }
            $('#question-list').append("<table class='add-question-section'><tr class='question-top'><td>"
                    + "<button class='add-question' onclick='addQuestion()'>Legg til spørsmål</button>"
                    + "</td></tr></table>");
        }
        
        // Functions for divs inside the table for better readability in code above.
        // Returns a question with all fields
        function questionSection(i){
            return "<table class='question-section'>" 
                + questionHeaderRow(i) 
                + questionImageRow(i) 
                + questionTextInputRow(i) 
                + questionAlternatives(i) 
                + "</table>";
        }
        
        function questionHeaderRow(i){
            return "<tr class='question-top'><th>"
                + quizJSON.Questions[i].QuestionText
                + "<i class='flaticon-cross93 delete-question' onclick='removeQuestion(this, "+i+")'></i>"
                + "</th></tr>";
        }
        
        function questionImageRow(i){
            return "<tr class='question-info'><td><div>Bilde</div></td></tr>"
                + "<tr class='question-image'><td>"
                + "<select><option>Loading images...</option></select>"
                + "</td></tr>"
                + "<tr class='question-image-preview'><td><img/></td></tr>";
        }
        
        function questionTextInputRow(i){
            return "<tr class='question-info'><td><div>Spørsmål</div></td></tr>"
                + "<tr class='question-single'><td>"
                + "<input type='hidden' name='QuestionID' value='" + quizJSON.Questions[i].QuestionID + "'/>"
                + "<input class='question-text' type='text' name='QuestionText["+i+"]' value='" + quizJSON.Questions[i].QuestionText + "'/>"
                + "</td></tr>";
        }
        
        function questionAlternatives(i){
            var alternativesText = "<tr class='question-info'><td><div>Alternativer</div></td></tr>";
            var altJSON = quizJSON.Questions[i].Alternatives;
            
            
            for(var j=0; j<altJSON.length; j++){
                alternativesText += questionAlternative(i, j);
            }
            
            alternativesText += questionAlternativePlus(i);
            
            return alternativesText;
        }
        
        function questionAlternative(i, j){
            var altText = quizJSON.Questions[i].Alternatives[j].AlternativeText;
            var altID = quizJSON.Questions[i].Alternatives[j].AlternativeID;
            var correct = quizJSON.Questions[i].Alternatives[j].AlternativeCorrect;
            
            var startRow = "<tr class='alternatives'><td>";
            var checkboxCorrect = "<input class='correct-checkbox' type='checkbox' id='Correct["+i+"]["+j+"]' name='Correct["+i+"]["+j+"]' " + (correct?"checked='checked'":"") + ">";
            var checkboxCorrectLabel = "<label class='correct-label' for='Correct["+i+"]["+j+"]'></label>";
            var shownInput = "<input class='alternative-text " + (correct?"alternative-text-correct":"")+ "' type='text' name='Alternative["+i+"]["+j+"]' value='" + altText + "'>"
            var deleteButton = "<i class='flaticon-cross93' onclick='removeAlternative(this, "+i+", "+j+")'></i>";
            var endRow = "</td></tr>";

            return startRow + shownInput + checkboxCorrect + checkboxCorrectLabel + deleteButton + endRow;
        }
        
        function questionNewAlternative(qNum, aNum){
            var startRow = "<tr class='alternatives'><td>";
            var shownInput = "<input class='alternative-text' type='text' name='NewAlternative["+qNum+"]["+aNum+"]' placeholder='...'>"
            var checkboxCorrect = "<input class='correct-checkbox' type='checkbox' id='NewCorrect["+qNum+"]["+aNum+"]' name='NewCorrect'>";
            var checkboxCorrectLabel = "<label class='correct-label' for='NewCorrect["+qNum+"]["+aNum+"]'></label>";
            var deleteButton = "<i class='flaticon-cross93' onclick='removeNewAlternative(this)'></i>";
            var endRow = "</td></tr>";

            return startRow + shownInput + checkboxCorrect + checkboxCorrectLabel + deleteButton + endRow;
        }
        
        function questionAlternativePlus(qNum){
            var startRow = "<tr class='alternatives-plus'><td>";
            var addButton = "<i class='flaticon-plus24' onclick='addAlternative(this, "+qNum+")'></i>";
            var endRow = "</td></tr>";
            
            return startRow + addButton + endRow;
        }
        
        /* QUIZ MANIPULATION SECTION */
        // When the user clicks on the X behind an alternative
        function removeAlternative(element, qNum, aNum){
            var altID = quizJSON.Questions[qNum].Alternatives[aNum].AlternativeID;
            submitJSON.Delete.Alternatives.push(altID);
            $(element).closest("tr").remove();
            //console.log(submitJSON);
        }
        
        // When the user clicks on the X behind an alternative that does not have an ID (a new alternative)
        function removeNewAlternative(element){
            var tr = $(element).closest("tr");
            
            // Renumber the other alternatives in the question
            var pattern = /\d+/g;
            $(tr).nextAll(".alternatives").each(function(){
                var nameProperty = $(this).find(".alternative-text").prop("name");
                var indexes = nameProperty.match(pattern);
                $(this).find(".alternative-text").prop("name", "NewAlternative["+indexes[0]+"]["+(indexes[1]-1)+"]");
                $(this).find(".correct-checkbox").prop("name", "NewCorrect["+indexes[0]+"]["+(indexes[1]-1)+"]");
                $(this).find(".correct-checkbox").prop("id", "NewCorrect["+indexes[0]+"]["+(indexes[1]-1)+"]");
                $(this).find(".correct-label").prop("for", "NewCorrect["+indexes[0]+"]["+(indexes[1]-1)+"]");
                //console.log(indexes);
            });
            
            tr.remove();
        }
        
        // When the user clicks on the + behind the last alternative
        function addAlternative(element, qNum){
            var tr = $(element).closest("tr");
            while(!tr.is(".question-info"))
                tr = tr.prev();
            
            var numberOfAlternatives = tr.nextUntil(".question-top").length-1;
            
            if(numberOfAlternatives < 4){
                $(element).closest("tr").before(questionNewAlternative(qNum, numberOfAlternatives));
                
                refreshCheckboxClickListeners();
            }
        }
        
        // When the user clicks the X on a question
        function removeQuestion(element, qNum){
            var questionID = quizJSON.Questions[qNum].QuestionID;
            //console.log(questionID);
            submitJSON.Delete.Questions.push(questionID);
            $(element).closest(".question-section").fadeOut(500, function(){
                    $(this).remove()
                });
        }
        
        function removeNewQuestion(element){
            $(element).closest(".question-section").fadeOut(500, function(){
                    $(this).remove()
                });
        }
        
        // When the user clicks the button at the bottom to add a question
        function addQuestion(){
            var qNum = highestQuestionIndex;
            var aNum = 0;
            var emptyQuestion = "<table class='question-section'>"
            
                + "<tr class='question-top'><th>Nytt spørsmål"
                + "<i class='flaticon-cross93 delete-question' onclick='removeNewQuestion(this)'></i>"
                + "</th></tr>"
                
                + "<tr class='question-info'><td><div>Bilde</div></td></tr>"
                + "<tr class='question-image'><td>"
                + "<select>" + optionList + "</select>"
                + "</td></tr>"
                + "<tr class='question-image-preview'><td><img/></td></tr>"
            
                + "<tr class='question-info'><td><div>Spørsmål</div></td></tr>"
                + "<tr class='question-single'><td>"
                + "<input type='hidden' name='QuestionID' value='-1'/>"
                + "<input class='question-text' type='text' name='NewQuestionText' placeholder='...'/>"
                + "</td></tr>"
            
                + questionNewAlternatives(qNum)
            
                + "</table>";
            
            $(emptyQuestion).insertBefore($('.add-question-section', '#question-list'));
            highestQuestionIndex++;
            
            // Refresh image preview change-listener
            $(".question-image select").each(function(){
                $(this).change(refreshImagePreview);
            });
        }
        
        
        function questionNewAlternatives(i){
            var alternativesText = "<tr class='question-info'><td><div>Alternativer</div></td></tr>";
            
            for(var j=0; j<4; j++){
                alternativesText += questionNewAlternative(i, j);
            }
            
            alternativesText += questionAlternativePlus(i);
            
            return alternativesText;
        }
        
        /* SUBMIT */
        function submitQuiz(){
            $("#submit-quiz").html("Lagrer...");
            submitJSON.Update.QuizOfTheDay = 1;
            // Check quiz name
            var quizName = $("#quiz-name").val();
            if(quizJSON.QuizName != quizName){
                submitJSON.Update.QuizID = quizJSON.QuizID;
                submitJSON.Update.QuizName = quizName;
            }
            
            
            
            // Process questions with alternatives
            $(".question-section").each(function(outer){
                var questionID = $(this).find("input[name=QuestionID]").val();
                
                var questionTextTag = $(this).find(".question-text");
                var newQuestionText = questionTextTag.val();
                
                // Find ImageID selected
                $(this).find(".question-image select").each(function(){
                    imageID = $(this).val();
                });
                //console.log("imageID = " + imageID);
                
                if(questionID == -1){
                    // This section is a new question
                    var questionText = $(this).find("input[name=NewQuestionText]").val();
                    var alternatives = [];
                    
                    
                    $(this).find(".alternative-text").each(function(){
                        var alternativeText = $(this).val();
                        var correctBoolean = $(this).next("input[type=checkbox]").prop("checked");
                        var correctValue = (correctBoolean==true)?1:0;
                        
                        alternatives.push({
                            "AlternativeText": alternativeText, 
                            "AlternativeCorrect": correctValue
                        });
                    });
                    
                    submitJSON.Insert.Questions.push({
                        "QuestionText": questionText,
                        "Alternatives": alternatives,
                        "ImageID": imageID
                    });
                }else{
                    // This is an existing question
                    var pattern = /\d+/g;
                    var questionIndex = questionTextTag.prop("name").match(pattern);
                    
                    if(newQuestionText != quizJSON.Questions[questionIndex].QuestionText
                        || imageID != quizJSON.Questions[questionIndex].ImageID){
                        //console.log(questionIndex + " is not the same");
                        submitJSON.Update.Questions.push({
                            "QuestionID": questionID,
                            "QuestionText": newQuestionText,
                            "ImageID": imageID
                        });
                    }
                    
                    // Add new alternatives and correct-values to submitJSON
                    $(this).find("input[name^=NewAlternative]").each(function(index){
                        var alt = $(this).val();
                        var correctBoolean = $(this).next("input[name^=NewCorrect]").prop("checked");
                        var cor = (correctBoolean==true)?1:0;
                        var qID = $(this).closest("tr").prevAll(".question-single:first").find("input[name=QuestionID]").val();

                        submitJSON.Insert.Alternatives.push({"QuestionID": qID, "AlternativeText": alt, "AlternativeCorrect": cor});
                    });
                }
                
                
                // Check existing alternatives and correct
                $(this).find(".alternative-text:not(input[name^=NewAlternative])").each(function(){
                    // Find json array indexes
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
                        submitJSON.Update.Alternatives.push({
                            "AlternativeID": alternativeID, 
                            "AlternativeText": newAlternativeText, 
                            "AlternativeCorrect": newCorrectValue
                            });
                    }
                });
                
            });
            
            
            // Debug:
            //console.log(submitJSON);
            //return;
            
            $.ajax({
                url: "/bo15-g21/API/quiz_update.php",
                type: "POST",
                data: {SubmitJSON: submitJSON},
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(errorThrown);
                    $("#submit-quiz").html("Lagre endringene");
                    alert("Quiz could not be updated.");
                },
                success: function(data){
					console.log("update");
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
            <div id='question-panel' class='panel'>
                <!-- Javascript incoming -->
            </div>
        </div>
    </div>
</body>
</html>