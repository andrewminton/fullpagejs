<?php
/*
Plugin Name: FullPageJS
Plugin URI: http://premium.wpmudev.org/
Description: Brings the fullpage.js library to WordPress 
Author: Chris Knowles
Version: 1.0
Author URI: http://twitter.com/ChrisKnowles
*/

function fullpage_template( $original_template ) {

  	if ( get_post_meta( get_the_ID(), 'fullpage_js', true ) ) {
    	return dirname(__FILE__) . '/templates/fullpage.php';
  	} else {
    	return $original_template;
  	}
  	
}

add_filter( 'template_include', 'fullpage_template' );

/*
 * Metaboxes! Code courtesy of WP Shed (http://wpshed.com/create-custom-meta-box-easy-way/)
 */
 
// Little function to return a custom field value
function fullpage_get_custom_field( $value ) {
    global $post;
 
    $custom_field = get_post_meta( $post->ID, $value, true );
    if ( !empty( $custom_field ) )
        return is_array( $custom_field ) ? stripslashes_deep( $custom_field ) : stripslashes( wp_kses_decode_entities( $custom_field ) );
 
    return false;
} 
 
// Register the Metabox
function fullpage_add_custom_meta_box() {
    add_meta_box( 'fullpage-meta-box', __( 'fullPage.js', 'fullpage' ), 'fullpage_meta_box_output', 'post', 'normal', 'high' );
    add_meta_box( 'fullpage-meta-box', __( 'fullPage.js', 'fullpage' ), 'fullpage_meta_box_output', 'page', 'normal', 'high' );
}

// Output the Metabox
function fullpage_meta_box_output( $post ) {
    // create a nonce field
    wp_nonce_field( 'my_fullpage_meta_box_nonce', 'fullpage_meta_box_nonce' ); ?>
    
    <h3><label for="fullpage_css"><?php _e( 'Custom CSS', 'fullpage' ); ?>:</label></h3>
    <textarea name="fullpage_css" id="fullpage_css" style="width: 90%; height: 100px; margin-left: 10px"><?php echo fullpage_get_custom_field( 'fullpage_css' ); ?></textarea>
    </p>

    <h3><label for="fullpage_js"><?php _e( 'Custom JS', 'fullpage' ); ?>:</label></h3>
        <textarea name="fullpage_js" id="fullpage_js" style="width: 90%; height: 100px; margin-left: 10px"><?php echo fullpage_get_custom_field( 'fullpage_js' ); ?></textarea>
    
    <?php
}

// Save the Metabox values
function fullpage_meta_box_save( $post_id ) {
    // Stop the script when doing autosave
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
 
    // Verify the nonce. If insn't there, stop the script
    if( !isset( $_POST['fullpage_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['fullpage_meta_box_nonce'], 'my_fullpage_meta_box_nonce' ) ) return;
 
    // Stop the script if the user does not have edit permissions
    if( !current_user_can( 'edit_post' ) ) return;
 
    // Save the textfield
    if( isset( $_POST['fullpage_css'] ) )
        update_post_meta( $post_id, 'fullpage_css', $_POST['fullpage_css'] );
 
    // Save the textarea
    if( isset( $_POST['fullpage_js'] ) )
        update_post_meta( $post_id, 'fullpage_js', $_POST['fullpage_js'] );
}

add_action( 'add_meta_boxes', 'fullpage_add_custom_meta_box' );
add_action( 'save_post', 'fullpage_meta_box_save' );



/*
 * Shortcodes!
 */

// Add fullpage shortcode
function fullpage_shortcode( $atts , $content = null ) {

	return '<div id="fullpage">' . do_shortcode( $content ) . '</div><!-- end #fullpage -->';

}

// Add fp_section shortcode
function fp_section_shortcode( $atts , $content = null ) {

    $a = shortcode_atts( array(
        'id' => null,
        'action' => null,
    ), $atts );
    
	return '<div id="' . $atts['id'] . '" class="section ' . $atts['action'] . '">' . do_shortcode( $content ) . '</div><!-- end .section -->';

}

// Add fp_slide shortcode
function fp_slide_shortcode( $atts , $content = null ) {

    $a = shortcode_atts( array(
        'bg' => null
    ), $atts );

    if ( $a['bg'] ) $style = 'style="background: url(' . $a['bg'] . ');"';

	return '<div class="slide" ' . $style . '>' . do_shortcode( $content ) . '</div><!-- end .slide -->';

}

// Add header shortcode
function fp_header_shortcode( $atts , $content = null ) {

	return '<div id="header">' . do_shortcode( $content ) . '</div><!-- end #header -->';

}

// Add header shortcode
function fp_footer_shortcode( $atts , $content = null ) {

	return '<div id="footer">' . do_shortcode( $content ) . '</div><!-- end #footer -->';

}

add_shortcode( 'fullpage', 'fullpage_shortcode' );
add_shortcode( 'section', 'fp_section_shortcode' );
add_shortcode( 'slide', 'fp_slide_shortcode' );
add_shortcode( 'header', 'fp_header_shortcode' );
add_shortcode( 'footer', 'fp_footer_shortcode' );
?>