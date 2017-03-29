<?php
	
	
/***** Button *****/

// grey button
function button_grey($atts, $content = null) {
	extract( shortcode_atts( array(
    	'url' => '#'
	), $atts ) );
	return '<a href="'.$url.'" class="button-grey"><span>' . do_shortcode($content) . '</span></a>';
}
add_shortcode('button_grey', 'button_grey');

// mainColor button
function button_color($atts, $content = null) {
	extract( shortcode_atts( array(
    	'url' => '#'
	), $atts ) );
	return '<a href="'.$url.'" class="button-color"><span>' . do_shortcode($content) . '</span></a>';
}
add_shortcode('button_color', 'button_color');



/***** Activate jQuery & jQuery UI *****/

function insert_jquery(){
	wp_enqueue_script('jquery');
}
add_action('init', 'insert_jquery');

/***** Add BackgroundCheck class to Desktop Navigation *****/
function custom_nav_class($classes, $item){
        $classes[] = "backgroundCheck";
        return $classes;
}
add_filter('nav_menu_css_class' , 'custom_nav_class' , 10 , 2);

/***** Define Directory *****/

$dirName = dirname(__FILE__);
$baseName = basename(realpath($dirName));

$themeDir = get_template_directory();


/***** Page Title *****/
function filter_pagetitle($title) {
    
    global $wp_query, $post;
    
    // Standard post title
    if (isset($wp_query->post->post_title)){
        $title =  $wp_query->post->post_title;
    }  
    
    if(is_front_page()){
	    $title = get_bloginfo('description');
    }

    return "<div id='header-postTitle'><h6 class='backgroundCheck'>".$title."</h6></div>";
}
add_filter('wp_title', 'filter_pagetitle');


/***** Image sizes *****/
if ( function_exists( 'add_image_size' ) )
{ 
	add_image_size( 'related-post-thumbnail', 1280, 900, array( 'center', 'center' ) );
	add_image_size( 'single-page-thumbnail', 1920, 1080, array( 'center', 'center' ) );
	add_image_size( 'team-member-thumbnail', 1000, 1333, array( 'center', 'center' ) );
	add_image_size( 'gallery-thumbnail', 500, 500, array( 'center', 'center' ) );
}

/***** php Wordpress Timezone *****/

function wp_get_timezone_string() {
 
    // if site timezone string exists, return it
    if ( $timezone = get_option( 'timezone_string' ) )
        return $timezone;
 
    // get UTC offset, if it isn't set then return UTC
    if ( 0 === ( $utc_offset = get_option( 'gmt_offset', 0 ) ) )
        return 'UTC';
 
    // adjust UTC offset from hours to seconds
    $utc_offset *= 3600;
 
    // attempt to guess the timezone string from the UTC offset
    if ( $timezone = timezone_name_from_abbr( '', $utc_offset, 0 ) ) {
        return $timezone;
    }
 
    // last try, guess timezone string manually
    $is_dst = date( 'I' );
 
    foreach ( timezone_abbreviations_list() as $abbr ) {
        foreach ( $abbr as $city ) {
            if ( $city['dst'] == $is_dst && $city['offset'] == $utc_offset )
                return $city['timezone_id'];
        }
    }
     
    // fallback to UTC
    return 'UTC';
}
// set php to wordpress timezone
date_default_timezone_set(wp_get_timezone_string());

/***** JetPack *****/

function mytheme_jetpack_setup() {
    add_theme_support( 'infinite-scroll', array(
        'container' => 'posts',
        'footer' => false
    ));
}
add_action( 'after_setup_theme', 'mytheme_jetpack_setup' );


/***** Tilled Gallerie Size *****/
if ( ! isset( $content_width ) )
{
    $content_width = 1000;
}

// Enable support for HTML5 markup.
add_theme_support( 'html5', array(
	'comment-list',
	'search-form',
	'comment-form',
	'gallery',
	'caption',
) );
	
/***** Register Menu *****/

register_nav_menus( array(
	'header-nav' => 'Header Menu',
	'social-links' => 'Social Links',
));


