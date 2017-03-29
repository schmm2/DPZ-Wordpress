<?php 
/* Template Name: Projects */  
get_header();

require_once 'php/post-bg-helper.php';

// Get 'project' posts
$project_posts = get_posts( array(
	'post_type' => 'project',
	'posts_per_page' => -1, // Unlimited posts
	'orderby' => 'date', // Order alphabetically by name
));

?>
		
<?php  
				
if ( $project_posts ):
$firstPost = $project_posts[0];
$postBg = get_postBg($firstPost->ID);
?>

<div id="header-image" class="project" data-project-url="<?= $firstPost->guid ?>">
	<div class='post-content backgroundCheck'>	
		<div class="post-title">
			<p><?php echo get_the_title($firstPost->ID) ?></p>
		</div>
	</div>
	<div class="post-image <?= $postBg->class ?>" style="<?= $postBg->style?>" ></div>
</div>
				
<div id='projects-bg'>
	<div class="content-center">
		<div class="intro">
			<?php
			if ( have_posts() ) : while ( have_posts() ) : the_post();
				the_content();
			endwhile; 
			endif;
			?>
		</div>	
			
		<section id="projects">			
			<div class="gutter-sizer"></div>
		
			<?php 
								
			foreach ($project_posts as $post_index => $post): 
				// skipp first post
				if($post_index > 0){
					$postBg = get_postBg($post->ID);
					
					setup_postdata($post);
								
					// Visual Project size
					$meta = get_post_meta($post->ID, 'project_visualsize_value'); 
					
					switch ($meta[0]) {
					    case 'Small':
					    	$project_visualSize = 'project-small'; 
					        break;
					    case 'Medium':
					    	$project_visualSize = 'project-medium';
					        break;
					    case 'Huge':
					    	$project_visualSize = 'project-huge';
					        break;
					    default:
					    	$project_visualSize = 'project-small';
					    	break;
					}									
					?>
					<div data-project-url="<?= $post->guid ?>" class="project <?= $project_visualSize." "; echo $postBg->class ?>" style="<?= $postBg->style?>"">
						<div class='project-content backgroundCheck'>
							<div class='project-title <?php echo $project_title_class?>'><?php echo $post->post_title ?></div>
							<div class="project-text"><?php echo $post->post_content ?></div>
							<button class="bgColor-second-hover button-readMore">Read more</button>
						</div>	
					</div>
			<?php
				} 
			endforeach; 
			?>
		</section>
	</div>
</div>
<?php endif; ?>

<? get_footer(); ?>