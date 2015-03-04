var isAltClicked = false;
var isQuizDone = false;

function onAlternativeClick(alt){
    if(isAltClicked==false){
        isAltClicked=true;
        questionAnswered(alt);
        editAltColors(alt);
    }
}

function editAltColors(alt){
    if(alt!=correctAlternative){
        $("#liAlt"+alt).css("background-color","#ff0000");
        $("#liAlt"+alt).children().css("color","#000000");
    }
    $("#liAlt"+correctAlternative).css("background-color","#00ff00")
    $("#liAlt"+correctAlternative).children().css("color","#000000");
}

function questionAnswered(alt){
    stopTimer();
    editAltColors(alt)
    setTimeout(function(){showScore(alt);},2000);
}

function showScore(alt){
    $.mobile.changePage("#scoreDialog",{role: "page"});
    if(alt==correctAlternative){
        computeScore(timer);
    }
    else{
        computeScore(0);
    }
    updateScoreDialog();
    setTimeout(function(){
        updateScore();
        $.mobile.changePage("#quiz", {role: "page"});
        setupNextQuestion();
    },2000);
}

function setupNextQuestion(){
    questionNumber++;
    buildQuiz();
    isAltClicked = false;
}