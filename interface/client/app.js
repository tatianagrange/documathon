/* **************************** */
/*          All Require         */
/* **************************** */
var express = require('express');
var path = require('path');
var favicon = require('static-favicon');
var logger = require('morgan');
var cookieParser = require('cookie-parser');
var bodyParser = require('body-parser');
var jade = require('jade');
var routes = require('./routes/index');
var fs = require('fs');
var request = require("request");


/* ************************** */
/*          Protocol          */
/* ************************** */
var serialProto;

/* ********************* */
/*          RTC          */
/* ********************* */
var static = require('node-static');
var file = new(static.Server)();


/* **************************** */
/*          Define app          */
/* **************************** */
var app = express();
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
    file.serve(req, res);
    res.status(err.status || 500);
    res.render('error', {
        message: err.message,
        error: {}
    });
});


module.exports = app;





/* ************************ */
/*          Server          */
/* ************************ */
var server = app.listen(3000, function() {
    console.log('Listening on port %d', server.address().port);
});



var io = require('socket.io').listen(server);
io.on('connection', function (socket) {
    var SerialProtocol = require("./classes/SerialProtocol").SerialProtocol;
    serialProto = new SerialProtocol(socket,jade);
    
    serialProto.sp.on("open", function(){
        serialProto.sp.on('data', function(data){
            serialProto.startProtocol(data);
        });
    });
    
    socket.on('disconnect',function(){
        console.log("Client déconecté");
        serialProto.sp.close(function(){
            console.log("SerialPort close");
        });
    });

    socket.on('returnField',function(field){
        var url = "http://api.documathon.tgrange.com/projects/create/project/" + field;
       
        request({
            url: url,
            json: true
        }, function (error, response, body) {

            if (!error && response.statusCode === 200) {
                serialProto.emitInfo("Présenter à nouveau le tag");
                serialProto.myContext.writing = true;
                writeAndDrain('srvprj{"id": ' + body.datas + ',"name": "' + field + '"}\n', function(){});
            }
        });
    });

    socket.on('saveStep',function(table){
        serialProto.saveStep(table);
    });


    // Protocole ----------------------------------------------
    socket.on('log',function(){
        serialProto.startProtocol("log{\"id\": 6,\"name\": \"Faclab\",\"birth\": \"\"}");
    });

    socket.on('proj',function(){
        serialProto.startProtocol("prj{\"id\": 1,\"name\": \"Enceintes\"}");
    });

    socket.on('val',function(){
        serialProto.startProtocol("btnval");
    });

    socket.on('shr',function(){
        serialProto.startProtocol("shr");
    });
    // ----------------------------------------------  Protocole


    function writeAndDrain (data, callback) {
        serialProto.sp.write(data, function () {
            serialProto.sp.drain(callback);
        });
    }
});
