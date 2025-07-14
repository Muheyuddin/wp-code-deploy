<?php
add_action( 'vc_before_init', 'dtsl_sf_nearby_field_vc_map' );

function dtsl_sf_nearby_field_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Near By', 'dtsl' ),
		"base" => "dtsl_sf_nearby_field",
		"icon" => "dtsl_sf_nearby_field",
		"category" => DTSL_PB_MODULE_SEARCHFORM_TITLE,
		"params" => array(

			// Ajax Load
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Ajax Load', 'dtsl'),
				'description' => esc_html__('If you want to display the output in same page choose "True" here.', 'dtsl'),
				'param_name' => 'ajax_load',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
			),

			// Maximum Radius
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Maximum Radius', 'dtsl' ),
				'param_name' => 'max_radius',
				'description' => esc_html__( 'Set maximum radius to search for.', 'dtsl' ),
				'value' => 100,
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Radius Unit
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Radius Unit', 'dtsl'),
				'description' => esc_html__('You can specify radius unit that you like to calculate distance.', 'dtsl'),
				'param_name' => 'radius_unit',
				'value' => array(
					esc_html__( 'mi', 'dtsl' ) => 'mi',
					esc_html__( 'km', 'dtsl' ) => 'km',
					esc_html__( 'm', 'dtsl' ) => 'm',
				),
				'std' => 'km',
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtsl' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
			),

		)
	) );
}
?>