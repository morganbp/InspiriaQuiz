<html>
    <head>
        <meta charset="utf-8">
        <script src="jquery-2.1.3.js"></script>
        
        <script>
            var alternativeNumber = 2;
            function newAlternative(){
                alternativeNumber++;
                $('#questionForm').append('<p>Alternative '+alternativeNumber+' <input type="text" name="Alternative[]"/><input type="checkbox" name="Correct" value="'+(alternativeNumber-1)+'"/></p>');
            }
            function removeAlternative(){
                alternativeNumber--;
                $('#questionForm p:last-child').remove();
            }
        </script>
    </head>
    <body>
        <div id="wrapper">
            <div id="content">
                <div class="login">
                    <form id="questionForm" method="post" action="http://localhost/InspiriaQuiz/DB/question_insert.php">
                        <p>Quiz ID: <input type="text" name="QuizID"/></p>
                        <p>Spørsmål: <input type="text" name="QuestionText"/></p>
                        <p>Alternativ 1 <input type="text" name="Alternative[]"/><input type="checkbox" name="Correct" value="0"/></p>
                        <p>Alternativ 2 <input type="text" name="Alternative[]"/><input type="checkbox" name="Correct" value="1"/></p>
                        <input type="submit" value="Legg til spørsmålet"/>
                        
                    </form>
                    <button type="button" onclick="newAlternative()">Nytt alternativ</button>
                    <button type="button" onclick="removeAlternative()">Fjern alternativ</button>
                </div>
            </div>
        </div>
    </body>
</html>