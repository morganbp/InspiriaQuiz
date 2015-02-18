<div data-role="page" data-theme="a" id="quizmode2">
    <?php include 'menuAndHeader.php'; ?>
    <div data-role="content" id="content">
        <article style="text-align: center;">
            <h1>Quiz id</h1>
            <input type="text" onSubmit="initializeQuiz()" id="txtInputQuizId" style="text-align: center;" autocomplete="off" pattern="[0-9]*" required />
            <input type="submit" onClick="initializeQuiz()" value="Start quiz" />
        </article>
    </div>
</div>