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
var Context = require('./Context.js').Context;
var myContext;


/* ***************************** */
/*          Constructor          */
/* ***************************** */

/**
*   The real constructor
*/
exports.SerialProtocol = SerialProtocol = function(socket, jade) {
    //////////////////////////////////
    //          Attributes          //
    //////////////////////////////////
	this.socket = socket;
    this.jade = jade;
    this.myContext = new Context();

    /////////////////////////////////////////
    //          SerialPort Config          //
    /////////////////////////////////////////
    this.sp = new SerialPort("/dev/tty.usbmodem1421", {
        parser: serialport.parsers.readline("\n"),
        baudrate: 9600
    });

};

/**
*   This function is call to start the protocol.
*   It is not realy a constructor, but it is necessary to 
*   Call that function to strat the protocol gestion.
*   
*   This function is call each time there is someting on the serial port
*/
SerialProtocol.prototype.startProtocol = function(data){
    //Log the datas
    console.log(data);

    //Define variables to switch all possibilities
    var instruction = data.substr(0, 3);
    var html = null;
    var data = data.substr(3);

    //The instruction must be one of the protocole String
    switch (instruction) {
        case "not":
            html = this.instructionNotififaction(data);
            break;
        case "log":
            html = this.instructionLogin(data);
            break;
        case "prj":
            html = this.instructionProject(data);
            break;
        case "btn":
            html = this.instructionButton(data);
            break;
        case "mat":
            var mats = this.instructionMaterial(data);
            this.socket.emit('updateMat', mats);
            break;
        case "shr":
            this.instructionShare(data);
            break;
    }

    if(html != null)
        this.socket.emit('loadDatas', html);
}


/* *************************** */
/*          Functions          */
/* *************************** */
SerialProtocol.prototype.emitInfo = function(data){
    this.socket.emit('notifInfo', data);
}

SerialProtocol.prototype.emitWarning = function(data){
    this.socket.emit('notifWarning', data);
}

SerialProtocol.prototype.emitError= function(data){
    this.socket.emit('notifError', data);
}

SerialProtocol.prototype.emitSuccess= function(data){
    this.socket.emit('notifSuccess', data);
}

SerialProtocol.prototype.saveStep= function(table){
    this.myContext.actualStep.base = table[0];
    this.myContext.actualStep.text = table[1];
    this.myContext.saveActualStep();

    var html = this.jade.renderFile('views/stepCam.jade');
    this.socket.emit('loadDatas', html);
    this.socket.emit('startCam');

    console.log(this.myContext.myProject);
    this.myContext.actualStep = new Step();
}



/* ****************************** */
/*          Instructions          */
/* ****************************** */
SerialProtocol.prototype.instructionNotififaction = function(data){
    instruction = data.substr(0, 3);
    switch(instruction){
        case "can":
            this.emitError("Erreur d'écriture");
            break;
        case "wri":
            this.emitSuccess("Le tag est bien enrengistré");
            this.myContext.writing = false;
            break;
    }
    return null;
}

SerialProtocol.prototype.instructionLogin = function(data){
    if(this.myContext.writing)
        return null;

    var html = null;
    var error = this.myContext.makeAuthor(data);
    if(error == 1){
        html = this.jade.renderFile('views/project.jade', {name:this.myContext.myAuthor.name});
        this.myContext.documentationStep = 1;
    }

    return html;
}

SerialProtocol.prototype.instructionProject = function(data){
    if(this.myContext.writing)
        return null;
    if(this.myContext.documentationStep < 1){
        this.socket.emit('notifError', "Identification nécessaire pour documenter un projet");
        return null;
    }

    var html = null;
    var error = this.myContext.makeProject(data);
    if(error == 1){
        this.socket.emit('startCam');
        html = this.jade.renderFile('views/stepCam.jade');
        this.myContext.documentationStep = 3;
    }
    else{
        html = this.jade.renderFile('views/newProject.jade');
        this.myContext.documentationStep = 2;
    }

    return html;
}

SerialProtocol.prototype.instructionButton = function(data){
    if(this.myContext.writing)
        return null;

    instruction = data.substr(0, 3);
    console.log(instruction);
    if(instruction == "val"){
        this.instructionValidate();
    }else if(instruction == "can"){
        this.instructionCancel();
    }

    return null;
}

SerialProtocol.prototype.instructionShare = function(data){
    switch(this.myContext.documentationStep){
        case 3:
            this.emitSuccess("En cours d'envoi");
            break;
        default:
            this.emitWarning("Valide ta photo et ton étape avant de partager ton projet!");
            break;
    }
}

SerialProtocol.prototype.instructionCancel = function(data){
    switch(this.myContext.documentationStep){
        case 4:
            this.myContext.documentationStep = 3;
            this.socket.emit('cancelSnapshot');
            break;
    }
}

SerialProtocol.prototype.instructionMaterial = function(data){
    switch(this.myContext.documentationStep){
        case 5:
            return this.myContext.addMaterial(data);
            break;
    }

    return null;
}

SerialProtocol.prototype.instructionValidate = function(data){
    switch(this.myContext.documentationStep){
        case 2:
            this.socket.emit('getField', "formId");
            break;
        case 3:
            this.myContext.documentationStep = 4;
            this.socket.emit('takeSnapshot');
            break;
        case 4:
            this.myContext.documentationStep = 5;
            this.socket.emit('validateSnapshot');
            break;
        case 5:
            this.myContext.documentationStep = 3;
            this.socket.emit('validateText');
            break;
    }
}

// function decodeBase64Image(dataString) {
//     var matches = dataString.match(/^data:([A-Za-z-+\/]+);base64,(.+)$/),
//     response = {};

//     if (matches.length !== 3) {
//     return new Error('Invalid input string');
//     }

//     response.type = matches[1];
//     response.data = new Buffer(matches[2], 'base64');

//     return response;
// }