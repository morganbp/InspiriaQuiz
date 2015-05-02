<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" >
        <title>Inspiria quiz</title>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <!--jQuery-->
        <script src="../../LIBS/javascript/jquery-mobile/jquery-1.11.1.min.js"></script>
        <script src="../../LIBS/javascript/jquery-mobile/jquery.mobile-1.4.5.min.js"></script>
        <link rel="stylesheet" href="../../LIBS/javascript/jquery-mobile/jquery.mobile-1.4.5.min.css" />
		<link rel="stylesheet" href="../../LIBS/css/themes/jquery.mobile.icons.min.css" />
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
                <ul data-role="listview" id="quizMode">
                    <li data-icon="false">
                        <a href="quizmode1">
                            <h3>Quiz for idag</h3>
                            <p>Er du på besøk hos Inspiria og vil prøve dagens quiz klikk her!</p>
                        </a>
                    </li>
                    <li data-icon="false">
                        <a href="#publicQuiz">
                            <h3>Quiz for Skole/bedrift</h3>
                            <p>Er du med en skole eller bedrift og skal gå rundt i Inspiria science center og ta vår quiz laget spesielt til dere klikk her!</p>
                        </a>
                    </li>
                    <li data-icon="false">
                        <a href="quizmode3">
                            <h3>Quiz for lukket arrangement</h3>
                            <p>Hvis du skal være med på et lukket arrangement i auditoriet eller et konferanserom klikk her!</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <?php
            include 'pageQuizmode1.php';
            include 'pageQuizmode3.php';
            include 'pageQuiz.php';
			include 'publicQuiz.php';
            include 'dialogs/quizNotFoundErrorDialog.php';
        ?>
    </body>
</html>