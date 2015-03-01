function Quiz(id){
	
	this.quiz = null;
	this.title = "";
	this.questionNumber = 0;
	
	this.setQuiz = function(quiz){
		this.quiz = quiz;	
	}
	
	this.setTitle = function(title){
		this.title = title;	
	}
	
	this.getQuestion = function(number){
		this.questionNumber = number + 1;
		
		if(number < this.quiz.length){
			return this.quiz[number];
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
		if(this.quiz === null) return null;	

		for(var i = 0; i < window.quiz.length; i++){
			if(this.quiz[i].QuestionId === questionId){
				this.questionNumber = i + 1;
				return this.getQuestion(i);	
			}
		}
		return null;
	}
	
	this.getTitle = function(){
		return this.title;	
	}
	
	this.isMoreQuestions = function(){
		if(this.questionNumber < this.quiz.length){
			return true;
		}else{
			return false;	
		}
	}
	
	// GET data from database
	this.fetchQuiz = function(quizId){
		var quiz = this;
		"use strict";
		$.ajax({
			url: /*"http://frigg.hiof.no/bo15-g21/API/quiz_get.php"*/ "http://localhost/inspiriaQuiz/DB/quiz_get.php", 
			data: {QuizID: quizId},
			type: 'POST',
			error: function(XMLHttpRequest, textStatus, errorThrown){
				quizNotFound(); //No quiz found, or QuizID invalid.
			},
			success: function(data){
				quiz.saveData(data);
			}
		});
	}
	// save data to object
	this.saveData = function(data){
		this.setQuiz(JSON.parse(JSON.stringify(data.Questions)));
		this.setTitle(JSON.stringify(data.QuizName));
		window.quizSession.startQuiz();
	}
	
	this.fetchQuiz(id);
}