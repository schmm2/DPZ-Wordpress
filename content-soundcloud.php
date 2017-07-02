<script type="text/javascript" src="http://w.soundcloud.com/player/api.js"></script>
<?php

	$player_id = "player-soundcloud-".get_the_id();
	
	$api_url = "https://w.soundcloud.com/player/?visual=true&url=".urlencode($post_url)."&show_artwork=true";
	
	// post-image	
	if (has_post_thumbnail()){
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
		$src = $image[0];
	}else{
		$src = '';
	}
?>
	
<div class="player-soundcloud">
	
	<!-- Post Text content -->
	<div class="post-shadow">	
		<div class='post-content'>
			<div class='post-title'>
				<p><?php the_title(); ?></p>
			</div>
			<div class="post-date"></div>
			<div class='post-text'>							
				<?php the_excerpt(); ?>
				<button class="button-play button-colored" />
			</div>
		</div>
	</div>
	
	<!-- Post Image -->	
	<div class="post-image" style="background-image: url('<?php echo $src ?>')"></div>
	
	<!-- Player -->
	<iframe class="player" id="<?php echo $player_id?>"  src="<?php echo $api_url?>" frameborder="no"></iframe>
</div>