<?
get_header();
require_once 'php/post-bg-helper.php';
?>

<div class="content-center">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article>	
			<? the_content();?>
		</article>
		<div id="post-history">
			<? 	
				$nextPost = get_next_post();
				$prevPost = get_previous_post();

                $next_post_link = get_permalink($nextPost->ID);
                $prev_post_link = get_permalink($prevPost->ID);

			    $next_postBg = get_postBg($nextPost->ID);
			    $prev_postBg = get_postBg($prevPost->ID);
			?>		
			
			<? if(!empty( $nextPost )): ?>
                <a id="post-next" href="<?php echo $next_post_link ?>" >
                    <div class="post-history-title backgroundCheck"><?php echo $nextPost->post_title ?></div>
                    <div class="post-history-overlay"></div>
                    <div class="post-history-image <?= $next_postBg->class ?>" style="<?= $next_postBg->style?>"></div>
                </a>
            <? 	endif; ?>
            
			<? if(!empty( $prevPost )): ?>

                <a id="post-prev" href="<?php echo $prev_post_link ?>" >
                    <div class="post-history-title backgroundCheck"><?php echo $prevPost->post_title ?></div>
                    <div class="post-history-overlay"></div>
                    <div class="post-history-image <?= $prev_postBg->class ?>" style="<?= $prev_postBg->style?>"></div>
                </a>
			<? 	endif; ?>
		</div>
		<?php comments_template();?>
    <?php endwhile; endif; ?>	
</div>

<? get_footer(); ?>



