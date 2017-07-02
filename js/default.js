jQuery(document).ready(function($) {


    BackgroundCheck.init({
        targets: '.backgroundCheck',
        images: '.background-image'
    });


    /* Bugfill */
   	viewportUnitsBuggyfill.init({hacks: window.viewportUnitsBuggyfillHacks});
  
	var didScroll = false;	
	window.onscroll = scrollIt;
	
	function scrollIt() {
	    didScroll = true;    
	}
	
	setInterval(function() {
	    if(didScroll) {
	        didScroll = false;
	        
	        var scrollTop = $(window).scrollTop();
	        if(scrollTop > 80){
		        $('#site-overlay').addClass('fixIt'); 
	        } else{
		        if($('#site-overlay').hasClass('fixIt')){
			        $('#site-overlay').removeClass('fixIt'); 
		        }
		        // calculate height for site-overlay
		        var windowHeight = $(window).height();
		        var navContainerHeight = $('#nav-container').height();
				$('#site-overlay').height(windowHeight - navContainerHeight + scrollTop);
	        }
	    }
	}, 10);
  
});