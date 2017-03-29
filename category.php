<?php get_header(); 

get_template_part( 'content', 'searchbar' );?>	

<div id="posts-bg">

	<div id='posts' class='content-center'>
		
		<!-- Loop for Posts -->
		<?php if (have_posts()) : while (have_posts()) : the_post();
			
			get_template_part( 'content', get_post_format() );			
		
		endwhile;?>
		<!-- End Post Loop -->
		
		
		<?php else:?>
		
			<p><?php _e('Sorry, there are no posts yet'); ?></p>
			
		<?php endif; ?>
		
	</div>
		
</div>
	
<?php get_footer(); ?>