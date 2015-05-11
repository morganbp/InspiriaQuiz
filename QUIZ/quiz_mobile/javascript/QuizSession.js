function QuizSession(quizId, user){
	user = typeof user !== 'undefined' ? user : null;
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
	// user who takes the quiz
	this.user;
	
	// Is the quiz active
	this.active = true;
	
	/**
	*
	* 	Calculate the players score based on time he has used.
	*
	*/
	this.updateScore = function(){
		var timeUsedSec = Number(this.countdown.totalSeconds - this.countdown.seconds);
		var points = this.maxPoints - (this.minPoints/this.questionTime * timeUsedSec);	

		this.totalScore += Math.round(points);
	}
	
	this.pauseQuiz = function(){
		if(this.active){
			this.active = false;
		}
		
	}
	
	this.continueQuiz = function(){
		this.active = true;
	}
	
	this.nextQuestion = function(){
		// get next question in quiz
		this.currentQuestion = this.quiz.getQuestion();
		
		if(this.currentQuestion == null){
			if(this.user !== null)
				this.endQuizSession();
			else
				this.quizGuiHandler.showRegisterScheme();
			return;
		}
		this.quizGuiHandler.showReadyNextQuestion(this.currentQuestion);
	}
	/**
	*
	*	Get a new question and set up GUI for question
	*
	*/
	this.startQuestion = function(){
		this.hasAnswered = false;
		this.answer = -1;
		this.quizGuiHandler.showQuestion(this.currentQuestion);
		this.countdown.initialTimer();
	}
	
	this.answerClicked = function(answer){
		if(!this.hasAnswered){
			this.hasAnswered = true;
			this.answer = answer;	
			this.countdown.stop();
			if(this.user !== null){
				var dbHandler = new QuizDBHandler();
				dbHandler.postAnswer(this.currentQuestion.Alternatives[this.answer].AlternativeID, this.user.UserID);
			}
		}
	}
	
	this.endQuestion = function(){
		this.hasAnswered = true;
		// If answer is correct
		if(this.answer !== -1 && this.currentQuestion.Alternatives[this.answer].AlternativeCorrect === 1){
			this.updateScore();	
		}
		this.quizGuiHandler.showCorrectAnswer(this.answer, this.currentQuestion);
		var score = this.totalScore + "";
		setTimeout(function(){window.quizSession.quizGuiHandler.showScore(score);}, 2000);
	}
	
	this.endQuizSession = function(abort){
		var isaborting = (typeof abort === "undefined") ? false : abort;
		if(!abort){
			// Submit score
			var dbHandler = new QuizDBHandler();

			dbHandler.submitQuizResults(this.quiz.quizJson.QuizID, this.user.UserID, this.totalScore);
				// navigate back to main screen
			window.location.href = "#";
		}else{
			if(this.countdown.running)
				this.countdown.stop(true);	
			
		}
		window.quizSession = null;
		
	}
		
	this.QuizSession = function(id, user){
		this.quiz = new QuizData(id);
		this.user = user;
		this.quizGuiHandler = new QuizGuiHandler();
		this.countdown = new SpinnerCounter(document.getElementById("countdown"),function(){window.quizSession.endQuestion();});
	}
	
	this.QuizSession(quizId, user);
}