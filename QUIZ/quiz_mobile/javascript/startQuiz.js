var questionNumber = 0;
var correctAlternative;





function buildQuiz(){
    $('#question').text(getQuestion(questionNumber));
    var altCounter = 0;
    $.each(getAlternatives(questionNumber), function() { 
        $("#alt"+altCounter).html(this.AlternativeText);
        correctAlternative = altCounter;
        altCounter++;
    });
    startTimer(timerGoing);
}

