var resultJSON;
var questionNumber = 0;

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

function checkIfQuizIdIsNumber(quizId){
    return !isNaN(quizId);
}

function displayErrorMessage(){
    changePage('#errorQuizNotFoundDialog');
}

function buildQuiz(){
    $('#question').text(getQuestion(questionNumber));
    var counter = 0;
    $.each(getAlternatives(questionNumber), function() { 
        $("#alt"+counter).html(this.AlternativeText);
        counter++;
    });
}

function getQuestion(qNum){
    return resultJSON[qNum].QuestionText;
}

function getAlternatives(qNum){
    return resultJSON[qNum].Alternatives;
}

function getQuiz(quizId) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
            changePage('#quiz');
			resultJSON = JSON.parse(xmlhttp.responseText);
            if(resultJSON == "false"){
                displayErrorMessage();
            }
            //$.cookie("quiz",resultJSON,{expires : 1});
            buildQuiz()
		}
	}
    xmlhttp.open("GET", "php/question_get.php", true);
	//xmlhttp.open("GET", "http://frigg.hiof.no/bo15-g21/API/question_get.php?action=select&QuizID=1", true);
	xmlhttp.send();
}