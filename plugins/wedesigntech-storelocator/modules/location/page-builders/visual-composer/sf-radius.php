<?php
add_action( 'vc_before_init', 'dtsl_sf_radius_field_vc_map' );

function dtsl_sf_radius_field_vc_map() {

	vc_map( array(
		"name" => esc_html__( 'Radius', 'dtsl' ),
		"base" => "dtsl_sf_radius_field",
		"icon" => "dtsl_sf_radius_field",
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
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Minimum Radius
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Minimum Radius', 'dtsl' ),
				'param_name' => 'min_radius',
				'description' => esc_html__( 'Set minimum radius here.', 'dtsl' ),
				'value' => 1,
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Maximum Radius
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Maximum Radius', 'dtsl' ),
				'param_name' => 'max_radius',
				'description' => esc_html__( 'Set maximum radius here.', 'dtsl' ),
				'value' => 100,
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Default Radius
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Default Radius', 'dtsl' ),
				'param_name' => 'default_radius',
				'description' => esc_html__( 'Set default radius value to search.', 'dtsl' ),
				'value' => 20,
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
				'edit_field_class' => 'vc_column vc_col-sm-6'
			)

		)
	) );
}
?>