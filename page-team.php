<?php
/*
Template Name: Team*/    

get_header();
	 

// Get 'team' posts
$teamMember_posts = get_posts( array(
	'post_type' => 'teamMember',
	'posts_per_page' => -1, // Unlimited posts
	'orderby' => 'title', // Order alphabetically by name
) );


if ($teamMember_posts ):
?>
<?php reset_project_property() ?>
<div id='team-bg'>
	<div class="content-center">
		<div class="intro">
			<?php
			if ( have_posts() ) : while ( have_posts() ) : the_post();
				the_content();
			endwhile; 
			endif;
			?>
		</div>
	
		<section id="team" class="js-masonry" data-masonry-options='{ "gutter":".grid-gutter-sizer", "percentPosition": "true","columnWidth": ".grid-column-sizer","itemSelector": ".project"}'>
			<div class="grid-gutter-sizer"></div>
			<div class="grid-column-sizer"></div>
			<?php 
								
			foreach ($project_posts as $post_index => $post): 
				if($post_index > 0){
					
					setup_postdata($post);
															
					?>
					<div class="teamMember">
						<div class="background">										
							<!-- Title/ Name -->
							<div class='title'><?php echo $post->post_title ?></div>
						</div>
						<!-- Text -->
						<div class="text"><?php echo $post->post_content ?></div>
					</div>
			<?php
				} 
			endforeach; 
			?>
		</section>
	</div>
</div>
<?php endif; ?>


<?php

	get_footer(); 
?>
