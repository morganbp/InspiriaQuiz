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
                <li class="liAlt" id="liAlt0" onclick="onAlternativeClick(0)"><a class="aAlt" id="alt0" >test</a></li>
                <li class="liAlt" id="liAlt1" onclick="onAlternativeClick(1)"><a class="aAlt" id="alt1" >test</a></li>
                <li class="liAlt" id="liAlt2" onclick="onAlternativeClick(2)"><a class="aAlt" id="alt2" >test</a></li>
                <li class="liAlt" id="liAlt3" onclick="onAlternativeClick(3)"><a class="aAlt" id="alt3" >test</a></li>
            </div>
        </div>
    </div>
</div>