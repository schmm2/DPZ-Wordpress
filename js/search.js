jQuery(document).ready(function($) {
	
	
	function disableScroll(){
		$('html, body').css({
		    'overflow': 'hidden',
		    'height': '100%'
		});
	}
	
	function enableScroll(){
		$('html, body').css({
		    'overflow': 'auto',
		    'height': 'auto'
		});
	}
	
	// Nav Mobile	
	function navMobile_fadeIn(){
		// show mobile navigation
		$('#nav-mobile').addClass('show');
	   	$('#nav-mobile-opener').addClass('isActive');
	   	disableScroll();
	}
	
	function navMobile_fadeOut(){
		$('#nav-mobile').addClass('fadeOut').delay(600).queue(function(next){
			$('#nav-mobile').removeClass('fadeOut');	
			$('#nav-mobile').removeClass('show');			
			next();
		});		
		$('#nav-mobile-opener').removeClass('isActive');
		enableScroll();	
	}	
	    
	// attach mobile nav click handler
	$('#nav-mobile-opener').on("click", function(){
		if($('#nav-mobile').hasClass('show')){
			// hide mobile navigation
			navMobile_fadeOut();			
		} else{
			navMobile_fadeIn()		
	   	}
	});
	
	
	// Search
	
	function search_fadeIn(){
		$('#search').addClass('show');
		$('#search-input').focus();
	   	disableScroll();
	}
	
	function search_fadeOut(){
		$('#search').removeClass('show');
		enableScroll();	
	}	
	    
	$('.search-opener').on("click", function(){
		if($('#search').hasClass('show')){
			// hide search
			search_fadeOut();			
		} else{
			navMobile_fadeOut();
			search_fadeIn();		
	   }
	});
	
	// Window Size
	
	// check if mobile navigation is still active while screen size is bigger than x
	$( window ).resize(function() {
		if($(window).width() > 1100){
			if($('#nav-mobile-opener').hasClass('isActive')){
				navMobile_fadeOut();	
				search_fadeOut();			
			}		
		}
	});


	
});