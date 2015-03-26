function QuizDBHandler(){
	
	this.getQuizJsonByID = function(quizID, dataCollecter){
		"use strict";
		$.ajax({
			url: /*"http://frigg.hiof.no/bo15-g21/API/quiz_get.php"*/ "http://localhost/Bach/Quiz/quiz_mobile/API/quiz_get.php", 
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
	
	this.submitQuizResults = function(){
		
	}
	
	this.submitPersonInfo = function(){
		
	}
	
}