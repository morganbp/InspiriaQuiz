function initData(resp){
	var str = JSON.stringify(resp.data);
	window.quizData = JSON.parse(str);
	currentQuestion = -1;
}

function updateParticipants(resp){
	var str = JSON.stringify(resp.data);
	window.participants = JSON.parse(str);	
}