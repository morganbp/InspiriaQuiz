var resultJSON;

function getQuiz() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			resultJSON = JSON.parse(xmlhttp.responseText);
            numberOfQuestions = resultJSON.length;
            getQuestion(0);
		}
	}
    xmlhttp.open("GET", "question_get.php", true);
	//xmlhttp.open("GET", "http://frigg.hiof.no/bo15-g21/API/question_get.php?action=select&QuizID=1", true);
	xmlhttp.send();
}

function getQuestion(qNum){
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
}