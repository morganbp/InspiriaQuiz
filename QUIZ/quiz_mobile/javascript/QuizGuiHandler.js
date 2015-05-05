function QuizGuiHandler(){
	
	// constant for Quiz Mode
	this.QUIZ_MODE = "QUIZ_MODE";
	
	// constant for Score Mode
	this.SCORE_MODE = "SCORE_MODE";
	
	this.NEXT_QUESTION_MODE = "NEXT_QUESTION_MODE";
	
	// if the quiz is in "Quiz mode" or "Score mode"
	this.mode = this.QUIZ_MODE;
	
	// Letters used to grid view
	var letters = ['a','b'];
	
	this.QuizGuiHandler = function(){
	}
	
	this.setQuestion = function(questionObject){
		$("#quizQuestion").text(questionObject.QuestionText);
		if(questionObject.QuestionImageFilename != null){
			$("#image").css("display","block");
			$("#image").attr("src","/InspiriaQuiz/UploadedImages/" + questionObject.QuestionImageFilename);
			$("#image").attr("alt", questionObject.QuestionImageName);
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
            //+ className +' centerHorizontal 
			$("#alternatives").append('<div id="' + i + '" class="alternative" onclick="answerClicked(this);"><span>'+alternatives[i].AlternativeText +'</span></div>');
		}
	}
	
	/**
	*	toggles between different sceens
	*/
	this.toggleGuiMode = function(newMode){
		var mode = (newMode === "undefined") ? this.mode: newMode;
		switch(mode){
			case this.QUIZ_MODE:
				$("#alternatives").css("display","block");
				$("#countdown").css("display", "block");
				$("#score").css("display","none");	
				$("#nextQuestion").css("display", "none");
				this.mode = this.SCORE_MODE;
				break;
			case this.SCORE_MODE:
				$("#countdown").css("display", "none");
				$("#alternatives").css("display","none");
				$("#score").css("display","block");
				$("#image").css("display","none");
				$("#nextQuestion").css("display", "none");
				this.mode = this.QUIZ_MODE;
				break;
			case this.NEXT_QUESTION_MODE:
				$("#countdown").css("display", "none");
				$("#alternatives").css("display","none");
				$("#score").css("display","none");
				$("#image").css("display","none");
				$("#nextQuestion").css("display", "block");
				this.mode = this.NEXT_QUESTION_MODE;
				break;
		}
	}
	
	this.showQuestion = function(questionObject){
		this.setQuestion(questionObject);
		this.setAlternatives(questionObject.Alternatives);
		this.toggleGuiMode(this.QUIZ_MODE);
	}
	
	this.showReadyNextQuestion = function(question){
		this.toggleGuiMode(this.NEXT_QUESTION_MODE);
		$("#quizQuestion").html("Klar for neste spørsmål?");
		$("#exhibitImageData").css("display", "none");
		if(question.ExhibitImageFilename !== null){
			$("#exhibitImageData").css("display", "block");
			$("#exhibitImage").attr("src", "/inspiriaQuiz/UploadedImages/" + question.ExhibitImageFilename);
			$("#exhibitImage").attr("alt", question.ExhibitImageName);
			$("#exhibitName").html(question.ExhibitName);
		}
		
	}
	
	this.showScore = function(score){
		this.mode = this.SCORE_MODE;
		//Toggle alternatives and score visibility
		this.toggleGuiMode(this.SCORE_MODE);
		var title = "Resultat";
		$("#quizQuestion").html(title);
		$("#totalScore").html(score);
		setTimeout(function(){window.quizSession.nextQuestion();}, 2000);
		
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
		this.toggleGuiMode(this.SCORE_MODE);
		var title = "Sluttresultat";
		// GÅ TIL START SCREEN
		//setTimeout(function(), 2000);
	
		$("#quizQuestion").html(title);
		$("#totalScore").html(score);
        this.clearAlternatives();
	}
	
	this.clearAlternatives = function(){
		$("#alternatives").empty();
		//$("#alternatives").removeClass("ui-grid-a ui-grid-b");	
	}
	
	this.QuizGuiHandler();
}