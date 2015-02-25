var MAX_POINTS = 1000;

var MIN_POINTS = 500;

var QUESTION_TIME = 15;


// True if the player have answered, false if not
var hasAnswered; 

// The players answere for current question
var answere;

// Object of current question
var currentQuestion;

// Players total score in quiz
var totalScore = 0;

// Start time when each question starts
var startTime;

// Time used on current question
var timeUsed;

// The spinner which runs when page is loading
var spinner;

var countdown;
// Letters used to grid view
var letters = ['a','b'];

window.quiz;

startUpScreen();

/**
* Event to choose which quiz we want to play
*/
function chooseQuiz(event){
	if(event.keyCode === 13 || event instanceof MouseEvent){
		var id = $("#basic").val();
		if(/[0-9]/.test(id)){
			quiz = new Quiz(Number(id));
			setUpSpinner();
		}else{
			popup("#invalidInput");
		}
	}
}

function startQuiz(){
	$("#getQuiz").css("display","none");
	setTimeout(populateQuestion, 2000);
}

function quizNotFound(){
	popup("#quizNotFound");
	removeSpinner();
}

function popup(id){
	$(id).popup("open");	
	setTimeout(function(){
		$(id).popup("close");
	},1500); 
		$("#basic").val('');
}

/**
*	Populate GUI with a question
*/
function populateQuestion(){
	removeSpinner();
	//Clear the div
	$("#alternatives").empty();
	$("#alternatives").removeClass("ui-grid-a ui-grid-b");
	
	// get next question in quiz
	currentQuestion = window.quiz.getNextQuestion();
	
	if(currentQuestion == null){
		showScore(true);	
		return;
	}
	
	// Initialize variables before question setup
	hasAnswered = false;
	answere = -1;
	
	//Toggle quiz and score vsibility
	$("#alternatives").css("display","block");
	$("#score").css("display","none");
	
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



/*
*	Start the Countdown clock
*/
function initializeCountdown(){
	$("#countdown").css("display","flex");
	countdown = $("#countdown").countdown360({
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
		});
	
	countdown.start();
	// get start time for calculation of points
	startTime = Date.now();
}

/**
* When the player press one of the answeres, the button gets chosen
*/
function chooseAlternative(alternative){
	if(!hasAnswered){
		timeUsed = Date.now() - startTime;
		hasAnswered = true;
		answere = alternative.getAttribute("id");
		alternative.className += " answere";
		countdown.stop();
		setTimeout(showCorrectAnswers, 400);
	}
}

	
function startUpScreen(){
	$("#score").css("display", "none");
	$("#getQuiz").css("display", "block");
	$("#quizQuestion").html("Velg Quiz");
}

function showScore(isEnd){
	//Toggle alternatives and score visibility
	$("#alternatives").css("display","none");
	$("#score").css("display","block");
	var title;
	if(isEnd){
		title = "Sluttresultat";
		setTimeout(startUpScreen, 2000);
	}else{
		title = "Resultat";
		setTimeout(populateQuestion, 2000);
	}
	$("#quizQuestion").html(title);
	$("#totalScore").html(totalScore);
}

/*
* 	Shows the correct answere by colour it. Also colors the player answere 
* 	if the answere is wrong
*/
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
	setTimeout(function(){showScore(!window.quiz.isMoreQuestions());}, 2000);
}
/**
*	Compute how many points the player gets based on time he has used.
*/
function computePoints(){
	var timeUsedSec = timeUsed / 1000;
	var points = MAX_POINTS - (MIN_POINTS/QUESTION_TIME * timeUsedSec);	
	totalScore += Math.round(points);
}

function setUpSpinner(){
	var opts = {
		  lines: 15, // The number of lines to draw
		  length: 7, // The length of each line
		  width: 3, // The line thickness
		  radius: 10, // The radius of the inner circle
		  corners: 1, // Corner roundness (0..1)
		  rotate: 0, // The rotation offset
		  direction: 1, // 1: clockwise, -1: counterclockwise
		  color: '#000', // #rgb or #rrggbb or array of colors
		  speed: 2, // Rounds per second
		  trail: 60, // Afterglow percentage
		  shadow: false, // Whether to render a shadow
		  hwaccel: false, // Whether to use hardware acceleration
		  className: 'spinner', // The CSS class to assign to the spinner
		  zIndex: 2e9, // The z-index (defaults to 2000000000)
		  top: '50%', // Top position relative to parent
		  left: '50%' // Left position relative to parent
	};
	var target = document.getElementById('questionScreen');
	spinner = new Spinner(opts).spin(target);

}

function removeSpinner(){
	spinner.stop();
}