<?php

require_once 'php/post-bg-helper.php';

/***** Pagination *****/

add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
    return 'class="button nav-pagination"';
}

function dpz_pagination_nav() {
    global $wp_query;

	$postBg = get_postBg();

    if ( $wp_query->max_num_pages > 1 ) { ?>
        <div class='last-slide swiper-slide post'>
			<div class='post-content'>
				<div id="pageOf">
					<? $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
					<sup><?= $paged ?></sup>/<sub><?= $wp_query->max_num_pages?></sub>​
				</div>
				<nav class="pagination" role="navigation">
		            <?php previous_posts_link( '&lang; Neue Einträge' ); ?>
		            <?php next_posts_link( 'Alte Einträge &rang;' ); ?>
		        </nav>
			</div>
            <div class="post-image <?= $postBg->class ?>" style="<?= $postBg->style ?>"></div>
        </div>
<?php }
}

/**
 * Force all network uploads to reside in "wp-content/uploads", and by-pass
 * "files" URL rewrite for site-specific directories.
 * 
 * @link    http://wordpress.stackexchange.com/q/147750/1685
 * 
 * @param   array   $dirs
 * @return  array
 */
function wpse_147750_upload_dir( $dirs ) {
    $dirs['baseurl'] = network_site_url( '/wp-content/uploads' );
    $dirs['basedir'] = ABSPATH . 'wp-content/uploads';
    $dirs['path'] = $dirs['basedir'] . $dirs['subdir'];
    $dirs['url'] = $dirs['baseurl'] . $dirs['subdir'];

    return $dirs;
}
add_filter( 'upload_dir', 'wpse_147750_upload_dir' );

/***** get Host *****/
function get_Host($Address) { 
   $parseUrl = parse_url(trim($Address)); 
   return trim($parseUrl['host'] ? $parseUrl['host'] : array_shift(explode('/', $parseUrl['path'], 2))); 
} 

/***** Customize Logo *****/
function custom_loginlogo() {
	if(get_theme_mod( 'dpz_logo' ) != ''){
		echo '<style type="text/css">h1 a {
			background-image: url('.get_theme_mod( 'dpz_logo' ).') !important; 
			background-size: contain !important;
			width: auto !important;
			height: 80px !important;
			margin-bottom: 4vmax !important;
		}</style>';
	}
}
add_action('login_head', 'custom_loginlogo');


/***** Wordpress Editor *****/
add_editor_style('css/editor-style.css');  
add_editor_style('css/fonts.css');

add_filter( 'mce_buttons_2', 'fb_mce_editor_buttons' );
function fb_mce_editor_buttons( $buttons ) {

	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}


// Change Editor Font Styles
function mce_mod( $settings ) {
    $settings['block_formats'] = 'Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3';

	$style_formats = array(
		array('title' => 'Intro', 'block' => 'p', 'classes' => 'intro')
	);

	$settings['style_formats'] = json_encode( $style_formats );

    return $settings;
}
add_filter('tiny_mce_before_init', 'mce_mod');


/***** Upload Size *****/
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );


/***** Define Directory *****/

$dirName = dirname(__FILE__);
$baseName = basename(realpath($dirName));
$themeDir = get_template_directory();

/***** Search Filter *****/
function searchfilter($query) {
    if ($query->is_search && !is_admin() ) {
        $query->set('post_type',array('post'));
    }
	return $query;
}

add_filter('pre_get_posts','searchfilter');


/***** Set js global variable *****/
function global_js_vars() 
{
    $globals= 'var globals = {"ajaxurl":"'. admin_url( 'admin-ajax.php' ).'", "template_url":"'.get_template_directory_uri().'"};';
    echo "<script type='text/javascript'>\n";
    echo "/*<![CDATA[ */\n".$globals."\n/* ]]> */\n";
    echo "</script>\n";
}
add_action( 'wp_head', 'global_js_vars');;

/***** Ajax *****/

// Email
require_once ("$dirName/php/send_mail.php");
add_action("wp_ajax_nopriv_send_mail", 'send_mail');
add_action('wp_ajax_send_mail', 'send_mail');


