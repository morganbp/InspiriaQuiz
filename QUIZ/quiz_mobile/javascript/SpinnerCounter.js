function SpinnerCounter(cont, endEvt){
    this.totalSeconds;
    this.seconds;
    this.timer;
    this.container;
    this.endEvent;
    this.counterMax;
    this.counterMin;
    this.counter;

    this.drawCounter = function(piMultiplier){
        var c = this.container.children[0];
        var ctx = c.getContext("2d");
        ctx.beginPath();
        ctx.clearRect(0,0,c.width,c.height);
        if(Math.ceil(this.seconds) < this.totalSeconds/3){
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
        if(this.seconds <= 0){
            this.drawCounter(this.counterMin);
            this.stop();
        }
        else{
            this.drawCounter(this.counterMax-this.counter);
            this.counter += (100/(this.totalSeconds*1000));
        }
        this.seconds -= 0.05;
        this.seconds = this.seconds.toFixed(2);
        this.container.children[1].innerHTML = Math.ceil(this.seconds);
    }

    this.initialTimer = function(){
        this.totalSeconds = 5;
        this.seconds = this.totalSeconds;
        this.container.innerHTML = '<canvas style="height:180px;" id="canvas_spinner" ></canvas><div id="div_timerCounter" >15</div>';
        this.setupTimerCounterTextBox();
        var c = this;
        this.drawCounter(this.counterMax);
        this.timer = setInterval(function(){c.timerOnTick()},50);
    }

    this.setupTimerCounterTextBox = function(){
        var timerDiv = this.container.children[1].style;
        timerDiv.fontFamily = "Ariel";

        //Adding the new font for the countdown numbers
        var fontStyle = document.createElement("style");
        fontStyle.appendChild(document.createTextNode('@font-face {font-family: CounterNumberFont; src: url("http://localhost/inspiriaquiz/QUIZ/quiz_mobile/css/fonts/Superstar M54.ttf");}'));
        document.head.appendChild(fontStyle);
        timerDiv.fontFamily = "CounterNumberFont";
        timerDiv.fontSize = "20pt";
    }
    
    this.stop = function(){
        clearInterval(this.timer);
        this.endEvent();
    }
    
    this.setup = function(){
        this.initi
    }
    
    this.SpinnerCounter = function(cont, endEvt){
        this.container = cont;
        this.endEvent = endEvt;
        this.counterMax = 1.4999;
        this.counterMin = -0.4999;
        this.counter = 0;
    }
    this.SpinnerCounter(cont,endEvt);
}