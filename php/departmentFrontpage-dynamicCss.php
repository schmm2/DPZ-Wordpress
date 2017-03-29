<?php

$absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
$wp_load = $absolute_path[0] . 'wp-load.php';
require_once($wp_load);
 
header('Content-type: text/css');

// Get 'department' posts
$departments = get_posts( array(
	'post_type' => 'department',
	'posts_per_page' => -1, // Unlimited posts
	'orderby' => 'title', // Order alphabetically by name
) );

$i = 1;

foreach($departments as $department){				
	$color = get_post_meta( $department->ID, '_dpz_department_color', true );	
	echo "#section-container :nth-child($i):hover .section-img { background-color: $color} \r\n";
	$i++;
}
			

?>