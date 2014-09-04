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

$.fn.onTop = function(){
	this.css("top", "100px");
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
	$('main').onTop();
}

function errorCallback(error){
	console.log("getUserMedia error: ", error);
}