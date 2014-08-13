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

function changeContentBy(wrapper, data){
	wrapper.hide( "blind", {direction: "vertical"}, 1000, callback(wrapper, data));
}

function callback(wrapper, data){
	wrapper.html(data);
	wrapper.show( "blind", {direction: "vertical"}, 1000 );
}