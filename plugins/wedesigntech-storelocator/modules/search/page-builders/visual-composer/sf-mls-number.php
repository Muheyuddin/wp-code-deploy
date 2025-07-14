<?php
add_action( 'vc_before_init', 'dtsl_sf_mls_number_field_vc_map' );

function dtsl_sf_mls_number_field_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'MLS Number', 'dtsl' ),
		"base" => "dtsl_sf_mls_number_field",
		"icon" => "dtsl_sf_mls_number_field",
		"category" => DTSL_PB_MODULE_SEARCHFORM_TITLE,
		"params" => array(

			// Placeholder Text
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Placeholder Text', 'dtsl' ),
				'param_name' => 'placeholder_text',
				'description' => esc_html__( 'You can provide your own text for placeholder of this item.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

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