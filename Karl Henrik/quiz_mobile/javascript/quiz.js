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
    resetQuiz();
    setQuestion();
    setTimer(timer);
    setAlternatives();
    startTimer(questionTimerGoing);
}

function setQuestion(){
    $('#question').text(getQuestion(questionNumber));
}

function resetQuiz(){
    $('#quiz #question').text("");
    $('#quiz #listAlt').html("");
}

function setAlternatives(){
    var altCounter = 0;
    $.each(getAlternatives(questionNumber), function() {
        $("#quiz #listAlt").append("<li class=liAlt id=liAlt"+altCounter+" onclick=onAlternativeClick("+altCounter+")><a class=aAlt id=alt"+altCounter+" >"+this.AlternativeText+"</a></li>").listview("refresh");
        $("#quiz #liAlt"+altCounter).css("background-color","#808080")
        $("#quiz #liAlt"+altCounter).children().css("color","#ffffff");
        if(this.AlternativeCorrect==1)
            correctAlternative = altCounter;
        altCounter++;
    });
}

function saveProgress(){
    localStorage("questionNumber",questionNumber);
    localStorage("answers",answers);
}