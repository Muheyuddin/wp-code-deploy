<?php
add_action( 'vc_before_init', 'dtsl_sp_social_links_vc_map' );

function dtsl_sp_social_links_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
	$seller_singular_label = apply_filters( 'dt_sl_seller_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Social Links', 'dtsl' ),
		"base" => "dtsl_sp_social_links",
		"icon" => "dtsl_sp_social_links",
		"category" => DTSL_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display social links. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Social Links
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Social Links', 'dtsl'),
				'description' => esc_html__('Social Links that you like to display.', 'dtsl'),
				'param_name' => 'social_links',
				'value' => array(
					sprintf( esc_html__('%1$s', 'dtsl'), $dt_sl_listing_singular_label ) => 'list',
					sprintf( esc_html__('%1$s', 'dtsl'), $seller_singular_label ) => 'seller',
				),
				'std' => 'list',
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','dtsl'),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Default', 'dtsl') => '',
					esc_html__('Type 1', 'dtsl') => 'type1',
					esc_html__('Type 2', 'dtsl') => 'type2',
					esc_html__('Type 3', 'dtsl') => 'type3',
					esc_html__('Type 4', 'dtsl') => 'type4',
					esc_html__('Type 5', 'dtsl') => 'type5',
					esc_html__('Type 6', 'dtsl') => 'type6',
					esc_html__('Type 7', 'dtsl') => 'type7',
					esc_html__('Type 8', 'dtsl') => 'type8'
				),
				'description' => esc_html__( 'Choose any of the available type.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true,
				'std' => ''
			),

			// Class
			array(
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