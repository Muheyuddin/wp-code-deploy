<?php
add_action( 'vc_before_init', 'dtdr_sp_content_vc_map' );

function dtdr_sp_content_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );

	vc_map( array(
		"name" => esc_html__( 'Content', 'dtdr' ),
		"base" => "dtdr_sp_content",
		"icon" => "dtdr_sp_content",
		"category" => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtdr'), $listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display content. No need to provide ID if it is used in %1$s single page.', 'dtdr'), strtolower($listing_singular_label) ),
				'admin_label' => true,
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type', 'dtdr'),
				'description' => esc_html__('Choose type of content that you like to display.', 'dtdr'),
				'param_name' => 'type',
				'value' => array(
					esc_html__( 'Excerpt', 'dtdr' ) => 'excrpt',
					esc_html__( 'Content', 'dtdr' ) => 'content'
				),
				'std' => 'excrpt',
				'admin_label' => true,
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtdr' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			)

		)
	) );
}
?>