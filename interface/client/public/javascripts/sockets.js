/* **************** */
/*       Steps      */
/* **************** */

// This socket is call to change the content of
// the page by an other view
socket.on('loadDatas', function(data){
	changeContentBy($("main"), data);
});

// Return the content of a html tag to the server
socket.on('getField', function(field){
	socket.emit('returnField', $('#'+field).val());
});

// The server make the order to start cam
socket.on('startCam', function(){
	hideTitle(true);
	startCamAfterWait(2000);
});

// This socket is used to make a photo from the cam
socket.on('takeSnapshot', function(){
	base64 = snapshot();
});

// When the photo is validate, the user can add some text
socket.on('validateSnapshot', function(){
	showText();
});


// The user doesn't like the photo. Action is cancel.
// We have to show cam again
socket.on('cancelSnapshot', function(){
	showPhoto(false);
});

// The photo has already been validate. The text is to.
// We have to send the step to the server, using base64 and text.
socket.on('validateText', function(){
	var array = new Array();
	array.push(base64);
	array.push($('#formId').val());
	socket.emit('saveStep', array);
	base64 = null;
}); 

// Add a material to the optional text area
socket.on('updateMat', function(mats){
	var matsString = "";

	try{

		console.log(mats instanceof Array);

		if(mats.length == 0){
			$('#formId').html("");
			return;
		}

		if(mats.length > 1){
			matsString = "Utilisation des matériaux suivants: ";

			for(var index in mats) { 
				var locMat = mats[index];
				matsString += locMat;
				if(index == mats.length - 1)
					matsString += ".";
				else
					matsString += ", ";
			}
		}
		else{
			matsString = "Utilisation de " + mats[0];
		}

		$('#formId').html(matsString);
	}
	catch(e){
		console.log(e);
	}
});


/* *************************************** */
/*       Notifications with Notify.js      */
/* *************************************** */

// We chose to create a socket by alert type, to make it 
// easier to read the server side. 
// This allows for directly in the name of the socket, the type 
// of notification, and will not pass this information in 
// function parameters.

socket.on('notifError', function(data){
	$.notify(data,"error");
});

socket.on('notifInfo', function(data){
	$.notify(data,"info");
});

socket.on('notifSuccess', function(data){
	$.notify(data,"success");
});

socket.on('notifWarning', function(data){
	$.notify(data,"warn");
});