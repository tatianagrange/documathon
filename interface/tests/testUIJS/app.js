var http = require('http');
var fs = require('fs');

// Chargement du fichier index.html affiché au client
var server = http.createServer(function(req, res) {
    fs.readFile('./index.html', 'utf-8', function(error, content) {
        res.writeHead(200, {"Content-Type": "text/html"});
        res.end(content);
    });
});

// Chargement de socket.io
var io = require('socket.io').listen(server);

io.sockets.on('connection', function (socket) {
    socket.emit('message', 'Vous êtes bien connecté !');

    // Quand le serveur reçoit un signal de type "message" du client    
    socket.on('message', function (message) {
        console.log('Un client me parle ! Il me dit : ' + message);
    });	

    //Serial port
	var serialport = require("serialport");
	var SerialPort = serialport.SerialPort;
	var sp = new SerialPort("/dev/tty.usbserial-A600eo9b", {
		parser: serialport.parsers.readline("\n"),
		baudrate: 9600
	});

	sp.on("open", function(){
		sp.on('data', function(data){
			
			if(data == 0x0100){
				socket.emit('ledOn', data);
				console.log(data);
			}
			if(data == 0x0101){
				socket.emit('ledOff', data);
				console.log(data);
			}

		});
	});

});


server.listen(8080);

