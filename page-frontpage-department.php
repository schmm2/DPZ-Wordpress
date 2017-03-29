<?php
/*
Template Name: Department Frontpage*/    

get_header();

// Get 'department' posts
$departments = get_posts( array(
	'post_type' => 'department',
	'posts_per_page' => -1, // Unlimited posts
	'orderby' => 'title', // Order alphabetically by name
) );

?>

<div id="frontpage-container">
	<div id="info-container">
		
		
		<?php get_template_part('part','logo'); ?>  		
		
		<?php
			$pageId = get_the_ID();
			$street  = get_post_meta( $pageId, '_dpz_departmentFrontpage_street', true ); 
			$city = get_post_meta( $pageId, '_dpz_departmentFrontpage_city', true );
			$mail = get_post_meta( $pageId, '_dpz_departmentFrontpage_mail', true );	
		?>

		<div id="contact">
			<?php 
				if (have_posts()) : while (have_posts()) : the_post();
					the_content();
				endwhile; endif;				
			?>
			
			<div id="contact-table">
				<?php if($mail):?>
					<div class="row">
						<div><i class="fa fa-envelope-o "></i></div>
						<div><a href="mailto:<?php echo $mail ?>" target="_top"><?php echo $mail ?></a></div>
					</div>
				<?php endif; ?>
				<?php if($street & $city):?>
					<div class="row">
						<div><i class="fa fa-location-arrow"></i></div>
						<div><a href="https://www.google.ch/maps/place/<?php echo $street?>,<?php echo $city?>" target="_blank"><?php echo $street ?></br><?php echo $city ?></a></div>
					</div>
				<?php endif; ?>
			</div>
		</div>	
	</div>
	
	<div id="section-container">		
		 <?php
			
			foreach($departments as $department){
				
				$image_url = wp_get_attachment_url(get_post_thumbnail_id($department->ID)); 
				$department_url = get_post_meta( $department->ID, '_dpz_department_url', true ); 
			?>
								
				
				<a class="section" style="display:block" href="<?php echo $department_url ?>">									
					<div class="section-img" style="background-image: url(<?php echo $image_url ?>)"></div>
					<div class="section-title"><?php echo $department->post_title ?></div>
				</a>
				
			<?php
			}
			?>
	</div>
</div>

<?php 
	get_footer(); 
?>
