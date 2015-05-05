function QuizDBHandler(){
	
	this.dbDIR = /*"/bo15-g21/API/"*/ "/inspiriaQuiz/API/";
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
	
	this.getUserData = function(endEvt, userID, userCode){
	"user strict";
	postData = {};
		
	if(userID !== "undefined" && userID !== null)
		postData.UserID=userID;
	if(userCode !== "undefined" && userCode !== null)
		postData.UserCode=userCode;
	$.ajax({
			url: this.dbDIR + "user_get.php", 
			data: postData,
			type: 'POST',
			error: function(XMLHttpRequest, textStatus, errorThrown){
				endEvt(JSON.parse(XMLHttpRequest.responseText));
			},
			success: function(data){
				endEvt(data);
			}
		});
	}
}