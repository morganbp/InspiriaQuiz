<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" >
        <title>Inspiria quiz</title>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <!--jQuery-->
        <script src="/inspiriaQuiz/LIBS/javascript/jquery-mobile/jquery-1.11.1.min.js"></script>
        <script src="/inspiriaQuiz/LIBS/javascript/jquery-mobile/jquery.mobile-1.4.5.min.js"></script>
        <link rel="stylesheet" href="/inspiriaQuiz/LIBS/javascript/jquery-mobile/jquery.mobile-1.4.5.min.css" />
		<link rel="stylesheet" href="/inspiriaQuiz/LIBS/css/themes/jquery.mobile.icons.min.css" />
        <!--stylesheets-->
        <link rel="stylesheet" href="css/sidepanelStyle.css" />
        <link rel="stylesheet" href="css/contentListviewStyle.css" />
		<link rel="stylesheet" href="css/quiz.css" />
        <!--imported javascript-->
        <script src="javascript/startQuiz.js"></script>
        <script src="javascript/jqueryMobilFunctions.js"></script>
		<!-- Quiz Scripts -->
        <script src="javascript/quizScript.js"></script>
		<script src="javascript/quizmodeFunctions.js"></script>
		<script src="javascript/QuizData.js"></script>
		<script src="javascript/QuizSession.js"></script>
		<script src="javascript/QuizGuiHandler.js"></script>
		<script src="javascript/QuizDBHandler.js"></script>
	    <script src="javascript/SpinnerCounter.js"></script>
		
    </head>
    <body>
		
        <div data-role="page" data-theme="a" id="homescreen">
            <?php include 'menuAndHeader.php'; ?>

            <div data-role="content" id="content">
				<div data-role="popup" class="errorMessage">Hei</div>
                <form style="max-width:600px; margin:0 auto;" action="javascript:">
                    <input type="text" placeholder="Bruker id" style="text-align:center;" id="userCode"/>
                    <Button type="button" id="startQuizBtn" style="margin:0 auto; max-width:200px;">Start quiz</Button>
                </form>
                <form action="javascript:">
                    <h3 style="margin:50px auto 0 auto; max-width:500px; text-align:center;">Ta dagens quiz ved å klikke på knappen under.</h3>
                    <Button type="button" style="margin:0 auto; max-width:200px;" id="quizOfTheDay">Ta dagens quiz</Button>
                </form>
            </div>
        </div>
        <?php
			include 'publicQuiz.php';
        ?>
		<script>
			$("#startQuizBtn").click(function(){
				$.mobile.loading('show');
				var input = document.getElementById("userCode").value;
				var dbHandler = new QuizDBHandler();
				// Collect the user data 
				dbHandler.getUserData(function(data){
					$.mobile.loading('hide');
					if(!data.hasOwnProperty('Error')){
						// START QUIZ
						startQuiz(data.QuizID, data);
						var url = window.location.href.split("#");
						window.location.href = url[0] + "#publicQuiz";
					}else{
						showErrorMessage(data, "#errorMessage");
					}

				},null, input);
				
			});
			
			$("#quizOfTheDay").click(function(){
				$.mobile.loading('show');
				var dbHandler = new QuizDBHandler();
				dbHandler.getListOfQuizzes(function(data){
					$.mobile.loading('hide');
					if(!data.hasOwnProperty('Error')){
						var quizID = getQuizOfTheDayID(data);
						if(quizID !== null){
							// startQuiz
							startQuiz(quizID);
							var url = window.location.href.split("#");
							window.location.href = url[0] + "#publicQuiz";
						}else
							showErrorMessage(JSON.parse('{"Error":"Dagens Quiz er ikke tilgjengelig"}'), "#errorMessage");	
						
					}else
						showErrorMessage(data, "#errorMessage");	
				});
			});
			
			
			
			function getQuizOfTheDayID(quizzes){
				for(key in quizzes){
					if(quizzes[key].QuizOfTheDay){
						return quizzes[key].QuizID;
					}
				}
				return null;
			}
			
		</script>
    </body>
</html>