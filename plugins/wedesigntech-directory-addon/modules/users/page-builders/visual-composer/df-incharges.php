<?php
add_action( 'vc_before_init', 'dtdr_incharges_vc_map' );

function dtdr_incharges_vc_map() {

	$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );
	$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );

	vc_map( array(
		"name" => sprintf( esc_html__('%1$s Listing', 'dtdr'), $incharge_plural_label),
		"base" => "dtdr_incharges",
		"icon" => "dtdr_incharges",
		"category" => DTDR_PB_MODULE_DEFAULT_TITLE,
		"params" => array(

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','dtdr'),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Type 1', 'dtdr') => 'type1',
					esc_html__('Type 2', 'dtdr') => 'type2',
					esc_html__('Type 3', 'dtdr') => 'type3'
				),
				'description' => esc_html__( 'Choose one of the available type to display.', 'dtdr' ),
				'std' => 'type1',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Columns
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Columns', 'dtdr'),
				'param_name' => 'columns',
				'value' => array(
							esc_html__('None', 'dtdr') => '' ,
							esc_html__('I Column', 'dtdr') => 1 ,
							esc_html__('II Columns', 'dtdr') => 2 ,
							esc_html__('III Columns', 'dtdr') => 3,
						),
				'description' => sprintf( esc_html__( 'Number of columns you like to display your %1$s.', 'dtdr' ), strtolower($incharge_plural_label) ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'type1', 'type2' )),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => ''
			),

			// Include
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Include', 'dtdr' ),
				'param_name' => 'include',
				'description' => sprintf( esc_html__( 'List of %1$s ids separated by commas.', 'dtdr' ), strtolower($incharge_singular_label) ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtdr' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

		)
	) );
}
?>