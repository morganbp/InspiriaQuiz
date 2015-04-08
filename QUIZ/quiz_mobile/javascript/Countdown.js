function Countdown(countEndedEvent, millisec){
	
	this.updateFrequence;
	
	this.endEvent;
	
	this.initialTime;
	
	this.timeLeft;
	
	this.timeStart;
	
	this.timeUsed;
	
	this.intervalID;

	this.decreaseTime = function(){
		var newTime = this.timeLeft - this.updateFrequence;
		if(newTime >= 0){
			this.timeLeft = newTime;
			this.updateProgressbar();
		}else{
			this.stop();
		}
	}
	
	this.computeTimeUsed = function(){
		return this.initialTime - this.timeLeft;	
	}
	
	this.start = function(){
		this.timeStart = Date.now();
		var c = this;
		this.intervalID = setInterval(function(){c.decreaseTime()}, this.updateFrequence);
		this.updateProgressbar();
	}
	
	this.pause = function(){
		clearInterval(this.intervalID);
	}
	
	this.resume = function(){
		var c = this;
		this.intervalID = setInterval(function(){c.decreaseTime()}, this.updateFrequence); 	
	}

	this.reset = function(){
		this.timeLeft = this.initialTime;
	}
	
	this.stop = function(){
		this.timeUsed = Date.now() - this.timeStart;
		this.pause();
		this.reset();
		this.endEvent();
	}
	
	this.updateProgressbar = function(){
		var percent = (this.timeLeft / this.initialTime) * 100;
		$("#countdown").progressbar({
			value: percent
		});
		var color;
		if(percent > 40){
			color = '#59b548';
		}else{
			color = '#e84b7d';
			$("#countdown > div").css({'height':'6px'});
		}
		$("#countdown").css({'background':'rgba(0,0,0,0)'});
		$("#countdown").children.css({'background':color});
		$("#timer").html(this.timeLeft/1000);
	}
	
	this.Countdown = function(countEndedEvent, millisec){
		this.updateFrequence = 1000;
		this.endEvent = countEndedEvent;
		this.initialTime = millisec;
		this.timeLeft = millisec;
	}
	
	this.Countdown(countEndedEvent, millisec);
	
}