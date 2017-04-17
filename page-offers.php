<?php
/*
Template Name: Offers*/    

get_header();
require_once 'php/post-bg-helper.php';

// Get 'offer' top level taxonomy elements
$offersCategory_topLevel = get_terms( array(
	'taxonomy' => 'offer_category',
	'orderby'  => 'count',
	'parent'   => 0,
	'hide_empty' => true
));

?>

<div class="content-center">
	<?php
	if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
	endwhile;
	endif;
	?>
</div>


<div id='offers-bg'>
	<div class='content-center'>

    <?php

    // ***** Category Selection Tab
    echo '<div id="category-selection-tab">';
        // Offer Selection bar
        $i = 0;
        foreach( $offersCategory_topLevel as $offerCategory) {
            if($i != 0){
               echo '<div class="separator-line"></div>';
            }
            echo '<div data-category-id="category-'.$offerCategory->term_id.'" class="category-selector">'.$offerCategory ->name."</div>";
            $i++;
        }
    echo "</div>";


    // ***** Price Overview
    foreach( $offersCategory_topLevel as $offerCategory ) {

        // get children categories
	    $offersCategory_subcategories=get_terms(
		    array(
			    'taxonomy' => 'offer_category',
                'parent' => $offerCategory->term_id,
			    'hide_empty' => true
            )
	    );
	    echo '<div class="category-container" id="category-'.$offerCategory->term_id.'">';

	    foreach( $offersCategory_subcategories as $subcategorie ) {

		    // Define the query
		    $args = array(
			    'post_type' => 'offer',
			    'offer_category' => $subcategorie->slug
		    );
		    $query = new WP_Query( $args );



		    echo '<div class="subcategorie">';
		    echo ("<h3>".$subcategorie->name."</h3>");

                echo '<div class="offers">';
                    while ( $query->have_posts() ) : $query->the_post();

                    $price  = get_post_meta( get_the_id(), '_dpz_offer_price', true );
                    ?>

                        <div class="offer">
                            <div class="text-container">
                                <p class="offer-title"><? the_title() ?></p>
                                <p class="offer-description"><?php echo get_the_content() ?></p>
                            </div>
                            <div class="offer-price"><?php echo $price ?></div>
                        </div>

                    <?php

                    endwhile;
                echo '</div>';
		    echo '</div>';
	    }
	    echo '</div>';
    }
    echo '</div>';

    ?>

	</div>
</div>

<?php 
    get_footer();
?>
