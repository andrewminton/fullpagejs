<?php
/*
Plugin Name: FullPageJS
Plugin URI: http://premium.wpmudev.org/
Description: Brings the fullpage.js library to WordPress 
Author: Chris Knowles
Version: 1.0
Author URI: http://twitter.com/ChrisKnowles
*/

/*
 *  Enqueue fullpage.js scripts and style
 */
function fullpage_enqueue_scripts() {

	/* only need to enqueue if a single page */
	if ( !is_admin() ) {

		// Enqueue the scripts.
		//wp_enqueue_script( 'easings',  plugins_url() . '/fullpagejs/js/vendors/jquery.easings.min.js', array('jquery'), null, true );
		//wp_enqueue_script( 'slimscroll',  plugins_url() . '/fullpagejs/js/vendors/jquery.slimscroll.min.js', array('jquery'), null, true );		
		wp_enqueue_script( 'fullpage',  plugins_url() . '/fullpagejs/js/jquery.fullPage.min.js', array('easings'), null, true );	
		//wp_enqueue_script( 'fp_init', plugins_url() . '/fullpagejs/js/fullpage_init.js', array('fullpage'), null, true);
	
		// enqueue the basic styling
		wp_enqueue_style( 'fullpage_style',  plugins_url() . '/fullpagejs/css/jquery.fullPage.css' );
	}
	
}

function fullpage_add_css() {

	$fullpage_css = '<style>' . get_post_meta( get_the_ID(), 'fullpage_css', true ) . '</style>';

	echo $fullpage_css;

}

function fullpage_add_js() {

	$fullpage_js = '<script type="text/javascript">' . get_post_meta( get_the_ID(), 'fullpage_js', true ) . '</script>';

	echo $fullpage_js;

}
 
function fullpage_template( $original_template ) {

  	if ( get_post_meta( get_the_ID(), 'fullpage_js', true ) ) {
  		return '/Users/chris/Documents/Websites/www.test.dev/wp-content/plugins/fullpagejs/templates/fullpage.php';
    	//return plugins_url('fullpagejs/templates/fullpage.php', dirname(__FILE__));
  	} else {
    	return $original_template;
  	}
  	
}

add_action( 'wp_enqueue_scripts' , 'fullpage_enqueue_scripts' );
add_action( 'wp_head' , 'fullpage_add_css' );
add_action( 'wp_footer' , 'fullpage_add_js' );
add_filter( 'template_include', 'fullpage_template' );

/*
 * Shortcodes!
 */

// Add fullpage shortcode
function fullpage_shortcode( $atts , $content = null ) {

	return '<div id="fullpage">' . do_shortcode( $content ) . '</div>';

}

// Add fp_section shortcode
function fp_section_shortcode( $atts , $content = null ) {

    $a = shortcode_atts( array(
        'id' => null,
        'action' => null,
    ), $atts );
    
	return '<div id="' . $atts['id'] . '" class="section ' . $atts['action'] . '">' . do_shortcode( $content ) . '</div>';

}

// Add fp_slide shortcode
function fp_slide_shortcode( $atts , $content = null ) {

    $a = shortcode_atts( array(
        'bg' => null
    ), $atts );

    if ( $a['bg'] ) $style = 'style="background: url(' . $a['bg'] . ');"';

	return '<div class="slide" ' . $style . '>' . do_shortcode( $content ) . '</div>';

}

// Add fullpage shortcode
function fp_imgscontainer_shortcode( $atts , $content = null ) {

	return '<div class="imgsContainer">' . do_shortcode( $content ) . '</div>';

}

// Add fullpage shortcode
function fp_box_shortcode( $atts , $content = null ) {

	return '<div class="box">' . do_shortcode( $content ) . '</div>';

}

add_shortcode( 'fullpage', 'fullpage_shortcode' );
add_shortcode( 'section', 'fp_section_shortcode' );
add_shortcode( 'slide', 'fp_slide_shortcode' );
add_shortcode( 'imgscontainer', 'fp_imgscontainer_shortcode' );
add_shortcode( 'box', 'fp_box_shortcode' );
?>