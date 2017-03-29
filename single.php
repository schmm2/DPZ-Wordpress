<? get_header(); ?>

<div class="content-center">	
	<div id="post-navigation">
		<div class="arrow-back bgBorderColor-second-hover"></div>
	</div>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article>	
			<? the_content();?>
		</article>
		<div id="post-nextprev">
			<? 	
				$nextPost = get_next_post();
				$prevPost = get_previous_post();
			?>		
			
			<? if(!empty( $nextPost )): ?>
	                <div id="post-next">
						<?php $nextthumbnail = get_the_post_thumbnail($nextPost->ID, array(100,100) ); ?>
						<?php next_post_link('%link',"$nextthumbnail  %title", TRUE); ?>
	                </div>
            <? 	endif; ?>
            
			<? if(!empty( $prevPost )): ?>
					<div id="post-prev">
						<?php $prevthumbnail = get_the_post_thumbnail($prevPost->ID, array(100,100) );?>
						<?php previous_post_link('%link',"$prevthumbnail  %title", TRUE); ?>
					</div>
			<? 	endif; ?>
		</div>
		<?php comments_template();?>
    <?php endwhile; endif; ?>	
</div>

<? get_footer(); ?>



