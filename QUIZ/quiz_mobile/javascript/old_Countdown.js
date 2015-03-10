function Countdown(countEnded, millisec){
	
	this.endEvent = countEnded;
	this.initialTime = millisec;
	this.timeLeft = millisec;
	this.intervalID;
		
	this.getTimeLeft = function(){
		return this.timeLeft;	
	}
	
	this.setTimeLeft= function(timeLeft){
		this.timeLeft = timeLeft;	
	}
	
	this.getInitialTime = function(){
		return this.initialTime;	
	}

	this.decreaseTime = function(time){
		var newTime = this.getTimeLeft() - time;
		if(newTime >= 0){
			this.setTimeLeft(newTime);
			this.updateProgressbar();
		}else{
			this.stop();
		}
	}
	
	this.computeTimeUsed = function(){
		return this.initialTime - this.timeLeft;	
	}
	
	this.start = function(time){
		var c = this;
		this.intervalID = setInterval(function(){ c.decreaseTime(time);}, time);
		this.updateProgressbar();
	}
	
	this.stop = function(){
		clearInterval(this.intervalID);
		this.endEvent();
	}
	
	this.updateProgressbar = function(){
		var percent = (this.getTimeLeft() / this.initialTime) * 100;
		$("#countdown").progressbar({
			value: percent
		});
		var color;
		if(percent > 40){
			color = '#0F0';
		}else{
			color = '#F00';
			$("#countdown > div").css({'height':'6px'});
		}
		$("#countdown").css({'background':'rgba(0,0,0,0)'});
		$("#countdown > div").css({'background':color});
	}
	
}