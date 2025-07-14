<?php
add_action( 'vc_before_init', 'dtsl_sp_featured_image_vc_map' );

function dtsl_sp_featured_image_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Featured Image', 'dtsl' ),
		"base" => "dtsl_sp_featured_image",
		"icon" => "dtsl_sp_featured_image",
		"category" => DTSL_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display featured image. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Thumbnail Sizes
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Thumbnail Sizes','dtsl'),
				'param_name' => 'image_size',
				'value' => array(
					esc_html__('Thumbnail', 'dtsl') => 'thumbnail',
					esc_html__('Medium', 'dtsl') => 'medium',
					esc_html__('Medium Large', 'dtsl') => 'medium_large',
					esc_html__('Large', 'dtsl') => 'large',
					esc_html__('Full', 'dtsl') => 'full',
				),
				'description' => esc_html__( 'Choose any of the above image sizes.', 'dtsl' ),
				'std' => 'full',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Class
			array (
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtsl' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			)

		)
	) );
}
?>