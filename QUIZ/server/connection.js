var http = require('http');
var url = require('url');

http.createServer(function(req, res){
	console.log('client connected');
	
	console.log(req.url);
	
	res.writeHead(200, {'Content-Type':'text/plain', 'connection':'keep-alive'});
	res.end('welcome');
	
}).listen(1338,'127.0.0.1');


