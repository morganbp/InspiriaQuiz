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
		<script>
			
		</script>
    </head>
    <body>
        <div data-role="page" data-theme="a" id="homescreen">
            <?php include 'menuAndHeader.php'; ?>

            <div data-role="content" id="content">
                <form style="max-width:600px; margin:0 auto;" action="javascript::">
                    <input type="text" placeholder="Bruker id" style="text-align:center;" />
                    <Button type="submit" style="margin:0 auto; max-width:200px;" >Start quiz</Button>
                </form>
                <form action="javascript::">
                    <h3 style="margin:50px auto 0 auto; max-width:500px; text-align:center;">Ta dagens quiz ved å klikke på knappen under.</h3>
                    <Button type="submit" style="margin:0 auto; max-width:200px;">Ta dagens quiz</Button>
                </form>
            </div>
        </div>
        <?php
			include 'publicQuiz.php';
        ?>
    </body>
</html>