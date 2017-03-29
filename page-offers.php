<?php
/*
Template Name: Offers*/    

get_header();
require_once 'php/post-bg-helper.php';

// Get 'offer' taxonomy elements

$offers = get_terms( 'offer_cat', array(
    'orderby'    => 'count',
    'hide_empty' => 0
) );

?>

<div id='offers-bg'>
	<div class='content-center'>

<?php

if ( have_posts() ) : while ( have_posts() ) : the_post();
	the_content();
	endwhile; 
endif;

// --- Get prices from taxonomy
foreach( $offers as $offer ) {
 
    // Define the query
    $args = array(
        'post_type' => 'offer',
        'offer_cat' => $offer->slug
    );
    $query = new WP_Query( $args );
    
    if($query->have_posts()){
    
	    echo '<div class="offer_category">';
	       
	    echo'<h2>' . $offer->name . '</h2>';
	    echo '<div class="offers">';
	    
	    while ( $query->have_posts() ) : $query->the_post(); 
			
			$postBg = get_postBg(get_the_id());	
			$price  = get_post_meta( get_the_id(), '_dpz_offer_price', true );
			
			set_priceBg(get_the_id());
			?>
			
			<div class="offer">
				<div class="image <?php echo $postBg->class ?>" style="<?= $postBg->style ?>"></div>
				<div class="text-container">
					<p class="offer-title"><? the_title() ?></p>
					<p class="offer-description"><?php echo get_the_content() ?></p>
				</div>
				<div class="offer-price"><?php echo $price ?></div>
			</div>
			
		<? 
			reset_price_property();
			endwhile; 
		
		echo '</div></div>';
	
		wp_reset_postdata();	
	}
}

?>
	</div>
</div>

<?php 
get_footer();

function set_priceBg($postId){
	global $price_background_class, $price_background_style, $price_title_class, $bgColors;

	// check for Background Image
	$image = wp_get_attachment_image_src( get_post_thumbnail_id($postId), 'large');
	
	// set Image as Background
	if(strlen($image[0]) > 0){
		$price_background_style = 'style="background-image: url('.$image[0].')"';	
		$price_title_class = 'backgroundCheck';
		$price_background_class = 'background-image';
	}
	// set Background Color
	else{			
		$i = rand(0,2);
		$price_background_class= $bgColors[$i];
	}		
} 

function reset_price_property(){
	global $price_background_class, $price_background_style, $price_title_class, $bgColors;
	$price_background_class = $price_background_style = $price_title_class = '';
}

?>
