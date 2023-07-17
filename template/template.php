<?php
/**
 * Template content
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get ID
$get_id = get_post_meta( get_the_ID(), 'oceanwp_mw_elementor_templates', true );

$template = '';

if ( class_exists( 'Ocean_Extra' ) && function_exists( 'oe_get_meta' ) ) {
	$template = oe_get_meta( '_omw_meta_mw_template' );
} else {
	$template = get_post_meta( get_the_ID(), 'oceanwp_mw_template', true );
}

if ( ! empty( $template ) ) {
	$get_id = $template;
}

// Check if page is Elementor page
$elementor  = get_post_meta( $get_id, '_elementor_edit_mode', true );

$get_content = '';

// Get content
if ( ! empty( $get_id ) ) {

	$template_id = get_post( $get_id );

	if ( $template_id && ! is_wp_error( $template_id ) ) {
		$get_content = $template_id->post_content;
	}

}

// If Elementor
if ( class_exists( 'Elementor\Plugin' ) && $elementor ) {

	echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $get_id );

}

// If Beaver Builder
else if ( class_exists( 'FLBuilder' ) && ! empty( $get_id ) ) {

	echo do_shortcode( '[fl_builder_insert_layout id="' . $get_id . '"]' );

}

else if ( class_exists( 'SiteOrigin_Panels' ) && get_post_meta( $get_id, 'panels_data', true ) ) {

	echo SiteOrigin_Panels::renderer()->render( $get_id );

}

// Else
else {

	// If Gutenberg.
	if ( ocean_is_block_template( $get_id ) ) {
		$get_content = apply_filters( 'ocean_modal_window_template_content', do_blocks( $get_content ) );
	}

	// Display template content.
	echo do_shortcode( $get_content );

}
