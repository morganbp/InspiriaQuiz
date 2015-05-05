<div data-role="page" data-theme="a" id="publicQuiz">
	<?php include 'menuAndHeader.php'; ?>
	<div data-role="content" id="content">
		<div id="questionScreen">
			<!-- Title -->
			<h2 id="quizQuestion" class="centerHorizontal"></h2>
			<!-- NEXT QUESTION -->
			<div id="nextQuestion" style="display:none;">
				<div id="exhibitImageData" style="display:none;">
					<img id="exhibitImage" style="display:block;"/>
					<div  class="centerHorizontal" style="margin:10px 0;">Info om neste spørsmål finner du på:</div>
					<div id="exhibitName"  class="centerHorizontal bold" ></div>
				</div>
				<button onclick="window.quizSession.startQuestion();">Klar</button>
			</div>
			<!-- QUIZ -->
			<div id="quiz">
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