/***** Customizer css *****/
function dpz_customizer_css() {
    ?>
    <style type="text/css">
        a {
            color: <?php echo get_theme_mod( 'dpz_link_color' ); ?> ;
        }

        /* Footer color */
        #footer{
            background-color: <?php echo get_theme_mod( 'dpz_footer_color' ); ?>;
        }

        /* button & highlight */
        .button:hover, .highlight, .button-colored, .swiper-pagination-bullet-active {
            background-color: <?php echo get_theme_mod( 'dpz_highlight_color' ); ?> !important;
            border-color: <?php echo get_theme_mod( 'dpz_highlight_color' ); ?> !important;
            color: white !important;
        }

        /* Overlay Color */
        .overlay {
            background-color: <?php echo get_theme_mod( 'dpz_overlay_color' ); ?>;
        }

    </style>
    <?php
}
add_action( 'wp_head', 'dpz_customizer_css' );

function dpz_register_theme_customizer( $wp_customize ) {
 
 	/* Colors */	
 	define( 'NO_HEADER_TEXT', true );

 	// Footer
	$wp_customize->add_setting(
		'dpz_footer_color',
		array('default'     => '#2a2d2e')
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_color',
			array(
				'label'      => __( 'Footer Color', 'dpz' ),
				'section'    => 'colors',
				'settings'   => 'dpz_footer_color'
			)
		)
	);

	// Button Color
	$wp_customize->add_setting(
		'dpz_button_color',
		array('default'     => '#dd3333')
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'button_color',
			array(
				'label'      => __( 'Button', 'dpz' ),
				'section'    => 'colors',
				'settings'   => 'dpz_button_color'
			)
		)
	);

	// Highlight Color
	$wp_customize->add_setting(
		'dpz_highlight_color',
		array('default'     => '#dd3333')
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'highlight_color',
			array(
				'label'      => __( 'Highlight', 'dpz' ),
				'section'    => 'colors',
				'settings'   => 'dpz_highlight_color'
			)
		)
	);

 	// Overlay
    $wp_customize->add_setting(
        'dpz_overlay_color',
        array('default'     => '#000000')
    );
 
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'overlay_color',
            array(
                'label'      => __( 'Overlay Color', 'dpz' ),
                'section'    => 'colors',
                'settings'   => 'dpz_overlay_color'
            )
        )
    );
    
    // Link
    $wp_customize->add_setting(
        'dpz_link_color',
        array( 'default'     => '#000000')
    );
    
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'link_color',
            array(
                'label'      => __( 'Link Color', 'dpz' ),
                'section'    => 'colors',
                'settings'   => 'dpz_link_color'
            )
        )
    );
     
    
    $wp_customize->add_setting( 'dpz_logo' ); // Add setting for logo uploader
    
    // Add control for logo uploader
    $wp_customize->add_control( 
    	new WP_Customize_Image_Control( 
	    	$wp_customize, 
	    	'logo', 
	    	array(
		        'label'    => __( 'Logo', 'dpz' ),
		        'section'  => 'title_tagline',
		        'settings' => 'dpz_logo',
			)
		)
	);
}
add_action( 'customize_register', 'dpz_register_theme_customizer' );



/***** Register Menu *****/
register_nav_menus( array(
	'nav-header' => __('Header Menu'),
	'nav-socialLinks' => __('Social Links'),
));

/***** Add support  *****/
add_theme_support( 'post-thumbnails' ); 


$args = array(
	'default-image' => get_template_directory_uri() . '/img/header-default.jpg',
);
add_theme_support( 'custom-header', $args );

// Enable support for HTML5 markup.
add_theme_support( 'html5', array(
	'comment-list',
	'search-form',
	'comment-form',
	'gallery',
	'caption',
) );


/***** Activate CSS & Js *****/