/***** Add support for post images *****/
add_theme_support( 'post-thumbnails' ); 


/***** Add support for Custom Header image *****/
$args = array(
	'default-image' => get_template_directory_uri() . '/img/header_default.jpg',
);
add_theme_support( 'custom-header', $args );



/***** Get Gps coordinates *****/
function get_gpsCoord($exifCoord, $hemi) 
{
    $degrees = count($exifCoord) > 0 ? gps2Num($exifCoord[0]) : 0;
    $minutes = count($exifCoord) > 1 ? gps2Num($exifCoord[1]) : 0;
    $seconds = count($exifCoord) > 2 ? gps2Num($exifCoord[2]) : 0;
    $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;
    return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
}

/***** Calculate Gps to Number *****/
function gps2Num($coordPart) 
{
    $parts = explode('/', $coordPart);
    if (count($parts) <= 0)
        return 0;
    if (count($parts) == 1)
        return $parts[0];
    return floatval($parts[0]) / floatval($parts[1]);
}


/***** Store geo location information *****/
// Extend the wp_read_image_metadata function to import geo location information

function extend_img_meta($meta,$file,$sourceImageType) 
{
	global $themeDir;
	
	// Read exif Data from image
	$exif = @exif_read_data( $file );
	
	if (!empty($exif['GPSLatitude']) && !empty($exif['GPSLatitudeRef']))
	{
		$latitude = get_gpsCoord($exif['GPSLatitude'],trim($exif['GPSLatitudeRef']));
		$meta['latitude'] = $latitude;
		$meta['latitude_ref'] = trim($exif['GPSLatitudeRef']);
	}
	if (!empty($exif['GPSLongitude']) && !empty($exif['GPSLongitudeRef']))
	{
		$longitude = get_gpsCoord($exif['GPSLongitude'],trim($exif['GPSLongitudeRef']));
		$meta['longitude'] = $longitude;
		$meta['longitude_ref'] = trim( $exif['GPSLongitudeRef'] );
	}
	
	// Store date when picture was taken
	if (!empty($exif['DateTime'])) 
	{
        $meta['timestamp'] = strtotime($exif['DateTime']);
    }	
	
	// Get Location Information of Picture like country, city if geo information exists.
	if(!empty($longitude) && !empty($latitude))
	{
		$url = "http://maps.googleapis.com/maps/api/geocode/json?sensor=true&address=".$latitude.",".$longitude;
		$file_content = file_get_contents($url);
	    $json = json_decode($file_content, true);
	     
	    if($json['status']='OK')
	    {
	    	foreach ($json["results"] as $result) 
	    	{
		    	foreach ($result["address_components"] as $address) 
		    	{
		    		// Get Country
			    	if (in_array("country", $address["types"])) 
			    	{
				    	$meta['country'] = $address["long_name"];
				    	$meta['countryCode'] = $address["short_name"];
				    	 
				    	// Get Continent
				    	if(isset($meta['countryCode']))
				    	{   
						    $path = $themeDir."/ressource/countryCode2continent.json";
						    $countryCode2continent_json =  file_get_contents($path);
						    $countryCode2continent = json_decode($countryCode2continent_json,true);
						    
						    if(array_key_exists($meta['countryCode'], $countryCode2continent)){
						  		$meta['continent'] = $countryCode2continent[$meta['countryCode']];
					  		}	  	
					  		else{
						  		 $meta['continent'] = null;
					  		}
				  		}
			        }
			        // Get City 
			        if (in_array("locality", $address["types"])) 
			    	{
				    	$meta['city'] = $address["long_name"];
			        }
			        // Get Postal Code
			        if (in_array("postal_code", $address["types"])) 
			    	{
				    	$meta['postal_code'] = $address["long_name"];
			        }
			    }
			}	
	    }	
	}		
	return $meta;
}
add_filter('wp_read_image_metadata', 'extend_img_meta','',3);



/***** Set js global variable *****/


