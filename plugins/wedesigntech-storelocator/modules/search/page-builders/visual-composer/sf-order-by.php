<?php
add_action( 'vc_before_init', 'dtsl_sf_orderby_field_vc_map' );

function dtsl_sf_orderby_field_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Order By', 'dtsl' ),
		"base" => "dtsl_sf_orderby_field",
		"icon" => "dtsl_sf_orderby_field",
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

			// Alphabetical Order
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Alphabetical Order', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to enable alphabetical order.', 'dtsl'),
				'param_name' => 'alphabetical_order',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'std' => 'true',
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Highest Rated Order
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Highest Rated Order', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to enable highest rated order.', 'dtsl'),
				'param_name' => 'highestrated_order',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'std' => 'true',
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Most Reviewed Order
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Most Reviewed Order', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to enable most reviewed order.', 'dtsl'),
				'param_name' => 'mostreviewed_order',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'std' => 'true',
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Most Viewed Order
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Most Viewed Order', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to enable most viewed order.', 'dtsl'),
				'param_name' => 'mostviewed_order',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'std' => 'true',
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