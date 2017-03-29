<?php 
function get_businessLocations(){	
	
	$pageId = $_POST['page_id'];
	$location['latitude'] = get_post_meta( $pageId, '_dpz_contact_map_latitude', true );
	$location['longitude'] = get_post_meta( $pageId, '_dpz_contact_map_longitude', true ); 
	echo json_encode($location);
	die();		
}
	
?>