function global_js_vars() 
{
    $globals= 'var globals = {"ajaxurl":"'. admin_url( 'admin-ajax.php' ).'", "template_url":"'.get_template_directory_uri().'"};';
    echo "<script type='text/javascript'>\n";
    echo "/*<![CDATA[ */\n".$globals."\n/* ]]> */\n";
    echo "</script>\n";
}
add_action( 'wp_head', 'global_js_vars');


/***** Wordpress Editor *****/

add_editor_style('css/editor-style.css');  
add_editor_style('css/fonts.css'); 

// Change Editor Font Styles
function mce_mod( $init ) 
{
    $init['block_formats'] = 'Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3';
 
    return $init;
}
add_filter('tiny_mce_before_init', 'mce_mod');

/***** Activate CSS *****/

 echo get_template_directory_uri();
function activate_stylesheets() {
 
 echo get_template_directory_uri();
 
    // registers your stylesheet
    wp_register_style( 'frontpage', get_template_directory_uri().'/css/frontpage.css' );
    wp_enqueue_style( 'frontpage' );
           

   
    wp_register_style( 'blendmode-fallback', get_template_directory_uri().'/css/blendmode-fallback.css' );
    wp_enqueue_style( 'blendmode-fallback' );
   
}
add_action( 'wp_enqueue_scripts', 'activate_stylesheets' );


/***** Activate scripts *****/

function activate_scripts()
{
		// Register js files
	
	/* Bugfill */
	wp_enqueue_script( 'viewport-bugfill', get_template_directory_uri().'/js/bugfill/viewport-units-buggyfill.js');
	wp_enqueue_script( 'viewport-bugfill-hacks', get_template_directory_uri().'/js/bugfill/viewport-units-buggyfill.hacks.js'); 
	
	/* Pages */
	
	/* Functionality */
	
		// scroll animations
	wp_enqueue_script( 'skrollr', get_template_directory_uri().'/js/skrollr.js', array( 'jquery'));
	
	/* Initialization */
	
	wp_enqueue_script( 'init', get_template_directory_uri().'/js/init.js', array('jquery', 'jquery-ui-core', 'jquery-ui-tabs', 'jquery-color'),false,true);
	
}
add_action('wp_enqueue_scripts', 'activate_scripts');


/***** Trim post content on front page *****/

function travelr_wp_trim_excerpt($text) { // Fakes an excerpt if needed
  global $post;
  if ( '' == $text ) {
    $text = get_the_content('');
    $text = apply_filters('the_content', $text);
    $text = str_replace('\]\]\>', ']]&gt;', $text);
    $text = strip_tags($text, '<p><a><img></a></img>');
    $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
    $excerpt_length = 50;
    $words = explode(' ', $text, $excerpt_length + 1);
    if (count($words)> $excerpt_length) {
      array_pop($words);
      array_push($words, ' ...');
      $text = implode(' ', $words);
    }
  }
  // add read more button
  $text = $text.'<p><a href="'.get_permalink().'#main_div" class="more-link">Read more</a></p>';
  return $text;
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'travelr_wp_trim_excerpt');

?>




<?php

/***** Theme Comment Callback *****/