function activate_script() {
 	 	
 	    
 	wp_enqueue_script( 'backgroundcheck', get_template_directory_uri().'/js/backgroundcheck.js', array('jquery'));
 	
 	// platform detection
 	wp_enqueue_script( 'platform', get_template_directory_uri().'/js/platform.js', array('jquery')); 		 
    
    wp_enqueue_script( 'cookie', get_template_directory_uri().'/js/js.cookie.js'); 
   

	/* Bugfill */
	wp_enqueue_script( 'viewport-bugfill', get_template_directory_uri().'/js/bugfill/viewport-units-buggyfill.js');
	wp_enqueue_script( 'viewport-bugfill-hacks', get_template_directory_uri().'/js/bugfill/viewport-units-buggyfill.hacks.js'); 
	

	wp_register_style( 'font-awesome', "//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" );
	wp_enqueue_style( 'font-awesome' );


	wp_register_style( 'main', get_template_directory_uri().'/css/main.css' );
	wp_enqueue_style( 'main' );


	wp_register_style( 'contactform', get_template_directory_uri().'/css/contactform.css' );
	wp_enqueue_style( 'contactform' );


	wp_register_style( 'fonts', get_template_directory_uri().'/css/fonts.css' );
 	wp_enqueue_style( 'fonts' );	 


	if(is_page_template('page-contact.php')){
		wp_register_style( 'contact', get_template_directory_uri().'/css/contact.css' );
	    wp_enqueue_style( 'contact' );
	}

	if(is_page_template('page-projects.php')){
		wp_register_style( 'projects', get_template_directory_uri().'/css/projects.css' );
	    wp_enqueue_style( 'projects' );
	    
	    wp_enqueue_script( 'projects-js', get_template_directory_uri().'/js/projects.js', array( 'jquery'));

		wp_enqueue_script( 'isotope',  get_template_directory_uri().'/js/isotope.pkgd.min.js', array( 'jquery'));
	    wp_enqueue_script( 'packery', get_template_directory_uri().'/js/packery-mode.pkgd.min.js', array( 'jquery','isotope'));
	    
	    wp_enqueue_script( 'slimScroll', get_template_directory_uri().'/js/jquery.slimscroll.min.js', array( 'jquery'));
	    
	    wp_register_style( 'swiper', get_template_directory_uri().'/css/swiper.min.css' );
		wp_enqueue_style( 'swiper' );
		wp_enqueue_script( 'swiper-js', get_template_directory_uri().'/js/swiper.jquery.min.js', array('jquery'));
	}
	
	if(is_page_template('page-team.php')){
		wp_register_style( 'team', get_template_directory_uri().'/css/team.css' );
	    wp_enqueue_style( 'team' );
	}
	
	if(is_page_template('page-offers.php')){
		wp_enqueue_script( 'offers-js', get_template_directory_uri().'/js/offers.js', array('jquery'));

	    wp_register_style( 'offers', get_template_directory_uri().'/css/offers.css' );
	    wp_enqueue_style( 'offers' );
	}
	
	if(is_home() || is_search() ){
				
	    wp_register_style( 'news', get_template_directory_uri().'/css/news.css' );
	    wp_enqueue_style( 'news' );
	    
	    wp_enqueue_script( 'slimScroll', get_template_directory_uri().'/js/jquery.slimscroll.min.js', array( 'jquery'));
	
		// vimeo player api
		wp_enqueue_script( 'vimeo', 'https://player.vimeo.com/api/player.js', array('jquery'));
		
		// Slides
		wp_register_style( 'swiper', get_template_directory_uri().'/css/swiper.min.css' );
		wp_enqueue_style( 'swiper' );
		wp_enqueue_script( 'swiper-js', get_template_directory_uri().'/js/swiper.jquery.min.js');
		
		wp_enqueue_script( 'news', get_template_directory_uri().'/js/news.js', array('jquery'));
	}
	
	if(is_single()){
		wp_register_style( 'single', get_template_directory_uri().'/css/single.css' );
	    wp_enqueue_style( 'single' );
	    wp_enqueue_script( 'single-js', get_template_directory_uri().'/js/single.js');
	}	
	
	// Footer loaded
	if(!is_home()){
		wp_enqueue_script( 'contactForm', get_template_directory_uri().'/js/contactForm.js', array( 'jquery'));
		wp_enqueue_script( 'jsRender', get_template_directory_uri().'/js/jsrender.min.js', array( 'jquery'));
 			
 		wp_register_style( 'footer', get_template_directory_uri().'/css/footer.css' );
 		wp_enqueue_style( 'footer' );

 	}

 	
	wp_register_style( 'overlay', get_template_directory_uri().'/css/overlay.css' );
 	wp_enqueue_style( 'overlay' );
	wp_enqueue_script( 'overlay-js', get_template_directory_uri().'/js/overlay.js', array( 'jquery'));


    wp_enqueue_script( 'default', get_template_directory_uri().'/js/default.js', array('jquery', 'jquery-ui-core', 'jquery-ui-tabs', 'jquery-color'));
   
}
add_action( 'wp_enqueue_scripts', 'activate_script' );


