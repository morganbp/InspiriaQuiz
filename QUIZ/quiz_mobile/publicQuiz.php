<div data-role="page" data-theme="a" id="publicQuiz">
	<?php include 'menuAndHeader.php'; ?>
	<div data-role="content" id="content">
		<div id="questionScreen">
			<!-- Title -->
			<h2 id="quizQuestion" class="centerHorizontal"></h2>
			<div id="getQuiz">
				<div data-role="popup" id="invalidInput"><p>Please type in  a number</p></div>
				<div data-role="popup" id="quizNotFound"><p>Couldn't find Quiz</p></div>
				<input type="number" name="name" id="basic" onkeypress="chooseQuiz(event)" placeholder="QuizID" Style="text-align:center;" autofocus/>
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
	<script src="javascript/SpinnerCounter.js"></script>
</div>
