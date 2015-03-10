var sumScore = 0;
var score = 0;
var maxScore = 1000;

function updateScore(){
    $("#score").text(sumScore);
}

function computeScore(timeLeft){
    score = Math.floor(timeLeft/(maxTime)*maxScore);
    sumScore += score;
}

function updateScoreDialog(){
    $("#scoreDialog #score").text(score);
    $("#scoreDialog #totalScore").text(sumScore);
}