/* SCROLL START */
$(window).load(function () {
	var sgallery = $(".slider-gallery");
	var ul = $('ul.inclist');	
	var li = ul.find("li");	
	var liMargL = li.css("marginLeft");
	var liMargR = li.css("marginRight");
	var liMargs = parseInt(liMargL) + parseInt(liMargR);
	ul.css({
		width: (li.width()+liMargs)*li.length
	})
	var productWidth = ul.innerWidth() - sgallery.outerWidth();
	var maxValue = productWidth-liMargs;
	$('.slider').slider({
		min: 0, 
		max: maxValue,
		value: 0,
		animate: true,
		slide: function(event, ui) {
			ul.css('left', '-' + ui.value + 'px');
		}, 
		stop: function(event, ui) {
			//ul.animate({ 'left' : '-' + ui.value + 'px' }, 500);
		}
	});
	$(".ui-slider-handle").click(function(){
		return
	});
});
/* SCROLL START */