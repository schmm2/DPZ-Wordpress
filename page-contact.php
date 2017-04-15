<?php

/*
Template Name: Contact*/    

get_header();
?>

<div id="contact">
    <div id="contact-text">
        <article>
            <?php
            if ( have_posts() ) : while ( have_posts() ) : the_post();
                the_content();
                endwhile;
            endif;
            ?>
        </article>
    </div>
    <div id="contact-form">
        <div>
	        <? get_template_part( 'part', 'contactForm' );	?>
        </div>
    </div>
</div>

<?php 
	get_footer(); 
?>
