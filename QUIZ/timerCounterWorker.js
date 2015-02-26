var i = 30;

function timeCount(){
    i--;
    postMessage(i);
    setTimeout("timedCount()",1000);
}

timeCount();