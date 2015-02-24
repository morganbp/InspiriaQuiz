var letters = ['a','b'];
function populateQuestion(){
	var question = window.quiz.getNextQuestion();
	var alternatives = question.Alternatives;
	var gridType = letters[Math.ceil((alternatives.length / 2)-1)];
	var className = "ui-grid-" + gridType;
	$("#alternatives").add("div").addClass(className);
	for(var i = 0; i < alternatives.length; i++){
		className = "ui-block-" + letters[i%2];
		console.log(className);
		$("#alternatives").append('<div id="' + i + '" class="'+ className +'">'+alternatives[i].AlternativeText +'</div>');
	}
}