/***** Excerpt ******/
function custom_wp_trim_excerpt($text) { // Fakes an excerpt if needed
  	global $post;
  	if ( '' == $text ) {
		$text = get_the_content('');
	    $text = apply_filters('the_content', $text);
	    $text = str_replace('\]\]\>', ']]&gt;', $text);
	    $text = strip_tags($text, '');
	    $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
	    $excerpt_length_long = 9;
	    $excerpt_length_short = 5;
	    
	    // buts the words which exceed the maximum in the last element
	    $words_long = explode(' ', $text, $excerpt_length_long + 1);
	    $words_short = explode(' ', $text, $excerpt_length_short + 1);
	    
	    // long excerpt text
	    if (count($words_long)> $excerpt_length_long) {
	      array_pop($words_long);
	      array_push($words_long, ' ...');
	      $text_long = implode(' ', $words_long);
	    }
	    
	    // short excerpt text
	    if (count($words_short)> $excerpt_length_short) {
	      array_pop($words_short);
	      array_push($words_short, ' ...');
	      $text_short = implode(' ', $words_short);
	    }
  }
  // add read more button
  $html = '<div class="excerpt-long"><p>'.$text_long.'</p></div>
  		  <div class="excerpt-short"><p>'.$text_short.'</p></div>';
  return $html;
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_wp_trim_excerpt');


/****** Custom Post Types *****/

/**
 * Register `project` post type
 */
function project_post_type() {
   
   // Labels
	$labels = array(
		'name' => _x("Projekte", "post type general name"),
		'singular_name' => _x("Projekt", "post type singular name"),
		'menu_name' => 'Projekte',
		'add_new' => _x("Neues Projekt hinzufügen", "team item"),
		'add_new_item' => __("Neues Projekt hinzufügen"),
		'edit_item' => __("Projekt bearbeiten"),
		'new_item' => __("Neues Projekt"),
		'view_item' => __("Projekt ansehen"),
		'search_items' => __("Projekt suchen"),
		'not_found' =>  __("Kein Projekt gefunden"),
		'not_found_in_trash' => __("Kein Projekt im Papierkorb gefunden"),
		'parent_item_colon' => ''
	);
	
	// Register post type
	register_post_type('project' , array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => false,
		/* icon from wordpress ressource */
		'menu_icon' => 'dashicons-screenoptions',
		'rewrite' => false,
		'supports' => array('title','thumbnail', 'comments', 'editor')
	) );
}

add_action( 'init', 'project_post_type', 0 );


/* Meta Box */

function project_visualsize_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function project_visualsize_add_meta_box() {
	add_meta_box(
		'project_visualSize',
		__( 'Project visual Size', 'Project visual Size' ),
		'project_visualsize_html',
		'project',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'project_visualsize_add_meta_box' );

function project_visualsize_html( $post) {
	wp_nonce_field( '_project_visualsize_nonce', 'project_visualsize_nonce' ); ?>

	<p>
		<label for="project_visualSize"><?php _e( 'Size', 'project_visualsize' ); ?></label><br>
		<select name="project_visualsize_value" id="project_visualSize">
			<option <?php echo (project_visualsize_get_meta( 'project_visualsize_value' ) === 'Small' ) ? 'selected' : '' ?>>Small</option>
			<option <?php echo (project_visualsize_get_meta( 'project_visualsize_value' ) === 'Medium' ) ? 'selected' : '' ?>>Medium</option>
			<option <?php echo (project_visualsize_get_meta( 'project_visualsize_value' ) === 'Huge' ) ? 'selected' : '' ?>>Huge</option>
		</select>
	</p><?php
}

function project_visualsize_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['project_visualsize_nonce'] ) || ! wp_verify_nonce( $_POST['project_visualsize_nonce'], '_project_visualsize_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post' ) ) return;

	if ( isset( $_POST['project_visualsize_value'] ) )
		update_post_meta( $post_id, 'project_visualsize_value', esc_attr( $_POST['project_visualsize_value'] ) );
}
add_action( 'save_post', 'project_visualsize_save' );


