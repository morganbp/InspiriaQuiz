<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Inspiria quiz</title>
		
		<!-- jQuery -->
		<script src="../quiz_mobile/jquery-mobile/jquery-1.11.1.min.js"></script>
		
		<link rel="stylesheet" href="../quiz_mobile/jquery-mobile/jquery.mobile-1.4.5.css"/>
		<!-- Standard -->
		<link rel="stylesheet" href="css/quizHostStyle.css"/>
		
		<!-- Scripts-->
		<script src="../quiz_mobile/javascript/quizmodeFunctions.js"></script>
		<script src="../quiz_mobile/javascript/QuizData.js"></script>
		<script src="../quiz_mobile/javascript/QuizSession.js"></script>
		<script src="../quiz_mobile/javascript/HostGuiHandler.js"></script>
		<script src="../quiz_mobile/javascript/QuizDBHandler.js"></script>
		<script src="../quiz_mobile/javascript/Countdown.js"></script>
		<script src="../quiz_mobile/javascript/quizScript.js"></script>
		<script src="./javascript/connect.js"></script>
		<script src="./javascript/host.js"></script>
	</head>
	<body>
		<div id="main">
			<div id="startScreen">
				<div id="upperPart">
					<h1 id="quizTitle">QuizTitle</h1>
					<h2 id="quizCodeTitle">Kode: <span id="quizCode">15203</span></h2>
					<button id="startQuiz" onclick="startQuiz(1)">Start Quiz</button>
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
		
	</body>
</html>