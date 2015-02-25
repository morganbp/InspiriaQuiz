var MAX_POINTS = 1000;

var MIN_POINTS = 500;

var QUESTION_TIME = 15;


// true if the user have answered, false if not
var hasAnswered; 

// Users answere for current question
var answere;

// Object of current question
var currentQuestion;

// users total score in quiz
var totalScore = 0;

// start time when each question starts
var startTime;

// time used on current question
var timeUsed;

// letters used to grid view
var letters = ['a','b'];

/**
*
*	Populate GUI with a question
*
*/
function populateQuestion(){
	//Clear the div
	$("#alternatives").empty();
	$("#alternatives").removeClass("ui-grid-a ui-grid-b");
	
	// get next question in quiz
	currentQuestion = window.quiz.getNextQuestion();
	
	if(currentQuestion == null){
		endOfQuiz();	
		return;
	}
	
	// Initialize variables before question setup
	hasAnswered = false;
	answere = -1;
	
	// SETUP QUESTION
	$("#quizQuestion").text(currentQuestion.QuestionText);
	
	// SETUP ALTERNATIVES
	var alternatives = currentQuestion.Alternatives;
	
	//determain how many rows there is
	var gridType = letters[Math.ceil((alternatives.length / 2)-1)];
	var className = "ui-grid-" + gridType;
	
	
	$("#alternatives").addClass(className);
	
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
		radius      : 25,
		seconds     : QUESTION_TIME,
		strokeWidth : 4,
		fillStyle   : '#888',
		strokeStyle : '#666',
		fontSize    : 25,
		fontColor   : '#FFF',
		autostart: false,
		label: false,
		onComplete  : showCorrectAnswers
		}).start()
	
	startTime = Date.now();
}

function chooseAlternative(alternative){
	if(!hasAnswered){
		timeUsed = Date.now() - startTime;
		hasAnswered = true;
		answere = alternative.getAttribute("id");
		alternative.className += " answere";
	}
}

function endOfQuiz(){
	$("#quizQuestion").text("Resultat");
	$("#alternatives").css("display","none");
	$("#score").css("display","block");
	$("#score").html('<h3>Din poengsum:</h3> <div id="totalScore">' + totalScore + '</div>');
}

function showCorrectAnswers(){
	$("#countdown").css("display","none");
	for(var i = 0; i < currentQuestion.Alternatives.length; i++){
		if(currentQuestion.Alternatives[i].AlternativeCorrect === 1){
			$("#"+i).addClass("correct");
			if(answere == i){
				computePoints();
			}
		}else{
			if(answere == i){
				$("#"+i).addClass("wrong");	
			}
		}
	}
	setTimeout(populateQuestion, 2000);
}

function computePoints(){
	var timeUsedSec = timeUsed / 1000;
	var points = MAX_POINTS - (MIN_POINTS/QUESTION_TIME * timeUsedSec);	
	totalScore += Math.round(points);
}