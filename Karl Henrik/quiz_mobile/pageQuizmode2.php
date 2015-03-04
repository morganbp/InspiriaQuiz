<div data-role="page" data-theme="a" id="quizMode2">
    <?php include 'menuAndHeader.php'; ?>
    <div data-role="content" id="content">
        <article style="text-align: center;">
            <h1>Quiz id</h1>
            <p style="font-size: 10pt;" >Quiz id består av tall mellom 0 til 9</p>
            <form action="JavaScript:getQuiz()" method="post">
                <input type="number" id="txtInputQuizId" style="text-align: center;" autocomplete="off" placeholder="XXXXX" required/>
                <input type="submit" id="btnQuizId" data-rel="popup" value="Start quiz" />
            </form>
        </article>
    </div>
</div>
