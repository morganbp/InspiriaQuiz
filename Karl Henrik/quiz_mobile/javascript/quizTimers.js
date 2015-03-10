var maxTime = 15;
var timer;
var timerClock;

function questionTimerGoing(){
    if(timer>0){
        timer-=0.01;
        setTimer(timer);
    }
    else{
        stopTimer();
        questionAnswered();
    }
}

function startTimer(functionForTimer){
    timer = maxTime;
    timerClock = setInterval(functionForTimer, 10);
}

function stopTimer(){
    setTimer(timer);
    window.clearInterval(timerClock);
}

function setTimer(time){
    $("#timer").text(Math.ceil(time));
}