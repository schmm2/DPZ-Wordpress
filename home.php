<?php 
get_header(); 
require_once 'php/post-bg-helper.php';
?>

<div id="news-container" class="swiper-container">   
	<div class="swiper-pagination"></div>	
    <div class="swiper-wrapper">
					
		<?php 
		
		$youtubeAPI_key = "AIzaSyDGlj-Zm-zbBlh_wGXCz_lpDHhpSBzLIxQ";
		
		//***** show posts *****				
		if (have_posts()) : while (have_posts()) : the_post();
									
			/* Get Post Format */
			// default post format, content-newsPost.php
			$format = 'newsPost';
			
			$videoId = 0;
			
			$post_url  = get_post_meta( get_the_id(), '_dpz_post_url', true );
			
			if($post_url != ''){
				// post url is set
				// Youtube
				if (strpos($post_url,'youtube.com') !== false) {
			    	$format = 'youtube';
			    	$videoId = youtube_id_from_url($post_url);		
			    } 
			    // Soundcloud
			    else if (strpos($post_url,'soundcloud.com') !== false){
				    $format = 'soundcloud';
			    } 
			    // Vimeo
			    else if (strpos($post_url,'vimeo.com') !== false){
				    $format = 'vimeo';
			    } 
			}			
			
			echo "<div class='swiper-slide'>";	
				// locate_template supports reuse of outer variables, get_template_part doesn't
				include(locate_template('content-'.$format.'.php'));								
			echo "</div>";

		endwhile;
		
		dpz_pagination_nav();?>	
		
		<?php else:
		//***** No posts yet *****	
		
		$postBg = get_postBg(get_the_id());	
		?>
		<div class="post swiper-slide <?= $postBg->class ?>" style="<?= $postBg->style ?>">
			<div class="post-shadow">	
				<div class='post-content backgroundCheck'>
					<div class='post-title backgroundCheck'>
						<p>Sorry</p>
					</div>
					<div class='post-text'>Keine Posts gefunden</div>
				</div>	
			</div>			
		</div>
		<? endif ?>
		
	</div>
</div>
<div id="slider" class="arrow-top backgroundCheck bgBorderColor-second-hover">
	<div id="slider-arrow"></div>
</div>

<?php get_footer(); ?>
