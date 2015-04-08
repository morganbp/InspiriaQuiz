<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Inspiria quiz</title>
		
		<!-- jQuery -->
		<script src="../quiz_mobile/jquery-mobile/jquery-1.11.1.min.js"></script>
		<script src="../quiz_mobile/jquery-mobile/jquery.mobile-1.4.5.min.css"></script>
		
		<link rel="stylesheet" href="../quiz_mobile/jquery-mobile/jquery.mobile-1.4.5.css"/>
		<!-- Standard -->
		<link rel="stylesheet" href="css/quizHostStyle.css"/>
		
		<!-- Scripts-->
		<script src="javascript/quizmodeFunctions.js"></script>
		<script src="javascript/QuizData.js"></script>
		<script src="javascript/QuizSession.js"></script>
		<script src="javascript/QuizGuiHandler.js"></script>
		<script src="javascript/QuizDBHandler.js"></script>
		<script src="javascript/Countdown.js"></script>
		<script src="javascript/spin.min.js"></script>
	</head>
	<body>
		<div id="main">
			<div id="startScreen">
				<div id="upperPart">
					<h1 id="quizTitle">QuizTitle</h1>
					<h2 id="quizCodeTitle">Kode: <span id="quizCode">15203</span></h2>
					<button id="startQuiz">Start Quiz</button>
				</div>
				<div id="lowerPart">
					<div id="participants" class="ui-grid-e">
						<div class="ui-block-a">Morgan</div>
						<div class="ui-block-b">Karl</div>
						<div class="ui-block-a">Philip</div>
						<div class="ui-block-a">Yngve</div>
						<div class="ui-block-a">Jan</div>
						<div class="ui-block-a">Bjarne</div>
					</div>
				</div>
			</div>
		</div>
		<div id="questionScreen">
					<!-- Title -->
					<h2 id="quizQuestion" class="centerHorizontal"></h2>
					<div id="getQuiz">
						<div data-role="popup" id="invalidInput"><p>Please type in  a number</p></div>
						<div data-role="popup" id="quizNotFound"><p>Couldn't find Quiz</p></div>
						<input type="number" name="name" id="basic" onkeypress="chooseQuiz(event)" placeholder="QuizID" Style="text-align:center;"/>
						<button type="button" onclick="chooseQuiz(event)">Hent Quiz</button>
					</div>
					<div id="quiz" style="display:none;">
						<div id="infoHeader" data-role="header">
							<div id="scoreWrapper">
								<label style="display:inline;">Poengsum: </label>
								<span id="scoreHeader" style="display:inline;">0</span>
							</div>
							<div id="timerWrapper">
								<label style="display:inline;">Tid igjen: </label>
								<span id="timer" style="display:inline;"></span>
							</div>
						</div>
						
						<div id="spinner"></div>
						<div id="countdown"></div>
						<div id="score" style="display:none;">
							<h3>Poengsum</h3>
							<div id="totalScore"></div>
						</div>
						<div id="alternatives"></div>
					</div>
				</div>
	</body>
</html>