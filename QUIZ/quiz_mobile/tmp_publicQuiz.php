<html>
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
        <!--stylesheets-->
        <link rel="stylesheet" href="css/sidepanelStyle.css" />
        <link rel="stylesheet" href="css/contentListviewStyle.css" />
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
					
					<div id="alternatives">
						
					</div>
				</div>
            </div>
			<script src="javascript/publicQuiz.js"></script>
			<script>
				$(function(){
					$('.centerHorizontal').css({
						'text-align':'center'
					});
				});				
			</script>
			
        </div>
    </body>
</html>

</html>