var http = require('http');

http.createServer(function(req, res){
	console.log('client connected');
	
	
	
}).listen(1338,'127.0.0.1');


function getDataFromClient(data){
	console.log('Data received from user:\n' + data.toString());
}

function userDisconnected(){
	console.log('user, disconnected');
}