function travelr_comment_callback($comment, $args, $depth) {

?>

    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

    	<div id="comment-<?php comment_ID(); ?>" class='comment-element'>
  		
     		<div id="comment-header">
     			<div class="comment-avatar">
           			<!-- Get Avatar -->	          		
           			<?php echo get_avatar($comment, 40, $default_avatar ); ?>
           		</div>
           		<!-- Comment Title, Date & Time  -->
           		<div class="comment-title">
	           		<?php 
		        		$author = get_comment_author_link();
		        		$dateTime = " ".get_comment_date('j.m.y').", ".get_comment_time('G:i');
			            
		        		echo ("<h3>".$author."<i class='comment_dateTime'>".$dateTime."</i></h3>");
		       		?>	
		       	</div>
     		</div>
     		
     		
     		<div class='comment-text'> 
	        
		   	 	<!-- Comment Text  -->
		   	 	<?php comment_text() ?>
			    	
		       			       									
	    	 	<!-- Check if Comment is approved or still waiting for admin release -->
		   	 	<?php if ($comment->comment_approved == '0') : ?>  
			   		<div class="comment-approval">
			   			<i class="fa fa-info-circle"></i>
			   			<p>Your comment is awaiting approval</p>
			   		</div>
		    	<?php else: ?>  
		    		<div class="comment-reply">
		    			<?php 
			    			$args = array('reply_text'=>'<i class="fa fa-reply"></i> Reply','depth' => $depth, 'max_depth' => $args['max_depth']);
		    				comment_reply_link($args); 
		    			?>
		    		</div>
		    	<?php endif; ?>  
			 
		    	<!-- Comment edit link -->
		       	<?php if ( current_user_can('edit_post', $comment->comment_post_ID) ) {
		       		
		       		/* Edit Link */
		       		echo edit_comment_link('<i class="fa fa-pencil"></i><p>Edit</p>','<div class="comment-edit">','</div>');
		       		
		       		/* Delete Link */
		       		$url_delete = clean_url(wp_nonce_url( "/wp-admin/comment.php?action=deletecomment&p=$comment->comment_post_ID&c=$comment->comment_ID", "delete-comment_$comment->comment_ID" ));
		       		echo "<div class='comment-delete'><a href='$url_delete' class='delete:the-comment-list:comment-$comment->comment_ID delete'><i class='fa fa-trash-o'></i>Delete</a></div>";
			       	
			    } 
			    ?>
			    
     		</div>     			  			   
        </div>  
    </li>
<?php
}
?>

<?php

/***** List Categories *****/

function list_categories()
{
	global $post;
	
	$category_ids = get_all_category_ids();
	$args = array( 'title_li' => '');
	$categories = get_categories( $args );
	
	foreach ( $categories as $category ) 
	{ 
		echo '<a href="'. get_category_link( $category->term_id ) . '#main"><li class="cat-item">'. $category->name.'</li></a>'; 
	}
}


/***** show related posts *****/

function relatedPosts()
{
	$orig_post = $post;
	global $post;
	
	// Get post categories
	$categories = get_the_category($post->ID);
	// Check if post has categories
	if ($categories) 
	{
		$category_ids = array();
		foreach($categories as $category)
		{
			$category_ids[] = $category->term_id;
		}
		$args=array(
		'category__in' => $category_ids,
		'post__not_in' => array($post->ID),
		'posts_per_page'=> 4, // Number of related posts that will be displayed.
		'caller_get_posts'=>1,
		'orderby'=>'rand' // Randomize the posts
		);
	}
	$my_query = new wp_query( $args );

	if( $my_query->have_posts() ) 
	{
		echo '<div class="post-single-bg"><div id="related-posts-container" class="content-center"><h5>Keep reading</h5><div id="related-posts">';
		while( $my_query->have_posts()) 
		{
			$my_query->the_post(); ?>
			
			<a class='related-post' href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>">	
				
					<div class='related-post-thumbnail'>
						<?php the_post_thumbnail('related-post-thumbnail'); ?>	
					</div>
					<div class="related-post-title">
						<p><?php the_title(); ?></p>
					</div>
			</a>
		<? }
		echo '</div></div></div>';
	} 
	$post = $orig_post;
	wp_reset_query();
}

/***** post naviagtion *****/

function postNaviagtion()
{
	
	$prev_post = get_adjacent_post(true, '', true);
	$next_post = get_adjacent_post(true, '', false); 
		
	if (!empty( $next_post ) && !empty( $prev_post )): 
	?>
	<div id='post-navigation-bg'>
		<div id='post-navigation' class='content-center'>
		 
			 <div id='nextPost'>
			 	<?php if ( !empty( $prev_post ) ): ?>
				 	<a href="<?php echo $prev_post->guid; ?>">
				 		<img src="<?php  echo get_template_directory_uri()?>/css/img/arrow-left-white.png"></img>
				 		<p><?php echo $prev_post->post_title?></p>
			 		</a>
		 		 <?php endif; ?>
		 	</div>
			<div id='previousPost'>
				<?php if ( !empty( $next_post ) ): ?>
					
					<a href="<?php echo $next_post->guid; ?>">
						<p><?php echo $next_post->post_title?></p>
						<img src="<?php  echo get_template_directory_uri()?>/css/img/arrow-right-white.png"></img>
			 		</a>
			 		
				<?php endif; ?>
			 </div>			
		 </div>
	</div>
	<?php
	
	endif; 
}



