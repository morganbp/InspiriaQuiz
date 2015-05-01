function QuizSession(quizId, quizData){
	quizData = typeof quizData !== 'undefined' ? quizData : null;
	// Maximum points for each question
	this.maxPoints = 1000;
	// Minimum points for each question
	this.minPoints = 500;
	// Time used  
	this.questionTime = 15;
	
	// True if the player have answered, false if not
	this.hasAnswered = false; 
	// The players answer for current question
	this.answer = -1;

	// Object of current question
	this.currentQuestion;

	// Players total score in quiz
	this.totalScore = 0;

	// The countdown object
	this.countdown;
	
	// The quiz object containing the quiz
	this.quiz;
	
	this.quizGuiHandler; 
	
	/**
	*
	* 	Calculate the players score based on time he has used.
	*
	*/
	this.updateScore = function(){
		var timeUsed = Number(this.countdown.totalSeconds - this.countdown.seconds);
		var timeUsedSec = timeUsed / 1000;
		var points = this.maxPoints - (this.minPoints/this.questionTime * timeUsedSec);	

		this.totalScore += Math.round(points);
	}
	
	/**
	*
	*	Get a new question and set up GUI for question
	*
	*/
	this.startQuestion = function(){
		this.hasAnswered = false;
		this.answer = -1;
		
		this.quizGuiHandler.toggleQuizScore();
		
		removeSpinner();
		
		// get next question in quiz
		this.currentQuestion = this.quiz.getQuestion();
		if(this.currentQuestion == null){
			this.endQuizSession();
			return;
		}
		
		this.quizGuiHandler.setQuestion(this.currentQuestion.QuestionText);
		this.quizGuiHandler.setAlternatives(this.currentQuestion.Alternatives);
<<<<<<< HEAD
		this.quizGuiHandler.setScore("" + this.totalScore);
=======
		
>>>>>>> 2f865a36b0802d8243fa540ed5119c2831b3d639
		this.countdown.initialTimer();
	}
	
	this.answerClicked = function(answer){
		if(!this.hasAnswered){
			this.hasAnswered = true;
			this.answer = answer;	
			this.countdown.stop();
		}
	}
	
	this.endQuestion = function(){
		// If answer is correct
		if(this.answer !== -1 && this.currentQuestion.Alternatives[this.answer].AlternativeCorrect === 1){
			this.updateScore();	
		}
		this.quizGuiHandler.showCorrectAnswer(this.answer, this.currentQuestion);
		setTimeout(function(){window.quizSession.quizGuiHandler.showScore(this.totalScore)}, 2000);
	}
	
	this.endQuizSession = function(){
		// Submit score
		var dbHandler = new QuizDBHandler();
		var userID = 3;
		dbHandler.submitQuizResults(this.quiz.quizJson.QuizID, userID, this.totalScore);
		
		window.quizSession = null;
		startUpScreen();
	}
		
	this.QuizSession = function(id, quizData){
		if(quizData == null){
			this.quiz = new QuizData(id);
			this.quizGuiHandler = new QuizGuiHandler();
			this.countdown = new SpinnerCounter(document.getElementById("countdown"), function(){window.quizSession.endQuestion()});
		}else{
			this.quiz = quizData;
			this.quizGuiHandler = new HostGuiHandler();
		}
	}
	
	this.QuizSession(quizId, quizData);
}