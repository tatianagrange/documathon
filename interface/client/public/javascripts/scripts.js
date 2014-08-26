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
	//wrapper.hide("blind", {direction: "vertical"}, 1000, wrapper.html(data)).show( "blind", {direction: "vertical"}, 1000 );
	$('main').hide("blind", {direction: "vertical"}, 1000, function(){
   		var div = $(data).hide();
   		$(this).replaceWith(div);
   		div.center();
   		$('main').show( "blind", {direction: "vertical"}, 1000);

	});
}