function checkIfQuizIdIsNumber(quizId){
    return !isNaN(quizId);
}

function displayErrorMessage(){
    changePage('#errorQuizNotFoundDialog');
}

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
    var quizId = $("#txtInputQuizId").val();
    if(checkIfQuizIdIsNumber(quizId)){
        getQuiz(quizId);
    }
    else{
        displayErrorMessage();
    }
}