window.quizSession = null;

// The spinner which runs when page is loading
var spinner;

initPage();

function initPage(){
	var url = window.location.href.split("#");
	if(url.length > 1){
		
		window.location.href = url[0];	
	}
}

function saveCookies(){
	//localStorage.setItem("cQuizSession", JSON.stringify(quizSession));
}

function getCookie(){
	//var session = localStorage.getItem("cQuizSession");
	//console.log(session);
}

function startQuiz(id, user){
	if(window.quizSession !== null){
		console.log(window.quizSession.user.UserCode);
		console.log(document.getElementById("userCode").value);
		if(window.quizSession.user.UserCode.toLowerCase() == document.getElementById("userCode").value.toLowerCase()){
			window.quizSession.continueQuiz();
			return;
		}
		window.quizSession.endQuizSession(true);
		
	}
	
	user = typeof user != 'undefined' ? user : null;
	if(user === null){
		window.quizSession = new QuizSession(Number(id));
	}else{
		window.quizSession = new QuizSession(Number(id), user);
	}
}


/**
* When the player press one of the answeres, the button gets chosen

*/
function answerClicked(alternative){
	if(!window.quizSession.hasAnswered){
		window.quizSession.answerClicked(alternative.getAttribute("id"));
		alternative.className += " answere";
	}
}


/**
*
*
*/
function pauseSession(){
	if(window.quizSession !== null){
		window.quizSession.pauseQuiz();	
	}
}