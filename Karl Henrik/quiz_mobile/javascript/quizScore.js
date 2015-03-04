var sumScore = 0;
var score = 0;
var maxScore = 1000;

function updateScore(timeLeft){
    score = Math.floor(timeLeft/(maxTime)*maxScore);
    sumScore += score;
    $("#score").text(sumScore);
    $("#scoreDialog #score").text(score);
    $("#scoreDialog #totalScore").text(sumScore);
}