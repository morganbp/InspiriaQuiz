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
	// check if there is a quiz running
	if(window.quizSession !== null){
		// check if the code is the same code for the user running the quiz
		if(window.quizSession.user.UserCode.toLowerCase() == document.getElementById("userCode").value.toLowerCase()){
			window.quizSession.continueQuiz();
			return;
		}
		// if there is another user, end previous session and start a new session
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
* Show error message from jQuery Dialog 
*/
function showErrorMessage(data, id){
	// SHOW ERROR MESSAGE
	$(id).html("<p>" + data.Error + "</p>");
	$(id).popup("open");
	setTimeout(function(){
		$(id).popup("close");
		$(id).html("");
	}, 1500);	
}

/**
*
*
*/
function pauseSession(){
	if(window.quizSession !== null){
		window.quizSession.pauseQuiz();	
		window.location.href = "/inspiriaQuiz/QUIZ/quiz_mobile/";
	}
}