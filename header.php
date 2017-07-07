<!DOCTYPE html>
	<html>	
		<head>
			<?php
				wp_head();
			?>
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta charset="utf-8">
            <meta name="description" content="dropzone-productions">
            <meta name="author" content="dropzone-productions">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

			<title><?php bloginfo('name'); ?></title>
			
			<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>">						
			<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/css/img/favicon.jpg" />
			

		</head>
		
		<body <?php body_class(); ?>>

        <!-- Site overlay -->
		<div id="site-overlay">
			<div id="nav-mobile" class="overlay">
				<?php
					$search = "";
                    if(is_home() || is_search() || is_category()) $search = '<li class="search-opener"><i class="fa fa-search"></i></li>';
					
					$options =  array(
						'echo'              => true,
						'theme_location'    => 'nav-header',
						'items_wrap'        => '<ul id="%1$s">%3$s '.$search.' </ul>', 
					    'menu_class'        => false, 
					    'menu_id'           => false,
					    'container'         => false,
					    'container_class'   => false,
					    'container_id'      => false,
					    'before'            => false,
					    'after'             => false
					);
					wp_nav_menu($options);	
				?>
			</div>


            <!-- Search field -->
            <div id="search" class="overlay">
                <div id="search-container">
                    <?php get_template_part('part-searchform') ?>

                    <!-- Categories -->
                    <div id="categories">
                        <ul>
                            <?php wp_list_categories(
                                array(
                                    'orderby'    => 'name',
                                    'title_li'  => ''
                                ) );
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
		</div>

        <!-- Navigation -->
        <div id="nav-container">
            <div class="nav-content">

				<?php get_template_part('part','logo');?>

                <div id="nav-desktop">

					<?php
					$search = "";
					if(is_home() || is_search() || is_category()){
						$search = '<li class="search-opener"><i class="fa fa-search"></i></li>';
					}

					$options =  array(
						'echo'              => true,
						'theme_location'    => 'nav-header',
						'items_wrap'        => '<ul id="%1$s">%3$s'.$search.' </ul>',
						'menu_class'        => false,
						'menu_id'           => false,
						'container'         => false,
						'container_class'   => false,
						'container_id'      => false,
						'before'            => false,
						'after'             => false
					);
					wp_nav_menu($options);
					?>
                </div>

                <div id='mobileMenu-opener'>
                    <div class='middle-bar'></div>
                </div>

            </div>
        </div>


		<?php

		// Featured Image
		if(has_post_thumbnail()){
			$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'single-page-thumbnail');
			$src = $img[0];
		}
		else{
			$src = get_header_image();
		}

		if(!is_front_page() && !is_search() && !is_category() && $src != null):?>
            <!-- Header Image -->
            <div id="header-image">
                <div class="post-shadow">
                    <div class="post-content">
                        <div class="post-title">
                            <p class="backgroundCheck"><?= get_the_title();?></p>
                        </div>
                    </div>
                </div>
                <div class="post-image background-image" style="background-image: url('<?php echo $src ?>');"></div>
            </div>
		<?php endif ?>