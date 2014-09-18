<?php
/**
 * The template for displaying posts that are using fullPage.js
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('../css/jquery.fullPage.css',__FILE__); ?>" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo plugins_url('../js/vendors/jquery.slimscroll.min.js',__FILE__); ?> "></script>	
	<script type="text/javascript" src="<?php echo plugins_url('../js/jquery.fullPage.min.js',__FILE__); ?>"></script>

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

$fullpage_js = get_post_meta( get_the_ID(), 'fullpage_js', true);

if ( empty( $fullpage_js ) ) {
	$fullpage_js = '$(document).ready(function() {$(\'#fullpage\').fullpage();});';
}

echo '<script type="text/javascript">' . $fullpage_js . '</script>';

?>

</body>
</html>