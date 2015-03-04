var resultJSON;
var quizId;

function checkIfQuizIdIsNumber(quizId){
    return !isNaN(quizId);
}

function getQuiz() {
    var quizId = $("#txtInputQuizId").val();
    if(checkIfQuizIdIsNumber(quizId) && quizId==1){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                resultJSON = JSON.parse(xmlhttp.responseText);
                if(resultJSON == "false"){
                    displayErrorMessage();
                }
                changePage('#quiz');
                localStorage.setItem("quiz",JSON.stringify(resultJSON));
                localStorage.setItem("quizId",quizId);
                buildQuiz()
            }
            if(xmlhttp.readyState==4 && xmlhttp.status==404){
                displayErrorMessage();
            }
        }
        xmlhttp.open("GET", "php/question_get.php", true);
        //xmlhttp.open("GET", "http://frigg.hiof.no/bo15-g21/API/question_get.php?action=select&QuizID=1", true);
        xmlhttp.send();
    }   
    else{
        displayErrorMessage();
    }
}

/*function getQuestion(qNum){
    $("#Question").html(resultJSON[qNum].QuestionText);
	$("#Alternatives").empty();
    updateQuizInfo(qNum);
    
    var alternativeArray = resultJSON[qNum].Alternatives;
    for(var i=0; i<alternativeArray.length; i++){
        addAlternative(alternativeArray[i].AlternativeText, i);
        if(alternativeArray[i].AlternativeCorrect == 1){
            correctAlternative = i;
        }
    }
}*/

function getQuestion(qNum){
    return resultJSON[qNum].QuestionText;
}

function getAlternatives(qNum){
    return resultJSON[qNum].Alternatives;
}

function displayErrorMessage(){
    changePage('#errorQuizNotFoundDialog');
}