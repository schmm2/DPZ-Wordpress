jQuery(function() {

	// *** Create Map Object ***
	var mapOptions = {
	   	center: new google.maps.LatLng(0,0),
	   	zoom: 2,
	   	mapTypeId: google.maps.MapTypeId.ROADMAP,
	  	panControl: false,
	   	zoomControl: true,
	   	mapTypeControl: false,
	   	scaleControl: false,
	   	streetViewControl: false,
	   	overviewMapControl: false
	};
	map = new google.maps.Map(document.getElementById("map"),mapOptions); 
	
	markers = Array();
	
		   
	// create marker on map
	function create_marker(longitude, latitude)
	{	
		var marker = new google.maps.Marker({
	       	map: map,
	       	position: new google.maps.LatLng(latitude,longitude)
	    });	
	    markers.push(marker);		
	}	
	
	function set_boundaries(){
		//  Create a new viewpoint bound
		var bounds = new google.maps.LatLngBounds ();
		//  Go through each marker
		for (var i = 0; i < markers.length; i++) {
		  //  And increase the bounds to take this point
		  bounds.extend (markers[i]['position']);
		}
		// Fit these bounds to the map
		map.fitBounds (bounds);
		map.setZoom(16);
	}
	
	// Get images with geo tags from db
	jQuery.post( 
		globals.ajaxurl,
		{action : 'get_businessLocations', "page_id":page_id})
		.done(function(data) 
		{
			locations = JSON.parse(data);
						
			// create markers
			create_marker(locations["longitude"], locations["latitude"]);
			set_boundaries();
    	}
    );
         
	
    
	
});    