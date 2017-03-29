<?php

/*
Template Name: Contact*/    

get_header();

// get ressort contact 

// Get 'teamMember' posts
$teamMembers = get_posts( array(
	'post_type' => 'teamMember',
	'posts_per_page' => -1, // Unlimited posts
	'orderby' => 'title', // Order alphabetically by name
) );

$teamMember_ressortContactId= null;

foreach($teamMembers as $teamMember){
	$ressortContact  = get_post_meta($teamMember->ID, '_dpz_teamMember_ressortContact', true );
	// we found the ressort contact team member
	if($ressortContact == 'on'){
		$teamMember_ressortContactId= $teamMember->ID;
	}	 
}
?>


<div id='contact' class='content-center'>
   <div id='contact-text'>
    <?php
		if ( have_posts() ) : while ( have_posts() ) : the_post();
			the_content();
		endwhile; 
		endif;
	?>
    </div>
	<?php if($teamMember_ressortContactId!= null): ?>
	<div id="contact-teamMember">
		<div id='teamMember-image'>
			<?php $image_url = wp_get_attachment_url(get_post_thumbnail_id($teamMember_ressortContactId)); ?>
			<img src="<?php echo $image_url; ?>">
		</div>				
		<div id='teamMember-contactInformation'>
			<?php	
				$email  = get_post_meta( $teamMember_ressortContactId, '_dpz_teamMember_email', true ); 
				$facebookUrl = get_post_meta( $teamMember_ressortContactId, '_dpz_teamMember_facebookUrl', true );
				$soundcloudUrl = get_post_meta( $teamMember_ressortContactId, '_dpz_teamMember_soundcloudUrl', true );
				
				if($email) echo '<a class="bgColor-main-dark-hover" href="mailto:'.$email.'"><i class="fa fa-envelope-o"></i></a>';
				if($facebookUrl) echo '<a class="bgColor-main-dark-hover" href="'.$facebookUrl.'" target="_blank"><i class="fa fa-facebook"></i></a>';
				if($soundcloudUrl) echo '<a class="bgColor-main-dark-hover" href="'.$soundcloudUrl.'" target="_blank"><i class="fa fa-soundcloud"></i></a>';
			?>
		</div>
	</div>
	<?php endif; ?>
</div>
<!--<div id='map'></div>-->
<div id="contactForm-bg">
	<div class="content-center">
		<h1>Schreib uns!</h1>
		<? get_template_part( 'part', 'contactForm' );	?>
	</div>
</div>

<?php 
	get_footer(); 
?>
