<?php 
	
function get_postBg($postId){
	$postBg = new stdClass();
	
	$bgColors = array("bgColor-main","bgColor-second","bgColor-third");	
	
	// check for Background Image
	$image = wp_get_attachment_image_src( get_post_thumbnail_id($postId), 'large');
	
	// set Image as Background
	if(strlen($image[0]) > 0){
		$postBg->style = 'background-image: url('.$image[0].')"';	
		$postBg->class = 'background-image';
	}
	// set Background Color
	else{			
		$i = rand(0,2);
		$postBg->class = $bgColors[$i];
		$postBg->style = '';
	}		
	return $postBg;
}

?>
