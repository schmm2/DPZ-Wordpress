<!DOCTYPE html>
	<html>	
		<head>
			<?php
				wp_head();
			?>
			<title><?php bloginfo('name'); ?></title>
			
			<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>">						
			<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/css/img/favicon.jpg" />
			
			<meta http-equiv="X-UA-Compatible" content="IE=9">
		  	<meta charset="utf-8">
		  	<meta name="description" content="dropzone-productions">
		  	<meta name="author" content="dropzone-productions">	
			<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">			
		</head>
		
		<body <?php body_class(); ?>>
		
		
		<div id="site-overlay">
			<!-- Site overlay -->
			<div id="nav-mobile" class="overlay">
				<?php 
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
		
		<!-- Site Content -->
		<div id="site-content">

            <!-- get Part Header -->
        <?php
            get_template_part('part','header');
        ?>