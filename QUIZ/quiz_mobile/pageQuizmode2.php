<div data-role="page" data-theme="a" id="quizmode2">
    <?php include 'menuAndHeader.php'; ?>
    <div data-role="content" id="content">
        <article style="text-align: center;">
            <h1>Quiz id</h1>
            <input type="text" id="txtInputQuizId" style="text-align: center;" autocomplete="off" required />
            <input type="submit" id="btnQuizId" onClick="initializeQuiz()" value="Start quiz" />
        </article>
    </div>
    <script type="text/javascript">
        $('#txtInputQuizId').on('keydown', function(e) {
            if (e.keyCode === 13) {
                $('#btnQuizId').click();
            }
        });
    </script>
</div>
