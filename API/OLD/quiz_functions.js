function getQuizByID(quizID) {
    "use strict";
    $.ajax({
        url: "quiz_get.php", 
        data: {QuizID: quizID},
        type: 'post',
        error: function(XMLHttpRequest, textStatus, errorThrown){
            return false; //No quiz found, or QuizID invalid.
        },
        success: function(data){
            //getQuestionByNumber(data, 0);
            return data;
        }
    });
}

function getQuestionByNumber(quiz, questionNum){
    return quiz[questionNum];
    //alert(JSON.stringify(quiz[questionNum]));
}