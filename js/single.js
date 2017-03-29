jQuery(document).ready(function($) {
	
	var url_back;
	
	if(Cookies.get('dpz-project') != undefined){
		var cookie_project = JSON.parse(Cookies.get('dpz-project'));
		url_back = cookie_project.url;
		Cookies.set('dpz-project',{offset:cookie_project.offset, url: url_back,ttl:0}, { expires: 1 });
	} else if(Cookies.get('dpz-news') != undefined){
		var cookie_news =  JSON.parse(Cookies.get('dpz-news'));
		url_back = cookie_news.url;
		Cookies.set('dpz-news',{index:cookie_news.index, url: url_back, ttl:0}, { expires: 1 });
	}
	
	$('.arrow-back').on("click", function(){
		window.location = url_back;
	});
});