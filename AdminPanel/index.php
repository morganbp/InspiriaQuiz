<html>
<head>
    <title>Inspiria Quiz Admin</title>
    <meta charset='utf-8'/>
    <link rel='stylesheet' type='text/css' href='styles/style.css'/>
    <link rel='stylesheet' type='text/css' href='styles/flaticon/flaticon.css'/>
	<script src="/inspiriaQuiz/LIBS/javascript/jquery-mobile/jquery-1.11.1.min.js"></script>
	<script src="/inspiriaQuiz/LIBS/javascript/jquery-mobile/jquery.mobile-1.4.5.min.js"></script>
	<script src="/inspiriaQuiz/LIBS/chartjs/Chart.js"></script>
	<script src="/inspiriaQuiz/QUIZ/quiz_mobile/javascript/QuizDBHandler.js"></script>
	<script>
		var quizScores;
		var quizTakenTotal;
		var quizTakenToday;
		var quizTakenThisMonth;
		
		function getScoreData(){
			var dbHandler = new QuizDBHandler();
			dbHandler.getScore(function(data){
				quizScores = data.QuizScore;
				quizTakenTotal = data.QuizScore.length;
				var quizToday = getQuizTakenToday(quizScores);
				var quizThisMonth = getQuizTakenThisMonth(quizScores);
				quizTakenToday = quizToday.length;
				quizTakenThisMonth = quizThisMonth.length;
				populateQuizTaken();
			});
			
			dbHandler.getAnswers(function(data){
				populatePieChart(data);
			});
		}
		
		function populatePieChart(data){
			var correctAnswers = 0;
			var wrongAnswers = 0;
			for(var i = 0; i < data.QuizAnswer.length; i++)
				if(data.QuizAnswer[i].AlternativeCorrect)
					correctAnswers++;
				else
					wrongAnswers++;

			var ctx = document.getElementById("pieCorrect").getContext("2d");
			var data = [
					{
						value: correctAnswers,
						color:"#F7464A",
						highlight: "#FF5A5E",
						label: "Riktig svar"
					},
					{
						value: wrongAnswers,
						color: "#46BFBD",
						highlight: "#5AD3D1",
						label: "Feil Svar"
					}
				];
			
			var options = {animationSteps : 30, animationEasing : "easeOutSine",}; 
			var pieChart = new Chart(ctx).Pie(data,options);
		}
		
		function populateQuizTaken() {
			$("#quizTot").html(quizTakenTotal);
			$("#quizTod").html(quizTakenToday);
			$("#quizMon").html(quizTakenThisMonth);
		}
		
		function getQuizTakenToday(scores) {
			var arr = [];
			for(var i = 0; i < scores.length; i++)
				if(compareDateDay(new Date(), new Date(scores[i].Date)))
					arr.push(scores[i]);
			
			return arr;
		}
		
		function getQuizTakenThisMonth(scores){
			var arr = [];
			for(var i = 0; i < scores.length; i++)
				if(compareDateMonth(new Date(), new Date(scores[i].Date)))
					arr.push(scores[i]);
			
			return arr;
		}
		
		function compareDateDay(date1, date2){			
			return date1.getDate() === date2.getDate() && compareDateMonth(date1, date2);
		}
		
		function compareDateMonth(date1, date2){
			return date1.getMonth() === date2.getMonth() && compareDateYear(date1,date2);
		}
		
		function compareDateYear(date1, date2){
			return date1.getYear() === date2.getYear();
		}
		
	</script>
</head>
<body>
    <?php include 'header.php'; ?>
	
    <div id='container'>
        <div class='sidebar'>
            <nav>
                <ul id='nav'>
                    <?php $activepage = 'index.php'; ?>
                    <?php include 'nav.php'; ?>
                </ul>
            </nav>
        </div>
        <div class='content'>
            <h1>Dashboard</h1>
            <p>Velkommen til admin-panelet for Inspirias Quizer!</p>
            <!-- Antal personer panel -->
            <div class='panel'>
                <div class='panel-header'>Antall personer tatt quizen</div>
                <div class='panel-body' id="numTakenQuiz">
                    <table class="center-content-table">
						<tr>
							<td class="center-text">
								<div class="big-text" id="quizTod">0</div>
								<div>Quizer tatt idag</div>
							</td>
							<td class="center-text">
								<div class="big-text" id="quizMon">0</div>
								<div>Quizer tatt denne måneden</div>
							</td>
							<td class="center-text">
								<div class="big-text" id="quizTot">0</div>
								<div>Quizer tatt totalt</div>
							</td>
						</tr>
					</table>
                </div>
            </div>
			<!-- Antal personer panel -->
            <div class='panel'>
                <div class='panel-header'>Statistikk</div>
                <div class='panel-body' >
					<div class="center-content-table">
                    	<canvas id="pieCorrect" height="200" width="200" ></canvas>
					</div>
                </div>
            </div>
        </div>
    </div>
	<script>
		
		getScoreData();
	</script>
</body>
</html>