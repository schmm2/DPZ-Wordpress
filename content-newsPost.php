<?php
$postBg = get_postBg(get_the_id());	
?>
<div class="post swiper-slide">
	<div class="post-shadow">	
		<div class="post-categories">
			<?php
				$categories = get_the_category();
				foreach($categories as $category){
					$category_link = get_category_link($category->cat_ID);
					echo '<a href="'.$category_link.'" class="bgBorderColor-second bgBorderColor-second-bright-hover categorie">'.$category->name."</a>";
				}	
			?>
		</div>
		<div class='post-content backgroundCheck'>
			<div class='post-title backgroundCheck'>
				<p><?php the_title(); ?></p>
			</div>
			<div class="post-date"></div>
			<div class='post-text'>							
				<?php the_excerpt(); ?>
				 <button data-post-url="<?= get_permalink();?>" class="button-readmore bgBorderColor-second-hover">Weiterlesen</button>
			</div>
		</div>	
	</div>
	<div class="post-image <?= $postBg->class ?>" style="<?= $postBg->style ?>"></div>	
</div>
