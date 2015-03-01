function QuizSession(quizId){
	
	// constant for Quiz Mode
	this.QUIZ_MODE = "QUIZ_MODE";
	
	// constant for Score Mode
	this.SCORE_MODE = "SCORE_MODE";
	
	// Maximum points for each question
	var maxPoints = 1000;
	// Minimum points for each question
	var minPoints = 500;
	// Time used  
	var questionTime = 15;
	
	// True if the player have answered, false if not
	var hasAnswered; 
	// The players answere for current question
	var answere;

	// Object of current question
	var currentQuestion;

	// Players total score in quiz
	var totalScore = 0;
	
	// if the quiz is in "Quiz mode" or "Score mode"
	var mode = this.QUIZ_MODE;
	
	// Letters used to grid view
	var letters = ['a','b'];

	// The countdown object
	var countdown;
	
	// The quiz object containing the quiz
	var quiz = new Quiz(quizId);
	
	this.getMaxPoints = function(){
		return maxPoints;
	}
	this.setMaxPoints = function(points){
		maxPoints = points;	
	}
	
	this.getMinPoints = function(){
		return minPoints;
	}
	this.setMinPoints = function(points){
		minPoints = points;
	}
	
	this.getQuestionTime = function(){
		return questionTime;	
	}
	this.setQuestionTime = function(time){
		questionTime = time;	
	}
	
	this.getCurrentQuestion = function(){
		return currentQuestion;
	}
	
	this.setCurrentQuestion = function(curQues){
		currentQuestion = curQues;
	}
	
	this.hasAnswered = function(){
		return hasAnswered;	
	}
	
	this.setHasAnswered = function(answered){
			hasAnswered = answered;
	}
	
	this.getAnswere = function(){
		return answere;	
	}
	
	this.setAnswere = function(ans){
		answere = ans;	
	}
	
	this.getTotalScore = function(){
		return totalScore;	
	}
	
	this.setTotalScore = function(score){
		totalScore = score;
	}
	
	this.addTotalScore = function(score){
		totalScore += score;	
	}
	
	this.getQuiz = function(){
		return quiz;	
	}
	
	this.getMode = function(){
		return mode;	
	}
	
	this.setMode = function(newMode){
		mode = newMode;
	}
	
	this.getCountdown = function(){
		return countdown;	
	}
	
	this.setCountdown = function(countd){
		countdown = countd;	
	}
	
	/**
	*	Compute how many points the player gets based on time he has used.
	*/
	this.computePoints = function(){
		var timeUsed = this.getCountdown().computeTimeUsed();
		var timeUsedSec = timeUsed / 1000;
		var points = this.getMaxPoints() - (this.getMinPoints()/this.getQuestionTime() * timeUsedSec);	
		this.addTotalScore(Math.round(points));
	}
	
	/**
	*	Populate GUI with a question
	*/
	this.populateQuestion = function(){
		
		removeSpinner();
		//Clear the div
		this.clearAlternativesDiv();
		
		// get next question in quiz
		this.setCurrentQuestion(quizSession.getQuiz().getNextQuestion());

		if(this.getCurrentQuestion() == null){
			this.showScore(true);	
			return;
		}
		
		// Initialize variables before question setup
		this.resetQuestionVariables();
		

		//Toggle quiz and score vsibility
		this.toggleQuizScore();

		this.setupQuestionGui();
		

		this.initializeCountdown();
	}
	/**
	*	Start the quiz
	*/
	this.startQuiz = function(){
		$("#countdown").css("display", "block");
		$("#getQuiz").css("display","none");
		totalScore = 0;
		setTimeout(function(){quizSession.populateQuestion();}, 2000);
	}

	/*
	* 	Shows the correct answere by colour it. Also colors the player answere 
	* 	if the answere is wrong
	*/
	this.showCorrectAnswers = function(){
		for(var i = 0; i < currentQuestion.Alternatives.length; i++){
			if(currentQuestion.Alternatives[i].AlternativeCorrect === 1){
				$("#"+i).addClass("correct");
				if(answere == i){
					this.computePoints();
				}
			}else{
				if(answere == i){
					$("#"+i).addClass("wrong");	
				}
			}
		}
		setTimeout(function(){quizSession.showScore(!quizSession.getQuiz().isMoreQuestions());}, 2000);
	}
	
	this.showScore = function(isEnd){
		//Toggle alternatives and score visibility
		this.toggleQuizScore();
		var title;
		if(isEnd){
			title = "Sluttresultat";
			setTimeout(startUpScreen, 2000);
		}else{
			title = "Resultat";
			setTimeout(function(){quizSession.populateQuestion();}, 2000);
		}
		$("#quizQuestion").html(title);
		$("#totalScore").html(quizSession.getTotalScore());
	}
	
	/*
	*	Start the Countdown clock
	*/
	this.initializeCountdown = function(){
		this.startCountdown(new Countdown(function(){quizSession.showCorrectAnswers();}, quizSession.getQuestionTime()*1000));
	}
	
	
	
	this.startCountdown = function(countdown){
		this.setCountdown(countdown);
		this.getCountdown().start(100);
	}
	
	this.userAnswers= function(answere){
		this.setHasAnswered(true);
		this.setAnswere(answere);	
		this.getCountdown().stop();
	}
	
	this.clearAlternativesDiv = function(){
		$("#alternatives").empty();
		$("#alternatives").removeClass("ui-grid-a ui-grid-b");	
	}
	
	this.resetQuestionVariables = function(){
		this.setHasAnswered(false);
		this.setAnswere(-1);
	}
	/**
	*	toggles between score mode and quiz mode
	*/
	this.toggleQuizScore = function(){
		switch(this.getMode()){
			case this.QUIZ_MODE:
				$("#alternatives").css("display","block");
				$("#score").css("display","none");	
				this.setMode(this.SCORE_MODE);
				break;
			case this.SCORE_MODE:
				$("#score").css("display","block");
				$("#alternatives").css("display","none");
				this.setMode(this.QUIZ_MODE);
				break;
		}
	}
	
	/**
	*	Sets up the Gui for current question
	*/
	this.setupQuestionGui = function(){
		// SETUP QUESTION
		$("#quizQuestion").text(this.getCurrentQuestion().QuestionText);

		// SETUP ALTERNATIVES
		var alternatives = this.getCurrentQuestion().Alternatives;

		//determain how many rows there is
		var gridType = letters[Math.ceil((alternatives.length / 2)-1)];
		var className = "ui-grid-" + gridType;

		//Set class name for categorizing grid type
		$("#alternatives").addClass(className);

		// set up each alternative block
		for(var i = 0; i < alternatives.length; i++){
			// set the class name of each block.
			className = "ui-block-" + letters[i%2];

			// append the box
			$("#alternatives").append('<div id="' + i + '" class="'+ className +' centerHorizontal alternative" style="width:49%;" onclick="chooseAlternative(this);"><span>'+alternatives[i].AlternativeText +'</span></div>');
		}
	}
	
	
}