<div data-role="page" data-theme="a" id="publicQuiz">
	<?php include 'menuAndHeader.php'; ?>
	<div data-role="content" id="content">
		
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
			<img id="image"/>
			<div id="spinner"></div>
			<div id="score" style="display:none;">
				<h3>Din poengsum:</h3>
				<div id="totalScore"></div>
			</div>
			<div id="alternatives"></div>
			<div id="countdown"></div>
		</div>
		<!-- REGISTER -->
		<div id="registerUser">
			<div data-role="popup" id="errorMessageQuiz"></div>
			<h3>Registrer resultat</h3>
			<form name="register">
				<input type="text" placeholder="Fornavn" name="fName"/>
				<input type="text" placeholder="Etternavn" name="sName"/>
				<input type="number" placeholder="Alder" name="age"/>
				<input type="email"  placeholder="Email" name="email"/>
				<input type="tel"  placeholder="Telefonnr" name="phone"/>
				<select id="gender">
					<option value="Male">Mann</option>
					<option value="Female">Dame</option>
				</select>
				<button type="button" id="sendResult">Send resultat</button>
			</form>
			
			<script>
			function getInputData(){
				var o = {};
				// FIRSTNAME
				o.UserFirstName = document.forms['register']['fName'].value;
				// LASTNAME
				o.UserLastName = document.forms['register']['sName'].value;
				// AGE
				o.UserAge = parseInt(document.forms['register']['age'].value);
				
				// EMAIL
				o.UserEmail = document.forms['register']['email'].value;
				
				// PHONE
				o.UserPhone = document.forms['register']['phone'].value;
				
				// GENDER
				o.UserGender = $("#gender option:selected").val();
				// check if some fields are empty
				for(key in o){
					if(o[key].length < 1 || String(o[key]).trim() === "" ){
						showErrorMessage({Error : "Fyll inn alle felt"}, "#errorMessageQuiz");
						return null;
					}
				}
				// Check if age is a number
				if(isNaN(o.UserAge)){
					showErrorMessage({Error : "Alderene din må være et tall"}, "#errorMessageQuiz");
					return null;
				}
				// check if email is valid
				if(!/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/.test(o.UserEmail)){
					showErrorMessage({Error : "Emailadressen er ikke gyldig"}, "#errorMessageQuiz");
					return null;	
				}
				// check if phonenumber is number
				if(isNaN(o.UserPhone)){
					showErrorMessage({Error : "Fyll inn telefonnummer med bare tall"},"#errorMessageQuiz");
					return null;	
				}
				return o;
			
			}
				
			$("#sendResult").click(function(){
				var inputData = getInputData();
				if(inputData !== null){
					console.log(inputData);
					var dbHandler = new QuizDBHandler();
					dbHandler.postUser(function(data){
						if(!data.hasOwnProperty('Error')){
							console.log(data);
							this.quizSession.user = data;
							this.quizSession.endQuizSession();
						}else{
							console.log(data.Error);	
						}
					}, inputData);
				}
			});
			</script>
		</div>
	</div>
</div>
