<?php
add_action( 'vc_before_init', 'dtsl_sp_features_vc_map' );

function dtsl_sp_features_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Features', 'dtsl' ),
		"base" => "dtsl_sp_features",
		"icon" => "dtsl_sp_features",
		"category" => DTSL_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display features. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','dtsl'),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Type 1', 'dtsl') => 'type1',
					esc_html__('Type 2', 'dtsl') => 'type2',
					esc_html__('Type 3', 'dtsl') => 'type3',
					esc_html__('Type 4', 'dtsl') => 'type4',
					esc_html__('Type 5', 'dtsl') => 'type5',
					esc_html__('Type 6', 'dtsl') => 'type6',
					esc_html__('Type 7', 'dtsl') => 'type7'
				),
				'description' => esc_html__( 'Choose any of the available type.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true,
				'std' => 'type1'
			),

			// Include
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Include', 'dtsl' ),
				'param_name' => 'include',
				'description' => esc_html__( 'If you like, you can include only certain items. Leave empty if you like to display all.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Columns
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Columns', 'dtsl'),
				'param_name' => 'columns',
				'value' => array(
							esc_html__('No Column', 'dtsl') => -1,
							esc_html__('I Column', 'dtsl') => 1,
							esc_html__('II Columns', 'dtsl') => 2,
							esc_html__('III Columns', 'dtsl') => 3,
							esc_html__('IV Columns', 'dtsl') => 4,
						),
				'description' => esc_html__( 'Number of columns you like to display your features.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => 4
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