jQuery(document).ready(function($) {

    $(document).keydown(function(evt) {
    	if (evt.keyCode == 27) {
            if($('#mobileMenu-opener').hasClass('isActive')){
                // hide mobile navigation
                navMobile_fadeOut();
                set_opener_inactive();
            }

            if($('#search').hasClass('show')){
                // hide search
                search_fadeOut();
                enable_scroll();
            }
        }
    });

	function disable_sroll(){			
		$('html,body').addClass('disable_scroll');
	}
	
	function enable_scroll(){			
		$('html,body').removeClass('disable_scroll');
	}
	
	function set_opener_active(){
		$('#mobileMenu-opener').addClass('isActive');
	   	disable_sroll();
	}
	
	function set_opener_inactive(){
		$('#mobileMenu-opener').removeClass('isActive');
		enable_scroll();	
	}
	
	/***** Nav Mobile ******/
	function navMobile_fadeIn(){
		// show mobile navigation
		search_fadeOut();
		$('#nav-mobile').addClass('show');
	}
	
	function navMobile_fadeOut(){
		$('#nav-mobile').addClass('fadeOut').delay(600).queue(function(next){
			$('#nav-mobile').removeClass('fadeOut');	
			$('#nav-mobile').removeClass('show');			
			next();
		});		
	}	
	    
	// attach mobile nav click handler
	$('#mobileMenu-opener').on("click", function(){
		if($('#mobileMenu-opener').hasClass('isActive')){
			// hide mobile navigation
			search_fadeOut();
			navMobile_fadeOut();
			set_opener_inactive();			
		} else{
			set_opener_active();
			navMobile_fadeIn();
	   	}
	});
	
	
	/***** Search ******/
	function search_fadeIn(){
		$('#search').addClass('show');
		$('#search-input').focus();
	}
	
	function search_fadeOut(){
		$('#search').removeClass('show');
	}	
	    
	$('.search-opener').on("click", function(){
		if($('#search').hasClass('show')){
			// hide search
			search_fadeOut();
			enable_scroll();			
		} else{
			// hide nav-mobile if shown
			navMobile_fadeOut();
			search_fadeIn();	
			disable_sroll();	
		}
	});
	
	// Window Size
	
	// check if mobile navigation is still active while screen size is bigger than x
	$( window ).resize(function() {
		if($(window).width() > 1100){
			if($('#mobileMenu-opener').hasClass('isActive')){
				navMobile_fadeOut();	
				search_fadeOut();
                $('#mobileMenu-opener').removeClass('isActive');
			}		
		}
	});	
});