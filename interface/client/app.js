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

    socket.on('disconnect',function(){
        console.log("Je suis déco");
    });

    //Serial port
    var serialport = require("serialport");
    var SerialPort = serialport.SerialPort;
    try {
        var sp = new SerialPort("/dev/tty.usbserial-A600eo9b", {
            parser: serialport.parsers.readline("\n"),
            baudrate: 9600
        });

        sp.on("open", function(){
            sp.on('data', function(data){
                var html = '<p>Not Found</p>';
                if(data == 0x0100){
                    html = jade.renderFile('views/login.jade');
                    
                }
                if(data == 0x0101){
                    html = jade.renderFile('views/project.jade', {user:"Mon user"});
                }
                socket.emit('loadDatas', html);
            });
        });     
    } catch (err) {
        console.log("H:", err)
    }
});
