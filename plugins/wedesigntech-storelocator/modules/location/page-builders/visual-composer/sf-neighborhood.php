<?php
add_action( 'vc_before_init', 'dtsl_sf_neighborhood_field_vc_map' );

function dtsl_sf_neighborhood_field_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Neighborhood', 'dtsl' ),
		"base" => "dtsl_sf_neighborhood_field",
		"icon" => "dtsl_sf_neighborhood_field",
		"category" => DTSL_PB_MODULE_SEARCHFORM_TITLE,
		"params" => array(

			// Field Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Field Type','dtsl'),
				'param_name' => 'field_type',
				'value' => array(
					esc_html__('List', 'dtsl') => '',
					esc_html__('Dropdown', 'dtsl') => 'dropdown',
				),
				'description' => esc_html__( 'Choose type of field you like to use.', 'dtsl' ),
				'std' => '',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Placeholder Text
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Placeholder Text', 'dtsl' ),
				'param_name' => 'placeholder_text',
				'description' => esc_html__( 'You can provide your own text for placeholder of this item.', 'dtsl' ),
				'dependency' => array( 'element' => 'field_type', 'value' => 'dropdown'),
				'edit_field_class' => 'vc_column vc_col-sm-6'
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
				'description' => esc_html__( 'Choose type of dropdown you like to use.', 'dtsl' ),
				'dependency' => array( 'element' => 'field_type', 'value' => 'dropdown'),
				'std' => '',
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

			// Default Item Id
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Default Item Id', 'dtsl' ),
				'param_name' => 'default_item_id',
				'description' => esc_html__( 'Set item id here, by default it will be set.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Parent Items Alone
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Parent Items Alone','dtsl'),
				'param_name' => 'show_parent_items_alone',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'description' => esc_html__( 'If you like to show parent items alone choose "True".', 'dtsl' ),
				'std' => 'false',
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Child Of
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Child Of', 'dtsl' ),
				'param_name' => 'child_of',
				'description' => esc_html__( 'If you like to show child of any parent item, provide id of your taxonomy here.', 'dtsl' ),
				'dependency' => array( 'element' => 'show_parent_items_alone', 'value' => 'false' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtsl' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

		)
	) );
}
?>