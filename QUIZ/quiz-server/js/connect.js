window.conn = new WebSocket('ws://158.39.171.57:8080');
conn.onopen = function(e) {
	console.log("Connection established!");	
};