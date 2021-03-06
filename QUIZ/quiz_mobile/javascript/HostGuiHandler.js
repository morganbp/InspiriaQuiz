function HostGuiHandler(){
	
	//
	this.START_SCREEN = "START_SCREEN";
	
	// constant for Quiz Mode
	this.QUIZ_MODE = "QUIZ_MODE";
	
	// constant for Score Mode
	this.SCORE_MODE = "SCORE_MODE";
	
	// if the quiz is in "Quiz mode" or "Score mode"
	this.mode = this.QUIZ_MODE;
	
	// Letters used to grid view
	var letters = ['a','b'];
	
	var HostGuiHandler = function(){
	}
	
	
	
	this.setQuestion = function(questionText){
		if(typeof questionText == "string" || questionText instanceof String){
			$("#quiz").css("display", "block");
			$("#startScreen").css("display","none");
			$("#quizQuestion").text(questionText);
		}
	}
	
	this.setAlternatives = function(alternatives){
		this.clearAlternatives();
		// determain how many rows there is;
		// set grit type to 'a' (if one row) and to 'b' (if two rows)
		var gridType = letters[Math.ceil((alternatives.length / 2)-1)];
		var className = "ui-grid-" + gridType;

		//Set class name for categorizing grid type
		$("#alternatives").addClass(className);

		// set up each alternative block
		for(var i = 0; i < alternatives.length; i++){
			// set the class name of each block.
			// 'a' will be the first column and 'b' will be the second
			className = "ui-block-" + letters[i%2];

			// append the box
			$("#alternatives").append('<div id="' + i + '" class="'+ className +' centerHorizontal alternative" style="width:49%;"><span>'+alternatives[i].AlternativeText +'</span></div>');
		}
	}
	
	this.setScore = function(score){
		$("#scoreHeader").html(score);
	}
	
	/**
	*	toggles between score mode and quiz mode
	*/
	this.toggleQuizScore = function(){
		switch(this.mode){
			case this.QUIZ_MODE:
				$("#alternatives").css("display","block");
				$("#countdown").css("display", "block");
				$("#score").css("display","none");	
				this.mode = this.SCORE_MODE;
				break;
			case this.SCORE_MODE:
				$("#score").css("display","block");
				$("#countdown").css("display", "none");
				$("#alternatives").css("display","none");
				this.mode = this.QUIZ_MODE;
				break;
		}
	}
	
	this.showScore = function(score){
		//Toggle alternatives and score visibility
		this.toggleQuizScore();
		var title = "Resultat";
		setTimeout(function(){window.quizSession.startQuestion();}, 2000);
	
		$("#quizQuestion").html(title);
		$("#totalScore").html(score);
	}
	
	this.showCorrectAnswer = function(answer,  currentQuestion){
		for(var i = 0; i < currentQuestion.Alternatives.length; i++){
			if(currentQuestion.Alternatives[i].AlternativeCorrect === 1){
				$("#"+i).addClass("correct");
			}else{
				if(answer == i){
					$("#"+i).addClass("wrong");	
				}else{
					$("#"+i).addClass("neutral");	
				}
			}
		}
	}
	
	this.showResult = function(){
		//Toggle alternatives and score visibility
		this.toggleQuizScore();
		var title = "Sluttresultat";
		// GÅ TIL START SCREEN
		//setTimeout(function(), 2000);
	
		$("#quizQuestion").html(title);
		$("#totalScore").html(score);
	}
	
	this.clearAlternatives = function(){
		$("#alternatives").empty();
		$("#alternatives").removeClass("ui-grid-a ui-grid-b");	
	}
	
	this.setStartScreen = function(quizData){
		$("#quizTitle").html(quizData.quiz.QuizName);
		$("#quizCode").html(quizData.quizKey);	
	}
	
	this.populateParticipants = function(participants){
		var classes = ['a','b','c','d','e','f'];
		$('#participants').empty();
		console.log(participants);
		for(var i = 0; i < participants.participants.length; i++){
			var col = classes[Math.floor(i%classes.length)];
			console.log(col);
			var gridClass = 'ui-block-'+col;
			$('#participants').append('<div class="' + gridClass  + '">'+ participants.participants[i].username +'</div>');
			
		}
	}
	HostGuiHandler();
}