jQuery(document).ready(function($) {
       	    
    // check background image
    if($('.background-image').length){
	    BackgroundCheck.init(
		{
			targets: '.backgroundCheck', 
			images: '.background-image'
		});
	}
	
	$('.project').on("click", function(){
		var project_url = $(this).attr('data-project-url');		
		Cookies.set('dpz-project',{offset: window.pageYOffset, url:window.location.href, ttl:1}, { expires: 1 });
		window.location = project_url; 	
	});
	
	
	if(Cookies.get('dpz-project') !== undefined){
		var cookie_project = JSON.parse(Cookies.get('dpz-project'));
		if(cookie_project.ttl == 0){
			window.scrollTo(0,cookie_project.offset);
			Cookies.remove('dpz-project');
		}
	} 

	// grid
	$('#projects').isotope({
		itemSelector: '.project',
		packery: {	gutter: '.gutter-sizer'},
		layoutMode: 'packery'
	});
});