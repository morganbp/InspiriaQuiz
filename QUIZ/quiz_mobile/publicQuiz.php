<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" >
        <title>Inspiria quiz</title>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <!--jQuery-->
		
        <script src="jquery-mobile/jquery-1.11.1.min.js"></script>
        <script src="jquery-mobile/jquery.mobile-1.4.5.min.js"></script>
		
		<link rel="stylesheet" href="jquery-mobile/jquery.mobile-1.4.5.min.css" />
		
		<link rel="stylesheet" href="css/themes/jquery.mobile.icons.min.css" />
        <!--stylesheets-->
        <link rel="stylesheet" href="css/sidepanelStyle.css" />
        <link rel="stylesheet" href="css/contentListviewStyle.css" />
		<link rel="stylesheet" href="css/quiz.css" />
        <!--imported javascript-->
        <script src="javascript/quizmodeFunctions.js"></script>
		<script src="javascript/QuizData.js"></script>
		<script src="javascript/QuizSession.js"></script>
		<script src="javascript/QuizGuiHandler.js"></script>
		<script src="javascript/QuizDBHandler.js"></script>
		<!--<script src="javascript/Countdown.js"></script>-->
		<script src="javascript/spin.min.js"></script>
		
    </head>
    <body onload="getCookie()" onbeforeunload="saveCookies()">
        <div data-role="page" data-theme="a" id="homescreen">
            <?php include 'menuAndHeader.php'; ?>
            <div data-role="content" id="content">
                <div id="questionScreen">
					<!-- Title -->
					<h2 id="quizQuestion" class="centerHorizontal"></h2>
					<div id="getQuiz">
						<div data-role="popup" id="invalidInput"><p>Please type in  a number</p></div>
						<div data-role="popup" id="quizNotFound"><p>Couldn't find Quiz</p></div>
						<input type="number" name="name" id="basic" onkeypress="chooseQuiz(event)" placeholder="QuizID" Style="text-align:center;"/>
						<button type="button" onclick="chooseQuiz(event)">Hent Quiz</button>
					</div>
					<div id="quiz">
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
						<div id="score" style="display:none;">
							<h3>Din poengsum:</h3>
							<div id="totalScore"></div>
						</div>
						<div id="alternatives"></div>
						<div id="countdown"></div>
					</div>
				</div>
            </div>
			<script src="javascript/quizScript.js"></script>	
        </div>
        <script src="javascript/SpinnerCounter.js"></script>
    </body>
</html>