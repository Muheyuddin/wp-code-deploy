<?php
add_action( 'vc_before_init', 'dtdr_sf_ctype_field_vc_map' );

function dtdr_sf_ctype_field_vc_map() {

	$contracttype_plural_label = apply_filters( 'contracttype_label', 'plural' );

	vc_map( array(
		"name" => sprintf( esc_html__('%1$s', 'dtdr'), $contracttype_plural_label ),
		"base" => "dtdr_sf_ctype_field",
		"icon" => "dtdr_sf_ctype_field",
		"category" => DTDR_PB_MODULE_SEARCHFORM_TITLE,
		"params" => array(

			// Field Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Field Type','dtdr'),
				'param_name' => 'field_type',
				'value' => array(
					esc_html__('List', 'dtdr') => '',
					esc_html__('Dropdown', 'dtdr') => 'dropdown',
				),
				'description' => esc_html__( 'Choose type of field you like to use.', 'dtdr' ),
				'std' => '',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Placeholder Text
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Placeholder Text', 'dtdr' ),
				'param_name' => 'placeholder_text',
				'description' => esc_html__( 'You can provide your own text for placeholder of this item.', 'dtdr' ),
				'dependency' => array( 'element' => 'field_type', 'value' => 'dropdown'),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Dropdown Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Dropdown Type','dtdr'),
				'param_name' => 'dropdown_type',
				'value' => array(
					esc_html__('Single', 'dtdr') => '',
					esc_html__('Multiple', 'dtdr') => 'multiple',
				),
				'description' => esc_html__( 'Choose type of dropdown you like to use.', 'dtdr' ),
				'dependency' => array( 'element' => 'field_type', 'value' => 'dropdown'),
				'std' => '',
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Ajax Load
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Ajax Load', 'dtdr'),
				'description' => esc_html__('If you want to display the output in same page choose "True" here.', 'dtdr'),
				'param_name' => 'ajax_load',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Default Item Id
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Default Item Id', 'dtdr' ),
				'param_name' => 'default_item_id',
				'description' => esc_html__( 'Set item id here, by default it will be set.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Parent Items Alone
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Parent Items Alone','dtdr'),
				'param_name' => 'show_parent_items_alone',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
				'description' => esc_html__( 'If you like to show parent items alone choose "True".', 'dtdr' ),
				'std' => 'false',
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Child Of
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Child Of', 'dtdr' ),
				'param_name' => 'child_of',
				'description' => esc_html__( 'If you like to show child of any parent item, provide id of your taxonomy here.', 'dtdr' ),
				'dependency' => array( 'element' => 'show_parent_items_alone', 'value' => 'false' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtdr' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			)

		)
	) );
}
?>