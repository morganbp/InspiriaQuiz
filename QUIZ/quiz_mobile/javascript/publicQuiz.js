window.quiz = new Quiz();

function Quiz(){

	var fetchQuiz = function(){
		$.getJSON("tmp/jsonQuizExample.json", function(data){
			quiz.setQuiz(data);
			populateQuestion();
		});
	}
	
	fetchQuiz();
	this.quiz = null;
	this.questionNumber = 0;
	
	this.setQuiz = function(quiz){
		this.quiz = quiz;	
	}
	this.getQuestion = function(number){
		this.questionNumber = number + 1;
		if(number < this.quiz.quiz.length){
			return this.quiz.quiz[number];
		}else{
			return null;
		}
	}
	
	/**
	*	Gets the next question based on where in the quiz you are located
	*/
	this.getNextQuestion = function(){
		return this.getQuestion(this.questionNumber);	
	}


	/**
	*	Gets the question by which number it is located in the quiz
	*/
	this.getQuestionByNumber = function(number){
		return this.getQuestion(number);
	}

	/**
	*	Gets the quiz by the id of the question
	*/
	this.getQuestionById = function(questionId){
		if(window.quiz === null) return null;	

		for(var i = 0; i < window.quiz.quiz.length; i++){
			if(window.quiz.quiz[i].QuestionId === questionId){
				window.questionNumber = i + 1;
				return this.getQuestion(i);	
			}
		}
		return null;
	}
}

