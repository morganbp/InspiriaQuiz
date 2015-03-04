<div data-role="page" data-theme="a" id="quiz" >
    <div id="content" >
        <div id="upperHalf">
            <?php include 'menuAndHeader.php'; ?>
            <div id="infoHeader" data-role="header">
                <div id="scoreWrapper">
                    <label style="display:inline">Poengsum: </label>
                    <div id="score" style="display:inline;">0</div>
                </div>
                <div id="timerWrapper">
                    <label style="display:inline;">Tid igjen: </label>
                    <div id="timer" style="display:inline;"></div>
                </div>
            </div>
            <h2 id="question" style="text-align: center;" ></h2>
        </div>
        <div id="lowerHalf">
            <div id="listAlt" data-role="listview" data-inset="true" data-icon="false" >
                <li><a></a></li>
                <li><a></a></li>
                <li><a></a></li>
                <li><a></a></li>
            </div>
        </div>
    </div>
</div>