function nextQuestion(){
	
}

function updateParticipants(){
	
}

function createQuizSession(id){
	conn.send('{"quiz-id":"'+ id +'", "request-type":"' + window.CREATE_QUIZ_SESSION + '"}');

}

function nextQuestion(){
	conn.send('{"request-type":"'+window.NEXT_QUESTION+'", "quiz-key":"'+ window.quizData["quiz-key"]+'"}');
}

function updateUserList(){
	var part = participants.participants;
	$("#participants").empty();
	for(var i = 0; i < part.length; i++){
		$("#participants").append("<li>" + part[i].username + "</li>");
	}
}