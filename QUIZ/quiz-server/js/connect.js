/**
*
*	CONNECTION TO SERVER, REMEMBER IMPLEMENT THESE FUNCTIONS:
*
*	nextQuestion()	Called when host goes to next question
*
*	updateParticipants()	Called when there is a new participant
*						to the quiz. 
*
*
*/

/**
*		GLOBAL CONSTANTS
*/
window.CREATE_QUIZ_SESSION = "CREATE_QUIZ_SESSION_SESSION";
window.CONNECT_TO_QUIZ = "CONNECT_TO_QUIZ";
window.NEXT_QUESTION = "NEXT_QUESTION";
window.ANSWERE_QUESTION = "ANSWERE_QUESTION";
window.DELETE_QUIZ_SESSION = "DELETE_QUIZ_SESSION";
window.INIT_QUIZ = "INIT_QUIZ";
window.NEW_PARTICIPANT = "NEW_PARTICIPANT";
window.UPDATED_PARTICIPANTS = "UPDATED_PARTICIPANTS";
window.ERROR_MESSAGE = "ERROR_MESSAGE";

/**
*		GLOBAL VARIABLES
*/
window.currentQuestion = -1;
window.quizData;
window.participants;

/**
*
*	Creates a WebSocket to the server.
*
*/
window.conn = new WebSocket('ws://158.39.175.164:8080');
conn.onopen = function(e) {
	console.log("Connection established!");	
};

/**
*
*	Response from server. Ther response is a JSON object, and contains a 
*	key named "request-type", which states kind of response which comes from 
*	the server.
*
*/
conn.onmessage = function(e){

	var resp = JSON.parse(e.data);

	console.log(resp);
	switch(resp["request-type"]){
		case window.NEXT_QUESTION:
			nextQuestion();
			break;
		case window.INIT_QUIZ:
			initData(resp);
			break;
		case window.UPDATED_PARTICIPANTS:
			updateParticipantVariable(resp);
			updateParticipants();
			break;
	}

}

/**
*
*	When receivieng data from server, store the JSON object in global 
*	variable quizData
*
*/
function initData(resp){
	var str = JSON.stringify(resp.data);
	window.quizData = JSON.parse(str);
}

/**
*	
*	Updates the variable which holds the number of participants
*
*/
function updateParticipantVariable(resp){
	var str = JSON.stringify(resp.data);
	window.participants = JSON.parse(str);
}