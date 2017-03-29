(function ( $ ) {
	
	$.fn.bgBrightness= function(limit) {
	
		// categories bg color
		var color = $(this).css('background-color');	
		var rgb = color.substring(4, color.length-1)
	         .replace(/ /g, '')
	         .split(',');
		var o = Math.round(((parseInt(rgb[0]) * 299) + (parseInt(rgb[1]) * 587) + (parseInt(rgb[2]) * 114)) /1000);	
		(o > limit) ? $(this).addClass('bgLight') :  $(this).addClass('bgDark'); 	
	};
	
}( jQuery ));