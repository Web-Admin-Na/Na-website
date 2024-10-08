<?php

function ub_render_advanced_heading_block( $attributes ) {
	extract( $attributes );
	$classes                  = array( 'ub_advanced_heading' );
	$ids                      = array();
	$ids[]                    = 'ub-advanced-heading-' . esc_attr($blockID);
	$block_wrapper_attributes = get_block_wrapper_attributes(
		array(
			'class' => implode( ' ', $classes ),
			'id'    => implode( ' ', $ids ),
		)
	);

	// Don't allow img and script tags for heading content.
	$cleaned_content = preg_replace( '/<img[^>]+>/i', '', $content );
	$cleaned_content = preg_replace( '/<script[^>]*?>.*?<\/script>/is', '', $cleaned_content );

	if (!in_array($level, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'])) {
		$level = 'h1';
	}

	$final_content = '<' . esc_attr($level) . ' ' . $block_wrapper_attributes . ' data-blockid="' . esc_attr($blockID) . '">' . $cleaned_content . '</' . esc_attr($level) . '>';

	return wp_kses_post( $final_content );
}

function ub_register_advanced_heading_block() {
	if ( function_exists( 'register_block_type_from_metadata' ) ) {
		require dirname( dirname( __DIR__ ) ) . '/defaults.php';
		register_block_type_from_metadata(
			dirname( dirname( dirname( __DIR__ ) ) ) . '/dist/blocks/advanced-heading',
			array(
				'attributes'      => $defaultValues['ub/advanced-heading']['attributes'],
				'render_callback' => 'ub_render_advanced_heading_block',
			)
		);
	}
}

add_action( 'init', 'ub_register_advanced_heading_block' );
