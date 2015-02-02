function connectToServer(data) {
     
    var xmlhttp = new XMLHttpRequest();
 	
    xmlhttp.open("POST", "127.0.0.0:1338", true);
    xmlhttp.send();
}

function sendUsername(){
	var username = document.forms['username_form']['username_input'].value;
	connectToServer(username);
}