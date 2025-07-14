<?php
add_action( 'vc_before_init', 'dtsl_sf_features_field_vc_map' );

function dtsl_sf_features_field_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Features', 'dtsl' ),
		"base" => "dtsl_sf_features_field",
		"icon" => "dtsl_sf_features_field",
		"category" => DTSL_PB_MODULE_SEARCHFORM_TITLE,
		"params" => array(

			// Tab Id
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Tab Id', 'dtsl' ),
				'param_name' => 'tab_id',
				'description' => esc_html__( 'Provide tab id for features item that you want to use in search form. Without this tab id shortcode doesn\'t work.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Field Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Field Type', 'dtsl'),
				'description' => esc_html__('Choose field type that you like to use for this feature item.', 'dtsl'),
				'param_name' => 'field_type',
				'value' => array(
					esc_html__( 'Range', 'dtsl' ) => 'range',
					esc_html__( 'Dropdown', 'dtsl' ) => 'dropdown',
					esc_html__( 'List', 'dtsl' ) => 'list',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => 'range',
			),

			// Placeholder Text
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Placeholder Text', 'dtsl' ),
				'param_name' => 'placeholder_text',
				'description' => esc_html__( 'You can provide your own text for placeholder of this item.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'dependency' => array( 'element' => 'field_type', 'value' => 'dropdown'),
			),

			// Minimum Value
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Minimum Value', 'dtsl' ),
				'param_name' => 'min_value',
				'description' => esc_html__( 'Set minimum value range.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'value' => 1,
				'dependency' => array( 'element' => 'field_type', 'value' => 'range'),
			),

			// Maximum Value
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Maximum Value', 'dtsl' ),
				'param_name' => 'max_value',
				'description' => esc_html__( 'Set maximum value range.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'value' => 100,
				'dependency' => array( 'element' => 'field_type', 'value' => 'range'),
			),

			// Dropdown Options
			array(
				'type' => 'textarea',
				'heading' => esc_html__('Dropdown Options', 'dtsl'),
				'description' => esc_html__('Add dropdown options in comma separated values.', 'dtsl'),
				'param_name' => 'dropdownlist_options',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'dependency' => array( 'element' => 'field_type', 'value' => array ('dropdown', 'list')),
			),

			// Dropdown Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Dropdown Type','dtsl'),
				'param_name' => 'dropdown_type',
				'value' => array(
					esc_html__('Single', 'dtsl') => '',
					esc_html__('Multiple', 'dtsl') => 'multiple',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'description' => esc_html__( 'Choose type of dropdown you like to use.', 'dtsl' ),
				'dependency' => array( 'element' => 'field_type', 'value' => 'dropdown'),
				'std' => '',
			),

			// Item Unit
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Item Unit', 'dtsl' ),
				'param_name' => 'item_unit',
				'description' => esc_html__( 'You can provide item unit for your label here.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
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