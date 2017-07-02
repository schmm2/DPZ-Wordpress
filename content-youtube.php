<?php
	// get video thumbnails
	$data = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet&id=".$videoId."&key=".$youtubeAPI_key);
	$json = json_decode($data);
	
	// post-image
	if (has_post_thumbnail()){
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');	
		$src = $image[0];
	} else{
		$biggestThumb = null;
		foreach($json->items[0]->snippet->thumbnails as $thumb){
			if($biggestThumb == null){
				$biggestThumb = $thumb;
			} 
			// check if this thumb is bigger
			else{
				if($thumb->width > $biggestThumb->width){
					$biggestThumb = $thumb;
				}
			}
		}
		$src = $biggestThumb->url;
	}
?>
	
<div class="player-youtube">
	
	<!--- Post Text content --->
	<div class="post-shadow">	
		<div class='post-content'>
			<div class='post-title'>
				<p><?php the_title(); ?></p>
			</div>
			<div class="post-date"></div>
			<div class='post-text'>							
				<?php the_excerpt(); ?>
				<button class="button-play button-colored"/>
			</div>
		</div>
	</div>
	
	<!-- Post Image backgroundCheck-image-->		
	<div class='post-image' style="background-image: url(<?php echo $src ?>)"></div>

	<!--  Player -->
	<div id="player-youtube-<?php echo get_the_id() ?>" class="player" data-videoid="<?php echo $videoId ?>"></div>
</div>