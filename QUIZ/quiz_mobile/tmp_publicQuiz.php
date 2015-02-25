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
		<script src="jquery-mobile/jquery.countdown360.min.js"></script>
        <!--stylesheets-->
        <link rel="stylesheet" href="css/sidepanelStyle.css" />
        <link rel="stylesheet" href="css/contentListviewStyle.css" />
		<style>
		.centerHorizontal{
			text-align:center;
		}
			
		#alternatives{			
			margin-bottom: 5px;
			margin-left: -5px;
			position: absolute;
			bottom: 0px;
			heigth: 300px;
			width: 95%;
		}
			
		.alternative{
			margin: 1px;
			border-radius: 3px;
			display: flex;
			justify-content: center; /* align horizontal */
			align-items: center; /* align vertical */
			height: 150px;
			background: #CCC;
		}	
		.answere{
			background: #4F4;
		}
			
		#countdown{
			margin: auto 0px;	
			justify-content: center; /* align horizontal */
			align-items: center; /* align vertical */
		}
			
		</style>
        <!--imported javascript-->
        <script src="javascript/quizmodeFunctions.js"></script>
		<script src="javascript/quiz.js"></script>
    </head>
    <body>
        <div data-role="page" data-theme="a" id="homescreen">
            <?php include 'menuAndHeader.php'; ?>
            <div data-role="content" id="content">
                <div id="questionScreen">
					<!-- Title -->
					<h2 id="quizQuestion" class="centerHorizontal">Question?</h2>				
					<div id="countdown"></div>
					<div id="alternatives"></div>
				</div>
            </div>
			<script src="javascript/publicQuiz.js"></script>	
        </div>
    </body>
</html>