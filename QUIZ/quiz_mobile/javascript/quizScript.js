window.quizSession;

// The spinner which runs when page is loading
var spinner;



startUpScreen();
/**
* Event to choose which quiz we want to play
*/
function chooseQuiz(event){
	if(event.keyCode === 13 || event instanceof MouseEvent){
		var id = $("#basic").val();
		if(/[0-9]/.test(id)){
			quizSession = new QuizSession(Number(id));
			setUpSpinner();
		}else{
			popup("#invalidInput");
		}
	}
}


function popup(id){
	$(id).popup("open");	
	setTimeout(function(){
		$(id).popup("close");
	},1500); 
		$("#basic").val('');
}



/**
* When the player press one of the answeres, the button gets chosen
*/
function chooseAlternative(alternative){
	if(!quizSession.hasAnswered()){
		quizSession.userAnswers(alternative.getAttribute("id"));
		alternative.className += " answere";
		setTimeout(function(){quizSession.showCorrectAnswers();}, 400);
	}
}

	
function startUpScreen(){
	$("#score").css("display", "none");
	$("#getQuiz").css("display", "block");
	$("#quizQuestion").html("Velg Quiz");
}

function setUpSpinner(){
	var opts = {
		  lines: 15, // The number of lines to draw
		  length: 7, // The length of each line
		  width: 3, // The line thickness
		  radius: 10, // The radius of the inner circle
		  corners: 1, // Corner roundness (0..1)
		  rotate: 0, // The rotation offset
		  direction: 1, // 1: clockwise, -1: counterclockwise
		  color: '#000', // #rgb or #rrggbb or array of colors
		  speed: 2, // Rounds per second
		  trail: 60, // Afterglow percentage
		  shadow: false, // Whether to render a shadow
		  hwaccel: false, // Whether to use hardware acceleration
		  className: 'spinner', // The CSS class to assign to the spinner
		  zIndex: 2e9, // The z-index (defaults to 2000000000)
		  top: '50%', // Top position relative to parent
		  left: '50%' // Left position relative to parent
	};
	var target = document.getElementById('questionScreen');
	spinner = new Spinner(opts).spin(target);

}

function removeSpinner(){
	spinner.stop();
}