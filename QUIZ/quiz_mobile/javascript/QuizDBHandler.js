function QuizDBHandler(){
	
	this.dbDIR = /*"http://frigg.hiof.no/bo15-g21/API/quiz_get.php"*/ "http://localhost/inspiriaQuiz/API/";
	this.getQuizJsonByID = function(quizID, dataCollecter){
		"use strict";
		$.ajax({
			url: this.dbDIR + "quiz_get.php", 
			data: {QuizID: quizID},
			type: 'POST',
			error: function(XMLHttpRequest, textStatus, errorThrown){
				return null; //No quiz found, or QuizID invalid.
			},
			success: function(data){
				dataCollecter(data);
			}
		});

	}
	
	this.submitQuizResults = function(quizID, userID, score){
		"use strict";
		$.ajax({
			url: this.dbDIR + "score_post.php", 
			data: {QuizID: quizID, UserID: userID, Score: score},
			type: 'POST',
			error: function(XMLHttpRequest, textStatus, errorThrown){
				return null;
			},
			success: function(data){
				return data;
			}
		});
	}
	
	this.submitPersonInfo = function(){
		
	}
	
}