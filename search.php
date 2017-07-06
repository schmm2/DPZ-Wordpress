<?php
get_header();
?>

<div id="news-container" class="swiper-container">
    <div class="swiper-pagination"></div>
    <div class="swiper-wrapper">

		<?php

		$i = 0;
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
				// Youtube - short
				if (strpos($post_url,'youtu.be') !== false) {
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
			?>

            <div class='post swiper-slide'>

				<?php

				// locate_template supports reuse of outer variables, get_template_part doesn't
				include(locate_template('content-'.$format.'.php'));

				// first slide only
				if($i == 0){

					?>
                    <div id='slideDown-container'><div id='slideDown'></div></div>
					<?php
				}

				?>
            </div>

			<?php
			$i++;

		endwhile;

			dpz_pagination_nav();?>

		<?php else:
			//***** No posts yet *****
			?>

            <div class="post swiper-slide">
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

    <div id="slider" class="arrow-top button">
        <div id="slider-arrow"></div>
    </div>
</div>


<?php get_footer(); ?>
