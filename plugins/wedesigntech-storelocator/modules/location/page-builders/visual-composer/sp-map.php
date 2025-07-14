<?php
add_action( 'vc_before_init', 'dtsl_sp_map_vc_map' );

function dtsl_sp_map_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Map', 'dtsl' ),
		"base" => "dtsl_sp_map",
		"icon" => "dtsl_sp_map",
		"category" => DTSL_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display map. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Show Direction Link
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Direction Link', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show direction link.', 'dtsl'),
				'param_name' => 'show_direction_link',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Map Color
      		array(
      			'type' => 'colorpicker',
      			'heading' => esc_html__( 'Map Color', 'dtsl' ),
      			'param_name' => 'map_color',
      			'description' => esc_html__( 'Select color for your map. This will override the default map color.', 'dtsl' ),
      			'edit_field_class' => 'vc_column vc_col-sm-6'
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