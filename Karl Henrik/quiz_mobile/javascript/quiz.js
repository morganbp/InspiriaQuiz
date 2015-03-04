var questionNumber = 0;
var correctAlternative;

function buildQuiz(){
    resetQuiz();
    setQuestion();
    setTimer(timer);
    setAlternatives();
    startTimer(questionTimerGoing);
}

function setQuestion(){
    var question = getQuestion(questionNumber)
    if(question == undefined){
        quizDone = true;
        return;
    }
    $('#question').text(question);
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