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
			<div id="nextQuestion" style="display:none;">
				<div id="exhibitImageData" style="display:none;">
					<img id="exhibitImage" style="display:block;"/>
					<div  class="centerHorizontal" style="margin:10px 0;">Info om neste spørsmål finner du på:</div>
					<div id="exhibitName"  class="centerHorizontal bold" ></div>
				</div>
				<button onclick="window.quizSession.startQuestion();">Klar</button>
			</div>
			<div id="quiz" style="display:none;">
				<img id="image" style="display:none;"/>
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
</div>
