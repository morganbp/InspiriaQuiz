function QuizData(ID){
	
	this.quizJson = null;
	this.questionNumber = -1;
	
	this.setQuizJson = function(quiz){
		this.quizJson = quiz;
	}
	
	this.getQuestion = function(){
		if(this.questionNumber < this.quizJson.Questions.length){
			return this.quizJson.Questions[++this.questionNumber];
		}else{
			return null;
		}	
	}
	
	this.QuizData = function(quizID){
		var qd = this;
		var dbHandler = new QuizDBHandler();
		dbHandler.getQuizJsonByID(quizID, function(data){qd.getData(data)});
	}
	
	this.getData = function(data){
		if(data !== null){
			this.setQuizJson(data);
			window.quizSession.startQuestion();
		}else{
			quizNotFound();
		}
		
	}
	
	this.QuizData(ID);
}