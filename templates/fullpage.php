<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Isola
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" type="text/css" href="/wp-content/plugins/fullpagejs/css/jquery.fullPage.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="/wp-content/plugins/fullpagejs/js/jquery.fullPage.min.js"></script>

<?php
	$fullpage_css = '<style>' . get_post_meta( get_the_ID(), 'fullpage_css', true ) . '</style>';

	echo $fullpage_css;

?>
</head>

<body>

<?php

if ( have_posts() ) : the_post(); 

	remove_filter('the_content', 'wpautop');
 	the_content(); 

endif; // end of the loop. 

$fullpage_js = '<script type="text/javascript">' . get_post_meta( get_the_ID(), 'fullpage_js', true ) . '</script>';
echo $fullpage_js;

?>

</body>
</html>