<?php
add_action( 'vc_before_init', 'dtdr_sp_media_videos_vc_map' );

function dtdr_sp_media_videos_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Media - Videos', 'dtdr' ),
		"base" => "dtdr_sp_media_videos",
		"icon" => "dtdr_sp_media_videos",
		"category" => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtdr'), $listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display featured image. No need to provide ID if it is used in %1$s single page.', 'dtdr'), strtolower($listing_singular_label) ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtdr' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable popup', 'dtdr'),
				'param_name' => 'popup_mode',
				'value' => array(
					esc_html__('False', 'dtdr') => 'false',
					esc_html__('True', 'dtdr') => 'true',
				),
				'description' => esc_html__( 'If you wish you can enable popup.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => ''
			),


			/* Carousel Tab */

			// Effect
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Effect','dtdr'),
				'param_name' => 'carousel_effect',
				'value' => array(
							esc_html__('Default', 'dtdr') => '',
							esc_html__('Fade', 'dtdr') => 'fade',
						),
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
				'std' => ''
			),

			// Slides Per View
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Slides Per View', 'dtdr'),
				'param_name' => 'carousel_slidesperview',
				'value' => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
						),
				'description' => esc_html__( 'Number slides of to show in view port.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
				'std' => ''
			),

			// Enable loop mode
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable Loop Mode', 'dtdr'),
				'param_name' => 'carousel_loopmode',
				'value' => array(
					esc_html__('False', 'dtdr') => 'false',
					esc_html__('True', 'dtdr') => 'true',
				),
				'description' => esc_html__( 'If you wish you can enable continous loop mode for your carousel.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
				'std' => ''
			),

			// Enable mousewheel control
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable Mousewheel Control', 'dtdr'),
				'param_name' => 'carousel_mousewheelcontrol',
				'value' => array(
					esc_html__('False', 'dtdr') => 'false',
					esc_html__('True', 'dtdr') => 'true',
				),
				'description' => esc_html__( 'If you wish you can enable mouse wheel control for your carousel.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
				'std' => ''
			),

			// Pagination Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Pagination Type', 'dtdr'),
				'param_name' => 'carousel_paginationtype',
				'value' => array(
					esc_html__('Bullets', 'dtdr') => 'bullets',
					esc_html__('Fraction', 'dtdr') => 'fraction',
					esc_html__('Progress Bar', 'dtdr') => 'progressbar',
				),
				'description' => esc_html__( 'Choose pagination type you like to use.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
				'std' => ''
			),

			// Enable Arrow Pagination
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable Arrow Pagination', 'dtdr'),
				'param_name' => 'carousel_arrowpagination',
				'value' => array(
					esc_html__('False', 'dtdr') => 'false',
					esc_html__('True', 'dtdr') => 'true',
				),
				'description' => esc_html__( 'To enable arrow pagination.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
				'std' => ''
			),

			// Arrow Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Arrow Type', 'dtdr'),
				'param_name' => 'carousel_arrowpagination_type',
				'value' => array(
							esc_html__('Type 1', 'dtdr') => 'type1',
							esc_html__('Type 2', 'dtdr') => 'type2',
						),
				'description' => esc_html__( 'Choose arrow pagination type for your carousel.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
				'std' => ''
			),

			// Space Between Sliders
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Space Between Sliders','dtdr'),
				'param_name' => 'carousel_spacebetween',
				'description' => esc_html__( 'Space between sliders can be given here.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
			)

		)
	) );
}
?>