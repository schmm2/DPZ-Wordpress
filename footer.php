			<div id="footer">
			
				<?php 
				wp_footer(); 
					
				if(!is_home() && !is_search()):?>
					
					<div id='footer-content' class='content-center'>
						<div id="sites">
							<h3>Sites</h3>
							<?php 
								$options =  array(
								'echo'              => true,
								'theme_location'    => 'nav-header',
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
						</div> 
						<div id="socialMedia"> 
							<h3>Social Media</h3>
							
							<?php							
							$options =  array(
								'echo'              => true,
								'theme_location'    => 'nav-socialLinks',
								'items_wrap'        => '<ul id="%1$s">%3$s</ul>',
								'fallback_cb'     	=> false,
								'menu_class'        => false, 
							    'menu_id'           => false,
							    'container'         => false,
							    'container_class'   => false,
							    'container_id'      => false,
							    'before'            => false,
							    'after'             => false,
							    'walker'			=> new dpz_socialLink_walker_nav_menu
						    );
							?> 
							
							<div id='socialLinks'>
								<?php wp_nav_menu($options) ?>				 
							</div>
						</div>
						
						<?php if(!is_page_template('page-contact.php')): ?>
							<div id="contactForm-container">
								<h3>Schreib uns!</h3>
								<? get_template_part( 'part', 'contactForm' );	?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif ?>					
			</div>
		</div>
	</body>
</html>