/**
 * Register `team` post type
 */
function teamMember_post_type() {
   
   // Labels
	$labels = array(
		'name' => _x("Team", "post type general name"),
		'singular_name' => _x("Team Mitglied", "post type singular name"),
		'menu_name' => 'Team',
		'add_new' => _x("Neues Mitglied hinzufügen", "team item"),
		'add_new_item' => __("Add New Member"),
		'edit_item' => __("Mitglied bearbeiten"),
		'new_item' => __("Neues Mitglied"),
		'view_item' => __("Mitglied ansehen"),
		'search_items' => __("Mitglied suchen"),
		'not_found' =>  __("Kein Mitglied gefunden"),
		'not_found_in_trash' => __("Kein Mitglied im Papierkorb gefunden"),
		'parent_item_colon' => ''
	);
	
	// Register post type
	register_post_type('teamMember' , array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => false,
		/* icon from wordpress ressource */
		'menu_icon' => 'dashicons-groups',
		'rewrite' => false,
		'supports' => array('title','thumbnail', 'editor')
	) );
}

add_action( 'init', 'teamMember_post_type', 0 );


/**
 * Register `offer` post type
 */
function offer_post_type() {
   
   // Labels
	$labels = array(
		'name' => _x("Angebot", "post type general name"),
		'singular_name' => _x("Angebot", "post type singular name"),
		'menu_name' => 'Angebote',
		'add_new' => _x("Neues Angebot hinzufügen", "team item"),
		'add_new_item' => __("Neuers Angebot hinzufügen"),
		'edit_item' => __("Angebot bearbeiten"),
		'new_item' => __("Neues Angebot hinzufügen"),
		'view_item' => __("Angebot ansehen"),
		'search_items' => __("Angebot suchen"),
		'not_found' =>  __("Kein Angebot gefunden"),
		'not_found_in_trash' => __("Kein Angebot im Papierkorb gefunden"),
		'parent_item_colon' => ''
	);
	
	// Register post type
	register_post_type('offer' , array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		/* icon from wordpress ressource */
		'menu_icon' => 'dashicons-chart-line',
		'rewrite' => false,
		'supports' => array('title','editor','thumbnail')
	) );
}
add_action( 'init', 'offer_post_type', 0 );

/**
 * Register `adress` post type
 */
function adress_post_type() {

	// Labels
	$labels = array(
		'name' => _x("Addressen", "post type general name"),
		'singular_name' => _x("Addresse", "post type singular name"),
		'menu_name' => 'Addressen',
		'add_new' => _x("Neue Addresse hinzufügen", "team item"),
		'add_new_item' => __("Neue Addresse hinzufügen"),
		'edit_item' => __("Addresse bearbeiten"),
		'new_item' => __("Neue Addresse hinzufügen"),
		'view_item' => __("Addresse ansehen"),
		'search_items' => __("Addresse suchen"),
		'not_found' =>  __("Keine Addresse gefunden"),
		'not_found_in_trash' => __("Keine Addresse im Papierkorb gefunden"),
		'parent_item_colon' => ''
	);

	// Register post type
	register_post_type('adress' , array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		/* icon from wordpress ressource */
		'menu_icon' => 'dashicons-location',
		'rewrite' => false,
		'supports' => array('title')
	) );
}
add_action( 'init', 'adress_post_type', 0 );


/********** Metaboxes **********/


if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}


/***** Post Types *****/
/**
* All posts metabox
* Tested: 17.4.2017
*/

add_action( 'cmb2_init', 'register_post_metabox' );
function register_post_metabox() {
	
	$prefix_post = '_dpz_post_';

	$cmb_post= new_cmb2_box( array(
		'id'            => $prefix_post . 'metabox',
		'title'         => __( 'Post Settings', 'cmb2' ),
		'object_types' 	=> array( 'post' ),	
	) );
	
	$cmb_post->add_field( array(
		'name' => __( 'Url', 'cmb2' ),
		'desc' => __( 'Media Url; Youtube, Soundcloud...', 'cmb2' ),
		'id'   => $prefix_post . 'url',
		'type' => 'text_url',
	) );
}



