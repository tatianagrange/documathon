var express = require('express');
var path = require('path');
var favicon = require('static-favicon');
var logger = require('morgan');
var cookieParser = require('cookie-parser');
var bodyParser = require('body-parser');
var jade = require('jade');
var routes = require('./routes/index');

var app = express();

// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'jade');

app.use(favicon());
app.use(logger('dev'));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded());
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

app.use('/', routes);

/// catch 404 and forward to error handler
app.use(function(req, res, next) {
    var err = new Error('Not Found');
    err.status = 404;
    next(err);
});

/// error handlers

// development error handler
// will print stacktrace
if (app.get('env') === 'development') {
    app.use(function(err, req, res, next) {
        res.status(err.status || 500);
        res.render('error', {
            message: err.message,
            error: err
        });
    });
}

// production error handler
// no stacktraces leaked to user
app.use(function(err, req, res, next) {
    res.status(err.status || 500);
    res.render('error', {
        message: err.message,
        error: {}
    });
});


module.exports = app;

var server = app.listen(3000, function() {
    console.log('Listening on port %d', server.address().port);
});

var io = require('socket.io').listen(server);
io.on('connection', function (socket) {
    //Serial port
    var serialport = require("serialport");
    var SerialPort = serialport.SerialPort;

    var sp = new SerialPort("/dev/tty.usbmodem1421", {
        parser: serialport.parsers.readline("\n"),
        baudrate: 9600
    });


    socket.on('disconnect',function(){
        console.log("Client déconecté");
        sp.close(function(){
            console.log("SerialPort close");
        });
    });

    

    sp.on("open", function(){
        sp.on('data', function(data){
            console.log(data);
            var instruction = data.substr(0, 3);
            var html = '<p>Not Found</p>';
            switch (instruction) {
                case "log":
                    var myUser = data.substr(3);
                    html = jade.renderFile('views/project.jade', {user:myUser});
                    break;
                case "prj":
                    var newInstruction = data.substr(3,3);
                    if(newInstruction == "can"){
                        html = jade.renderFile('views/login.jade');
                    }
                    break;
            }
            socket.emit('loadDatas', html);
        });
    });
});
