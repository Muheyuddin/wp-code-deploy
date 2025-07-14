<?php
add_action( 'vc_before_init', 'dtsl_sp_media_videos_vc_map' );

function dtsl_sp_media_videos_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Media - Videos', 'dtsl' ),
		"base" => "dtsl_sp_media_videos",
		"icon" => "dtsl_sp_media_videos",
		"category" => DTSL_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display featured image. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtsl' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),


			/* Carousel Tab */

			// Effect
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Effect','dtsl'),
				'param_name' => 'carousel_effect',
				'value' => array(
							esc_html__('Default', 'dtsl') => '',
							esc_html__('Fade', 'dtsl') => 'fade',
						),
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
				'std' => ''
			),

			// Slides Per View
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Slides Per View', 'dtsl'),
				'param_name' => 'carousel_slidesperview',
				'value' => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
						),
				'description' => esc_html__( 'Number slides of to show in view port.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
				'std' => ''
			),

			// Enable loop mode
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable Loop Mode', 'dtsl'),
				'param_name' => 'carousel_loopmode',
				'value' => array(
					esc_html__('False', 'dtsl') => 'false',
					esc_html__('True', 'dtsl') => 'true',
				),
				'description' => esc_html__( 'If you wish you can enable continous loop mode for your carousel.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
				'std' => ''
			),

			// Enable mousewheel control
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable Mousewheel Control', 'dtsl'),
				'param_name' => 'carousel_mousewheelcontrol',
				'value' => array(
					esc_html__('False', 'dtsl') => 'false',
					esc_html__('True', 'dtsl') => 'true',
				),
				'description' => esc_html__( 'If you wish you can enable mouse wheel control for your carousel.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
				'std' => ''
			),

			// Pagination Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Pagination Type', 'dtsl'),
				'param_name' => 'carousel_paginationtype',
				'value' => array(
					esc_html__('Bullets', 'dtsl') => 'bullets',
					esc_html__('Fraction', 'dtsl') => 'fraction',
					esc_html__('Progress Bar', 'dtsl') => 'progressbar',
				),
				'description' => esc_html__( 'Choose pagination type you like to use.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
				'std' => ''
			),

			// Enable Arrow Pagination
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable Arrow Pagination', 'dtsl'),
				'param_name' => 'carousel_arrowpagination',
				'value' => array(
					esc_html__('False', 'dtsl') => 'false',
					esc_html__('True', 'dtsl') => 'true',
				),
				'description' => esc_html__( 'To enable arrow pagination.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
				'std' => ''
			),

			// Arrow Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Arrow Type', 'dtsl'),
				'param_name' => 'carousel_arrowpagination_type',
				'value' => array(
							esc_html__('Type 1', 'dtsl') => 'type1',
							esc_html__('Type 2', 'dtsl') => 'type2',
						),
				'description' => esc_html__( 'Choose arrow pagination type for your carousel.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
				'std' => ''
			),

			// Space Between Sliders
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Space Between Sliders','dtsl'),
				'param_name' => 'carousel_spacebetween',
				'description' => esc_html__( 'Space between sliders can be given here.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
			)

		)
	) );
}
?>