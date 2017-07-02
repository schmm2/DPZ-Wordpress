<!-- Navigation --> 				
<div id="nav-container">
	<div class="nav-content">
	
		<?php get_template_part('part','logo'); ?>  
		
		<div id="nav-desktop">
			
			<?php 
				if(is_home() || is_search()) $search = '<li class="search-opener"><i class="fa fa-search"></i></li>';
				
				$options =  array(
				'echo'              => true,
				'theme_location'    => 'nav-header',
				'items_wrap'        => '<ul id="%1$s">%3$s '.$search.' </ul>', 
			    'menu_class'        => false, 
			    'menu_id'           => false,
			    'container'         => false,
			    'container_class'   => false,
			    'container_id'      => false,
			    'before'            => false,
			    'after'             => false
			    );
			    wp_nav_menu($options);	
			?>
		</div>
		
		<div id='mobileMenu-opener'>
			<div class='middle-bar'></div>
		</div>	
			
	</div>
</div>


<?php
	
// Featured Image	
if(has_post_thumbnail()){
	$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'single-page-thumbnail');
	$src = $img[0];
}
else{
	$src = get_header_image();
}				

if(!is_front_page() && !is_search() && $src != null):?>
<!-- Header Image -->
<div id="header-image">
	<div class="post-shadow">
		<div class="post-content">
			<div class="post-title">
				<p class="backgroundCheck"><?= get_the_title();?></p>
			</div>
		</div>
	</div>
	<div class="post-image background-image" style="background-image: url('<?php echo $src ?>');"></div>
</div>
<?php endif ?>	
