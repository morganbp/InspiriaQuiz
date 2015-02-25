var hasAnswered; 

var letters = ['a','b'];

var currentQuestion;

function populateQuestion(){
	//Clear the div
	$("#alternatives").empty();
	$("#alternatives").removeClass();
	$("#countdown").css("display","none");
	
	
	// get next question in quiz
	currentQuestion = window.quiz.getNextQuestion();
	
	if(currentQuestion == null){
		endOfQuiz();	
		return;
	}
	
	hasAnswered = false;
	
	// SETUP QUESTION
	$("#quizQuestion").text(currentQuestion.QuestionText);
	
	// SETUP ALTERNATIVES
	var alternatives = currentQuestion.Alternatives;
	
	//determain how many rows there is
	var gridType = letters[Math.ceil((alternatives.length / 2)-1)];
	var className = "ui-grid-" + gridType;
	
	
	$("#alternatives").add("div").addClass(className);
	
	// set up each alternative block
	
	
	for(var i = 0; i < alternatives.length; i++){
		
		// set the class name of each block.
		className = "ui-block-" + letters[i%2];
		
		// append the box
		$("#alternatives").append('<div id="' + i + '" class="'+ className +' centerHorizontal alternative" style="width:49%;" onclick="chooseAlternative(this);"><span>'+alternatives[i].AlternativeText +'</span></div>');
	}
	
	initializeCountdown();
}

function initializeCountdown(){
	$("#countdown").css("display","flex");
	$("#countdown").countdown360({
		radius      : 80,
		seconds     : 5,
		strokeWidth : 10,
		fillStyle   : '#888',
		strokeStyle : '#666',
		fontSize    : 80,
		fontColor   : '#FFF',
		autostart: false,
		label: false,
			onComplete  : populateQuestion
		}).start()
}

function chooseAlternative(alternative){
	if(!hasAnswered){
		hasAnswered = true;
		alternative.className += " answere";
	}
}

function endOfQuiz(){
	$("#quizQuestion").text("Resultat");
}