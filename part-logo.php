<div id="logo">	
	<?php if (get_theme_mod( 'dpz_logo' ) || file_exists( TEMPLATEPATH . '/css/img/logo.png' ))  : ?>
		<a class='image-link' href="<?php echo get_settings('home'); ?>">
			<?php if (get_theme_mod( 'dpz_logo' )): ?>
				<img src="<?php echo get_theme_mod( 'dpz_logo' ) ?>" alt="<?php bloginfo('name'); ?>" />
			<?php elseif  ( file_exists( TEMPLATEPATH . '/css/img/logo.png' ) ): ?>
				<img src="<?php echo get_template_directory_uri(); ?>/css/img/logo.png" alt="<?php bloginfo('name'); ?>" />
			<?php endif; ?>
		</a>
	<?php else : ?>
		<a href="<?php echo home_url(); ?>">
			<p id='logo-siteName'><?php bloginfo('name'); ?></p>
		</a> 
	<? endif; ?>
</div>