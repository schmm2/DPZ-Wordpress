<?php	
		
	// get video thumbnails
	$data = file_get_contents("https://vimeo.com/api/oembed.json?url=".urlencode($post_url));
	$data_json = json_decode($data);

	$player_id = "player-vimeo-".get_the_id();

	$api_url = "https://player.vimeo.com/video/".$data_json->video_id."?api=1&player_id=".$player_id;
	
	// post-image	
	if (has_post_thumbnail()){
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
		$src = $image[0];
	}else{
		$src = $data_json->thumbnail_url;
	}
?>
	
<div class="player-vimeo post swiper-slide">
	
	<!-- Post Text content -->
	<div class="post-shadow">	
		<div class='post-content backgroundCheck'>
			<div class='post-title backgroundCheck'>
				<p><?php the_title(); ?></p>
			</div>
			<div class="post-date"></div>
			<div class='post-text'>							
				<?php the_excerpt(); ?>
				<button class="bgBorderColor-second-dark-hover button-play">Ansehen</button>
			</div>
		</div>	
	</div>	
	
	<!-- Post Image -->	
	<div class="post-image" style="background-image: url('<?php echo $src ?>')"></div>
	
	<!-- Player -->
	<iframe id="player-vimeo-<?php echo get_the_id() ?>" class="player" src=<?php echo $api_url?> frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>