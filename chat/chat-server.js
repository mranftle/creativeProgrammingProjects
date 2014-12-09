// Require the packages we will use:
var http = require("http"),
	socketio = require("socket.io"),
	fs = require("fs");

// Listen for HTTP connections.  This is essentially a miniature static file server that only serves our one file, client.html:
var app = http.createServer(function(req, resp){
	// This callback runs when a new connection is made to our HTTP server.

	fs.readFile("client.html", function(err, data){
		// This callback runs when the client.html file has been read from the filesystem.

		if(err) return resp.writeHead(500);
		resp.writeHead(200);
		resp.end(data);
	});
});
app.listen(3456);

// Do the Socket.IO magic:
var io = socketio.listen(app);
var i=0;
var nsp = io.of('/rooms');
rms=Array();
pwds=Array();
nsp.on("connection", function(socket){
	// This callback runs when a new Socket.IO connection is established.
 	//socket.join('2');
 	//$('.usernameInput').focus();

 	socket.on('username', function(data) {

 	console.log(data["user"]);
 	});
	socket.on('message_to_server', function(data) {
		// This callback runs when the server receives a new message from the client.
 		var room="'"+data["room"]+"'";
 		socket.join(room);
 		var logText="message: "+data["message"]+" to room: "+room+" from "+data["user"];
 		var text=data["user"]+": "+data["message"];
		console.log(logText); // log it to the Node.JS output
		nsp.to(room).emit("message_to_client",{message:text});
		//socket.leave(room);
		//nsp.emit("message_to_client",{message:data["message"] }) // broadcast the message to all rooms
	});
	socket.on('get_rooms',function(data){
	console.log("pass's: "+pwds);
	nsp.emit("show_rooms",{rooms:rms });
	});
	socket.on('new_room',function(data){
	rms.push(data["room"]);
	pwds.push(data["pass"]);
	});
});