/****** Custom Post Types *****/

/**
 * Register `team` post type
 */
function team_post_type() {
   
   // Labels
	$labels = array(
		'name' => _x("Team", "post type general name"),
		'singular_name' => _x("Team", "post type singular name"),
		'menu_name' => 'Team',
		'add_new' => _x("Add New Member", "team item"),
		'add_new_item' => __("Add New Team Member"),
		'edit_item' => __("Edit Profile"),
		'new_item' => __("New Profile"),
		'view_item' => __("View Profile"),
		'search_items' => __("Search Profiles"),
		'not_found' =>  __("No Profiles Found"),
		'not_found_in_trash' => __("No Profiles Found in Trash"),
		'parent_item_colon' => ''
	);
	
	// Register post type
	register_post_type('team' , array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => false,
		/* icon from wordpress ressource */
		'menu_icon' => 'dashicons-groups',
		'rewrite' => false,
		'supports' => array('title', 'editor')
	) );
}

add_action( 'init', 'team_post_type', 0 );

/**
 * Register `team` post type
 */
function teamSlide_post_type() {
   
   // Labels
	$labels = array(
		'name' => _x("Team Slides", "post type general name"),
		'singular_name' => _x("Team Slides", "post type singular name"),
		'menu_name' => 'Team Slides',
		'add_new' => _x("Add New Slide", "team slide item"),
		'add_new_item' => __("Add New Team Slide"),
		'edit_item' => __("Edit Slide"),
		'new_item' => __("New Slide"),
		'view_item' => __("View Slides"),
		'search_items' => __("Search Slides"),
		'not_found' =>  __("No Slide Found"),
		'not_found_in_trash' => __("No Slide Found in Trash"),
		'parent_item_colon' => ''
	);
	
	// Register post type
	register_post_type('teamSlide' , array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => false,
		/* icon from wordpress ressource */
		'menu_icon' => 'dashicons-format-gallery',
		'rewrite' => false,
		'supports' => array('title', 'thumbnail')
	) );
}

add_action( 'init', 'teamSlide_post_type', 0 );


/**
 * Register `sponsor` post type
 */
function sponsor_post_type() {
   
   // Labels
	$labels = array(
		'name' => _x("Sponsors", "post type general name"),
		'singular_name' => _x("Sponsor", "post type singular name"),
		'menu_name' => 'Sponsors',
		'add_new' => _x("Add New Sponsor", "team item"),
		'add_new_item' => __("Add New Sponsor"),
		'edit_item' => __("Edit Sponsor"),
		'new_item' => __("New Sponsor"),
		'view_item' => __("View Sponsor"),
		'search_items' => __("Search Sponsor"),
		'not_found' =>  __("No Sponsor Found"),
		'not_found_in_trash' => __("No Sponsors Found in Trash"),
		'parent_item_colon' => ''
	);
	
	// Register post type
	register_post_type('sponsor' , array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => false,
		/* icon from wordpress ressource */
		'menu_icon' => 'dashicons-star-empty',
		'rewrite' => false,
		'supports' => array('title', 'thumbnail')
	) );
}

add_action( 'init', 'sponsor_post_type', 0 );


/***** Utility *****/ 

function hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
    	$r = hexdec(substr($hex,0,1).substr($hex,0,1));
    	$g = hexdec(substr($hex,1,1).substr($hex,1,1));
    	$b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
    	$r = hexdec(substr($hex,0,2));
    	$g = hexdec(substr($hex,2,2));
    	$b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(",", $rgb); // returns the rgb values separated by commas
}



?>
