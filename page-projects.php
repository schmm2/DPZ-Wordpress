<?php 
/* Template Name: Projects */  
get_header();

// Get 'project' posts
$project_posts = get_posts( array(
	'post_type' => 'project',
	'posts_per_page' => -1, // Unlimited posts
	'orderby' => 'date', // Order alphabetically by name
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

        <div id='projects-bg'>
            <section id="projects" class="content-center">
                <div class="gutter-sizer"></div>

                <?php

                foreach ($project_posts as $post_index => $post):

                        $postBg = new stdClass();

                        // check for Background Image
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');

                        // set Image as Background
                        if(strlen($image[0]) > 0){
                            $postBg->style = 'background-image: url('.$image[0].')"';
                            $postBg->class = 'background-image';
                        }

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
                        <div data-project-url="<?= $post->guid ?>" class="project backgroundCheck <?= $project_visualSize ?>">
                            <div class="project-image <?= $postBg->class ?>" style="<?= $postBg->style?>"></div>
                            <div class='project-overlay'></div>
                            <div class='project-title <?php echo $project_title_class?>'><?php echo $post->post_title ?></div>
                        </div>
                <?php
                endforeach;
                ?>
            </section>
        </div>

<? get_footer(); ?>