var questionNumber = 0;
var correctAlternative;

function initializeQuiz(){
    /*$(window).on("beforeunload",function(){
        alert("OK");
        $.cookie("questionNumber",questionNumber,{expires : 1});
        $.cookie("answers",answers,{expires : 1});
    });
    $(window).load(function(){
        var isRefreshed = $.cookie("isRefreshed");
        if(isRefreshed!=null && isRefreshed!=""){
            var quizId = $("#txtInputQuizId").val();
            if(checkIfQuizIdIsNumber(quizId)){
                getQuiz(quizId);
            }
            else{
                displayErrorMessage();
            }
        }
        else{
            resultJSON = $.cookie("quiz");
            buildQuiz();
        }
    });*/
    
}


function buildQuiz(){
    setQuestion();
    setTimer(timer);
    setAlternatives();
    startTimer(questionTimerGoing);
}

function setQuestion(){
    $('#question').text(getQuestion(questionNumber));
}

function setAlternatives(){
    var altCounter = 0;
    $.each(getAlternatives(questionNumber), function() { 
        $("#alt"+altCounter).html(this.AlternativeText);
        if(this.AlternativeCorrect==1)
            correctAlternative = altCounter;
        altCounter++;
    });
}

function saveProgress(){
    localStorage("questionNumber",questionNumber);
    localStorage("answers",answers);
}