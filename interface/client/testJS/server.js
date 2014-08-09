var serialport = require("serialport");
var SerialPort = serialport.SerialPort;
var sp = new SerialPort("/dev/tty.usbserial-A600eo9b", {
parser: serialport.parsers.readline("\n"),
baudrate: 9600
});

sp.on("open", function(){
	console.log('open');
	sp.on('data', function(data){
		console.log('data received: ' + data );
	});
});