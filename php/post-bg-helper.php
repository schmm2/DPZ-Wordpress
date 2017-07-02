<?php
	function get_postBg($postId = false){
		$postBg = new stdClass();

		if($postId != false) {
			// check for Background Image
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $postId ), 'large' );

			// set Image as Background
			if(strlen($image[0]) > 0){
				$postBg->style = 'background-image: url('.$image[0].')';
				$postBg->class = 'background-image';
				$postBg->src = $image[0];

				return $postBg;
			}
		}

		$default_img_url = get_template_directory_uri() . '/img/bggrey.jpg';
		$postBg->style = 'background-image: url('.$default_img_url.'); background-repeat: no-repeat; background-origin: padding-box';
		$postBg->class = 'background-image';
		$postBg->src = $default_img_url;

		return $postBg;
	}
?>