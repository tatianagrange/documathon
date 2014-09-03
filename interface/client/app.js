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


/* ************************* */
/*          Context          */
/* ************************* */
var documentationSteps = ["waitLog", "waitProject", "newProject"];
var documentationStep = 0;
var writing = false;
var Author = require('./classes/Author.js').Author;
var myAuthor;
var Project = require('./classes/Project.js').Project;
var myProject;

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

    socket.on('returnField',function(field){
        if(documentationStep == 2){
            socket.emit('notifInfo', "Présenter à nouveau le tag");
            writing = true;
            writeAndDrain('srvprj{"id": 1,"name": "' + field + '"}\n', function(){});
        }
    });


    sp.on("open", function(){
        sp.on('data', function(data){
            console.log(data);
            var instruction = data.substr(0, 3);
            var html = '<p>Not Found</p>';
            var data = data.substr(3);
            var change = false;

            switch (instruction) {
                case "not":
                    instruction = data.substr(0, 3);
                    switch(instruction){
                        case "can":
                            socket.emit('notifError', "Erreur d'écriture");
                            break;
                        case "wri":
                            socket.emit('notifSuccess', "Le tag est bien enrengistré");
                            writing = false;
                            break;
                    }
                    break;
                case "log":
                    if(writing)
                        break;
                    myAuthor = new Author();
                    var error = myAuthor.hydrateWithJson(data);
                    if(error == 1){
                        change = true;
                        html = jade.renderFile('views/project.jade', {name:myAuthor.name});
                        documentationStep = 1;
                    }
                    break;
                case "prj":
                    if(writing)
                        break;
                    if(documentationStep < 1){
                        socket.emit('notifError', "Identification nécessaire pour documenter un projet");
                        break;
                    }
                    myProject = new Project();
                    var error = myProject.hydrateWithJson(data)
                    change = true;
                    if(error == 1)
                        html = jade.renderFile('views/step.jade');
                    else{
                        html = jade.renderFile('views/newProject.jade');
                        documentationStep = 2;
                    }
                    break;
                case "btn":
                    if(writing)
                        break;
                    instruction = data.substr(0, 3);
                    if(instruction == "val"){
                        switch(documentationStep){
                            case 2:
                                socket.emit('getField', "name");
                                break;
                        }
                    }
                    break;
            }

            if(change)
                socket.emit('loadDatas', html);
        });
    });

    function writeAndDrain (data, callback) {
        sp.write(data, function () {
            sp.drain(callback);
        });
    }
});
