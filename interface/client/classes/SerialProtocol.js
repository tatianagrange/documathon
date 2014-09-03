/* ********************************* */
/*          Serial port npm          */
/* ********************************* */
var serialport = require("serialport");
var SerialPort = serialport.SerialPort;


/* **************************** */
/*          Attributes          */
/* **************************** */
var socket;
var sp;
var jade;


/* ************************* */
/*          Context          */
/* ************************* */
var documentationSteps = ["waitLog", "waitProject", "newProject"];
var documentationStep = 0;
var writing = false;
var Author = require('./Author.js').Author;
var myAuthor;
var Project = require('./Project.js').Project;
var myProject;


/* ***************************** */
/*          Constructor          */
/* ***************************** */
exports.SerialProtocol = SerialProtocol = function(socket, jade) {
    /* **************************** */
    /*          Attributes          */
    /* **************************** */
	this.socket = socket;
    this.jade = jade;

    /* *********************************** */
    /*          SerialPort Config          */
    /* *********************************** */
    this.sp = new SerialPort("/dev/tty.usbmodem1421", {
        parser: serialport.parsers.readline("\n"),
        baudrate: 9600
    });

};

/* *************************** */
/*          Functions          */
/* *************************** */
SerialProtocol.prototype.emitInfo = function(data){
    console.log(data);
    this.socket.emit('notifInfo', data);
}

SerialProtocol.prototype.openSerial = function(data){
    console.log(data);
    //Define variables to switch all possibilities
    var instruction = data.substr(0, 3);
    var html = 'Not Found';
    var data = data.substr(3);
    var change = false;

    //The instruction must be one of the protocole String
    switch (instruction) {
        case "not":
            instruction = data.substr(0, 3);
            switch(instruction){
                case "can":
                    this.socket.emit('notifError', "Erreur d'écriture");
                    break;
                case "wri":
                    this.socket.emit('notifSuccess', "Le tag est bien enrengistré");
                    this.writing = false;
                    break;
            }
            break;
        case "log":
            if(this.writing)
                break;
            this.myAuthor = new Author();
            var error = this.myAuthor.hydrateWithJson(data);
            if(error == 1){
                change = true;
                html = this.jade.renderFile('views/project.jade', {name:this.myAuthor.name});
                this.documentationStep = 1;
            }
            break;
        case "prj":
            if(this.writing)
                break;
            if(this.documentationStep < 1){
                this.socket.emit('notifError', "Identification nécessaire pour documenter un projet");
                break;
            }
            this.myProject = new Project();
            var error = this.myProject.hydrateWithJson(data)
            change = true;
            if(error == 1)
                html = this.jade.renderFile('views/step.jade');
            else{
                html = this.jade.renderFile('views/newProject.jade');
                this.documentationStep = 2;
            }
            break;
        case "btn":
            if(this.writing)
                break;
            instruction = data.substr(0, 3);
            if(instruction == "val"){
                switch(this.documentationStep){
                    case 2:
                        this.socket.emit('getField', "name");
                        break;
                }
            }
            break;
    }

    if(change)
        this.socket.emit('loadDatas', html);
}