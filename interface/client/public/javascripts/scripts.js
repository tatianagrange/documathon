/* *********************** */
/*        Functions        */
/* *********************** */

$.fn.center = function () {
	this.css("position","absolute");
	this.css("width","50%");
	this.css("top", ( $(window).height() - this.height() ) / 2  + "px");
	this.css("left", ((( $(window).width() - this.width() ) / 2) - (15*$(window).width()/100)) + "px");
	return this;
}

$.fn.onTop = function(size){
	this.css("top", size+"px");
}

function hideTitle(isHide){
	if(isHide){
		$('header').hide("blind", {direction: "vertical"}, 1000);
	}else{
		$('header').show( "blind", {direction: "vertical"}, 1000);
	}
}

function changeContentBy(wrapper, data){
	$('main').hide("blind", {direction: "vertical"}, 1000, function(){
   		var div = $(data).hide();
   		$(this).replaceWith(div);
   		div.center();
   		$('main').show( "blind", {direction: "vertical"}, 1000);
	});
}

function successCallback(stream) {
	window.stream = stream; // stream available to console
	var video = document.querySelector("video");
	video.src = window.URL.createObjectURL(stream);
	video.play();
	$('main').onTop(100);
}

function errorCallback(error){
	console.log("getUserMedia error: ", error);
}

function snapshot() {
	var video        = $('video'),
		canvas       = $('canvas').get(0),
		photo        = $('img');
		width		 = $('video').width(),
		height		 = $('video').height();

	canvas.width = width;
	canvas.height = height;

    showPhoto(true);

	canvas.getContext('2d').drawImage(video.get(0), 0, 0, width, height);
	$('video').get(0).setAttribute('src', "");

	var data = canvas.toDataURL('image/png');
	photo.get(0).setAttribute('src', data);
    
    //return base64 to emit socket
    return canvas.toDataURL();
}

function showText(){
	$('main').onTop(0);
	$('#takeText').show("blind", {direction: "vertical"}, 10);
	$('#question').hide("blind", {direction: "vertical"}, 10);
}

function showPhoto(isShowing){
	if(isShowing == true){
		$('#takePhoto').hide("blind", {direction: "vertical"}, 1);
		$('#askPhoto').show("blind", {direction: "vertical"}, 1);
	}else{
		$('#takePhoto').show("blind", {direction: "vertical"}, 1);
		$('#askPhoto').hide("blind", {direction: "vertical"}, 1);
		startCamAfterWait(1);
	}
}

function startCamAfterWait(wait){
	setTimeout(function()
        { 
        	var constraints = {video: true};
        	getUserMedia(constraints, successCallback, errorCallback); 
        }
    , wait);
}

 
function reloadInXSeconds(){
	max_time--;
	document.getElementById('countdown').innerHTML = max_time;
	if(max_time == 0){
		clearInterval(cinterval);
		console.log("ok");
		window.location.replace("/");
	}
}