/**
* PostType 'offer' metabox
* Tested: 17.4.2017
*/

add_action( 'cmb2_init', 'register_offer_metabox' );
function register_offer_metabox() {
	
	$prefix_offer = '_dpz_offer_';

	// *** Personal

	$cmb_price= new_cmb2_box( array(
		'id'            => $prefix_offer . 'metabox',
		'title'         => __( 'Preis Angaben', 'cmb2' ),
		'object_types'  => array( 'offer') // Post type		
	) );
	
	$cmb_price->add_field( array(
		'name' => __( 'Preis', 'cmb2' ),
		'desc' => __( '', 'cmb2' ),
		'id'   => $prefix_offer . 'price',
		'type' => 'text',
		'after_field' => '',
		'before_field' => ' ',
	) );
}

/**
* PostType 'teamMember' metabox
* Tested: 17.4.2017
*/

add_action( 'cmb2_init', 'register_teamMember_metabox' );
function register_teamMember_metabox() {
	
	$prefix_teamMember = '_dpz_teamMember_';

	// *** Personal

	$cmb_teamMember= new_cmb2_box( array(
		'id'            => $prefix_teamMember . 'metabox',
		'title'         => __( 'Member Information', 'cmb2' ),
		'object_types'  => array( 'teammember') // Post type		
	) );
	
	$cmb_teamMember->add_field( array(
		'name' => __( 'Email', 'cmb2' ),
		'desc' => __( 'Email', 'cmb2' ),
		'id'   => $prefix_teamMember . 'email',
		'type' => 'text_email',
	) );
	
	$cmb_teamMember->add_field( array(
		'name' => __( 'Facebook Profile', 'cmb2' ),
		'desc' => __( 'Facebook Link', 'cmb2' ),
		'id'   => $prefix_teamMember . 'facebookUrl',
		'type' => 'text_url',
	) );
	
	$cmb_teamMember->add_field( array(
		'name' => __( 'Souncloud Profile', 'cmb2' ),
		'desc' => __( 'Soundcloud Link', 'cmb2' ),
		'id'   => $prefix_teamMember . 'soundcloudUrl',
		'type' => 'text_url',
	) );
}


/*
* Page 'contact' metabox
* Bunsiness Information
*/

add_action( 'cmb2_init', 'register_contact_metabox' );
function register_contact_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix_contact_business = '_dpz_contact_business_';
	
	// *** Business
	
	$cmb_contact_business = new_cmb2_box( array(
		'id'            => $prefix_contact_business . 'metabox',
		'title'         => __( 'Kontakt Information', 'cmb2' ),
		'object_types'  => array( 'adress'), // Post type
	) );
	
	$cmb_contact_business->add_field( array(
		'name' => __( 'Stasse', 'cmb2' ),
		'desc' => __( '', 'cmb2' ),
		'id'   => $prefix_contact_business . 'street',
		'type' => 'text_medium',
	) );
	
	$cmb_contact_business->add_field( array(
		'name' => __( 'Stadt', 'cmb2' ),
		'desc' => __( '', 'cmb2' ),
		'id'   => $prefix_contact_business . 'city',
		'type' => 'text_medium',
	) );
	
	$cmb_contact_business->add_field( array(
		'name' => __( 'Telefon', 'cmb2' ),
		'desc' => __( '', 'cmb2' ),
		'id'   => $prefix_contact_business . 'phone',
		'type' => 'text_medium',
	) );
	
	$cmb_contact_business->add_field( array(
		'name' => __( 'E-Mail', 'cmb2' ),
		'desc' => __( '', 'cmb2' ),
		'id'   => $prefix_contact_business . 'email',
		'type' => 'text_email',
	) );	
}

/***** Page Templates *****/

/*
* Page 'contact' metabox
* Map
* Disabled yet
*/

