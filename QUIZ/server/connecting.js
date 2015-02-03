function connectToServer(data) {
     
    var xmlhttp = new XMLHttpRequest();
 	
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState === 4 && xmlhttp.status === 200){
			alert(xmlhttp.responseText);	
		}
	};
	
	var jsonData = "{username:"+data+"}";
    xmlhttp.open("POST", "http://localhost:1338", true);
	xmlhttp.setRequestHeader("Content-type", "application/json");
	
	
    xmlhttp.send(jsonData);
}

function sendUsername(){
	var username = document.forms['username_form']['username_input'].value;
	connectToServer(username);
}
