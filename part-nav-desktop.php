<div class="nav-container">

	<div class="nav-content">
	
		<?php get_template_part('part','logo'); ?>  
		
		<div id="nav-desktop">
			
			<?php 
				$options =  array(
				'echo'              => true,
				'theme_location'    => 'header-nav',
				'items_wrap'        => '<ul id="%1$s">%3$s</ul>', 
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
			<div class='search-opener'>
				<i class="fa fa-search"></i>
			</div>
		</div>
		
		<div id='opener'>
			<div class='middle-bar'></div>
		</div>	
			
	</div>
</div>