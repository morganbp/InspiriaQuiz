window.quizSession;

// The spinner which runs when page is loading
var spinner;

function saveCookies(){
	localStorage.setItem("cQuizSession", JSON.stringify(quizSession));
}

function getCookie(){
	var session = localStorage.getItem("cQuizSession");
	console.log(session);
}

startUpScreen();
/**
* Event to choose which quiz we want to play
*/
function chooseQuiz(event){
	if(event.keyCode === 13 || event instanceof MouseEvent){
		var id = $("#basic").val();
		if(/[0-9]/.test(id)){
			startQuiz(id);
		}else{
			popup("#invalidInput");
		}
	}
}

function startQuiz(id, host){
	host = typeof host != 'undefined' ? host : false;
	if(host){
		window.quizSession = new QuizSession(Number(id));
	}else{
		window.quizSession = new QuizSession(Number(id));
		setUpSpinner();
	}
}


function popup(id){
	$(id).popup("open");	
	setTimeout(function(){
		$(id).popup("close");
	},1500); 
		$("#basic").val('');
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

	
function startUpScreen(){
	$("#quiz").css("display", "none");
	$("#getQuiz").css("display", "block");
	$("#quizQuestion").html("Velg Quiz");
}

function quizNotFound(){
	popup("#quizNotFound");
	removeSpinner();
}
function setUpSpinner(){
	$.mobile.loading('show');
}

function removeSpinner(){
	$.mobile.loading('hide');
}