function SpinnerCounter(cont){
    var totalSeconds;
    var seconds;
    var timer;
    var container = cont;
    var counterMax = 1.4999;
    var counterMin = -0.4999;
    var counter = 0;

    this.drawCounter = function(piMultiplier){
        var c = container.children[0];
        var ctx = c.getContext("2d");
        ctx.beginPath();
        ctx.clearRect(0,0,c.width,c.height);
        if(Math.ceil(seconds)<=totalSeconds/2 && Math.ceil(seconds)>=totalSeconds/3){
            ctx.strokeStyle = "#ffaa26";
        }
        else if(Math.ceil(seconds) < totalSeconds/3){
            ctx.strokeStyle = "#ff0000";
        }
        else{
            ctx.strokeStyle = "#00ff00";
        }
        ctx.lineWidth = 10;
        ctx.arc(c.width/2,c.height/2,30,1.5*Math.PI,piMultiplier*Math.PI);
        ctx.stroke();
    }

    this.timerOnTick = function(){
        if(seconds == totalSeconds){
            this.drawCounter(counterMax);
        }
        else if(seconds <= 0){
            this.drawCounter(counterMin);
            clearInterval(timer);
        }
        else{
            this.drawCounter(counterMax-counter);
            counter += (100/(totalSeconds*1000));
        }
        seconds -= 0.05;
        seconds = seconds.toFixed(2);
        container.children[1].innerHTML = Math.ceil(seconds);
    }

    this.initialTimer = function(){
        totalSeconds = 15;
        seconds = totalSeconds;
        container.innerHTML = '<canvas style="height:180px;" id="canvas_spinner" ></canvas><div id="div_timerCounter" >15</div>';
        this.setupTimerCounterTextBox();
        var c = this;
        timer = setInterval( function(){c.timerOnTick()},50);
    }

    this.setupTimerCounterTextBox = function(){
        var timerDiv = container.children[1].style;
        timerDiv.fontFamily = "Ariel";

        //Adding the new font for the countdown numbers
        var fontStyle = document.createElement("style");
        fontStyle.appendChild(document.createTextNode('@font-face {font-family: CounterNumberFont; src: url("http://localhost/inspiriaquiz/QUIZ/quiz_mobile/css/fonts/Superstar M54.ttf");}'));
        document.head.appendChild(fontStyle);
        timerDiv.fontFamily = "CounterNumberFont";
        timerDiv.fontSize = "20pt";
    }
}