/*
add_action( 'cmb2_init', 'register_contact_map_metabox' );
function register_contact_map_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix_contact_map = '_dpz_contact_map_';
	
	// *** Business
	
	$cmb_contact_map = new_cmb2_box( array(
		'id'            => $prefix_contact_map. 'metabox',
		'title'         => __( 'Map Information', 'cmb2' ),
		'object_types'  => array( 'page'), // Post type
		'show_on' 		=> array( 'key' => 'page-template', 'value' => 'page-contact.php' ),
	) );
		
	$cmb_contact_map->add_field( array(
		'name' => __( 'Longitude', 'cmb2' ),
		'desc' => __( 'Longitude Location of your Business', 'cmb2' ),
		'id'   => $prefix_contact_map . 'longitude',
		'type' => 'text_medium',
	) );
	$cmb_contact_map->add_field( array(
		'name' => __( 'Latitude', 'cmb2' ),
		'desc' => __( 'Latitude Location of your Business', 'cmb2' ),
		'id'   => $prefix_contact_map . 'latitude',
		'type' => 'text_medium',
	) );
}*/

/***** Taxonomies *****/

function add_offer_taxonomy_to_post(){

    //set the name of the taxonomy
    $taxonomy = 'offer_category';
    //set the post types for the taxonomy
    $object_type = 'offer';

    //populate our array of names for our taxonomy
    $labels = array(
        'name'               => 'Angebot Kategorie',
        'singular_name'      => 'Angebot',
        'search_items'       => 'Angebot  suchen',
        'all_items'          => 'Alle Angebote',
        'parent_item'        => 'Parent Member',
        'parent_item_colon'  => 'Parent Member:',
        'update_item'        => 'Update Angebot',
        'edit_item'          => 'Edit Angebot',
        'add_new_item'       => 'Neues Angebot',
        'new_item_name'      => 'Neues Angebot',
        'menu_name'          => 'Angebot Kategorie'
    );

    //define arguments to be used
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_ui'           => true,
        'how_in_nav_menus'  => true,
        'public'            => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'offer')
    );

    //call the register_taxonomy function
    register_taxonomy($taxonomy, $object_type, $args);
}
add_action('init','add_offer_taxonomy_to_post', 0);



// hide the link text
class dpz_socialLink_walker_nav_menu extends Walker_Nav_Menu {
	  
	// add main/sub classes to li's and links
	function start_el( &$output, $item, $depth, $args ) {
	    global $wp_query;
	    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
	  
	    // depth dependent classes
	    $depth_classes = array(
	        ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
	        ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
	        ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
	        'menu-item-depth-' . $depth
	    );
	    $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
	  
	    // passed classes
	    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
	    $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
	  
	    // build html
	    $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
	  
	    // link attributes
	    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
	    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
	    // set bgColor-main-bright-hover
	    $attributes .= ' class="menu-link button ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
	  
		// hide link text
	    $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s</a>%5$s',
	        $args->before,
	        $attributes,
	        $args->link_before,
	        $args->link_after,
	        $args->after
	    );
	  
	    // build html
	    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

function youtube_id_from_url($url) {
    $pattern = 
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
    $result = preg_match($pattern, $url, $matches);
    if (false !== $result) {
        return $matches[1];
    }
    return false;
}

/***** Utility *****/
function brightenRGB($rgb) {
	$rgbValues = split_rgb($rgb);

	for($i = 0; $i < 3; $i++){
		// make it brighter
		$rgbValues[$i] += 40;

		if($rgbValues[$i] > 255){
			$rgbValues[$i] = 255;
		}
	}
	return "rgb(".join(',',$rgbValues).")";
}

function darkenRGB($rgb) {
	$rgbValues = split_rgb($rgb);

	for($i = 0; $i < 3; $i++){

		// make it brighter
		$rgbValues[$i] -= 30;

		if($rgbValues[$i] < 0){
			$rgbValues[$i] = 0;
		}
	}
	return "rgb(".join(',',$rgbValues).")";
}

function split_rgb($rgb){
	// extract rgb values
	$rgbValues[0] = hexdec(substr($rgb, 1,2));
	$rgbValues[1] = hexdec(substr($rgb, 3,2));
	$rgbValues[2] = hexdec(substr($rgb, 5,2));

	return $rgbValues;
}