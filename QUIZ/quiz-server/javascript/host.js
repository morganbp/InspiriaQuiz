function nextQuestion(){
	
}

function updateParticipants(resp){
	window.participants = resp;
	if(window.currentQuestion < 0){
		window.quizGui.populateParticipants(resp.data);
	}
}



function nextQuestion(){
	conn.send('{"request-type":"'+window.NEXT_QUESTION+'", "quiz-key":"'+ window.quizData["quiz-key"]+'"}');
}



/**
*s
*	When receivieng data from server, store the JSON object in global 
*	variable quizData
*
*/
function initData(resp){
	var str = JSON.stringify(resp.data);
	window.quizData = JSON.parse(str);
	window.quizGui = new HostGuiHandler();
	window.quizGui.setStartScreen(resp.data);
}

function connected(){
	createQuizSession(1);
}