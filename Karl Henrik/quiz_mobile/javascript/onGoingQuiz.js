var isAltClicked = false;

function onAlternativeClick(alt){
    if(isAltClicked==false){
        isAltClicked=true;
        questionAnswered(alt);
        editAltColors(alt);
    }
}

function editAltColors(alt){
    if(alt!=correctAlternative){
        $("#liAlt"+alt).css("background-color","#ff0000");
        $("#liAlt"+alt).children().css("color","#000000");
    }
    $("#liAlt"+correctAlternative).css("background-color","#00ff00")
    $("#liAlt"+correctAlternative).children().css("color","#000000");
}

function questionAnswered(alt){
    stopTimer();
    if(alt==correctAlternative){
        updateScore(timer);
        setTimeout(function(){
            $.mobile.changePage("#scoreDialog",{role: "dialog"});
        },1000);
    }
    else{
        
    }
    editAltColors(alt)
}