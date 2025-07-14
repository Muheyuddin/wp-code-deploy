<?php
add_action( 'vc_before_init', 'dtdr_packages_listing_vc_map' );

function dtdr_packages_listing_vc_map() {

	$seller_singular_label = apply_filters( 'seller_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Packages Listing', 'dtdr' ),
		"base" => "dtdr_packages_listing",
		"icon" => "dtdr_packages_listing",
		"category" => DTDR_PB_MODULE_DEFAULT_TITLE,
		"params" => array(

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','dtdr'),
				'param_name' => 'type',
				'value' => array(
					esc_html__( 'Type 1', 'dtdr' ) => 'type1',
					esc_html__( 'Type 2', 'dtdr' ) => 'type2',
					esc_html__( 'Type 3', 'dtdr' ) => 'type3'
				),
				'description' => esc_html__('Choose type of layout you like to display.', 'dtdr'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Post Per Page
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Post Per Page', 'dtdr' ),
				'param_name' => 'post_per_page',
				'description' => esc_html__( 'Number of posts to show.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Columns
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Columns', 'dtdr'),
				'param_name' => 'columns',
				'value' => array(
							esc_html__('I Column', 'dtdr') => 1 ,
							esc_html__('II Columns', 'dtdr') => 2 ,
							esc_html__('III Columns', 'dtdr') => 3,
						),
				'description' => esc_html__( 'Number of columns you like to display your packages.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'dependency' => array( 'element' => 'type', 'value' => 'type1'),
				'std' => 1
			),

			// Apply Isotope
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Apply Isotope','dtdr'),
				'param_name' => 'apply_isotope',
				'value' => array(
					esc_html__('False', 'dtdr') => 'false',
					esc_html__('True', 'dtdr') => 'true',
				),
				'description' => esc_html__( 'If you like to apply isotope for your packages listing, choose "True".', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => ''
			),

			// Package Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Package Type','dtdr'),
				'param_name' => 'package_type',
				'value' => array(
					esc_html__('All', 'dtdr') => '',
					esc_html__('Buyer', 'dtdr') => 'buyer',
					esc_html__('Seller', 'dtdr') => 'seller',
				),
				'description' => esc_html__( 'If you wish you can display packages based on its type.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => ''
			),

			// Package Item Ids
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Package Item Ids', 'dtdr'),
				'param_name' => 'package_item_ids',
				'value' => '',
				'description' => esc_html__( 'Enter package item ids separated by commas.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => ''
			),

			// Excerpt Length
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Excerpt Length', 'dtdr' ),
				'param_name' => 'excerpt_length',
				'description' => esc_html__( 'Provide excerpt length here.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => 20
			),

			// Show Featured Image
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Featured Image','dtdr'),
				'param_name' => 'show_featured_image',
				'value' => array(
					esc_html__('False', 'dtdr') => 'false',
					esc_html__('True', 'dtdr') => 'true',
				),
				'description' => esc_html__('Show featured image along with your items.', 'dtdr'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'dependency' => array( 'element' => 'type', 'value' => 'type1'),
				'std' => 'true'
			),

			// Apply Equal Height
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Apply Equal Height','dtdr'),
				'param_name' => 'apply_equal_height',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
				'description' => esc_html__('Apply equal height for you items.', 'dtdr'),
				'std' => 'false',
				'dependency' => array( 
					'element' => 'type', 'value' =>'type1' 
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Class
			array (
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtdr' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),


			// Carousel Options

			// Enable Carousel
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable Carousel','dtdr'),
				'param_name' => 'enable_carousel',
				'value' => array(
							esc_html__('False','dtdr') => '',
							esc_html__('True','dtdr') => 'true',
						),
				'description' => esc_html__( 'If you wish you can enable carousel for your item listings.', 'dtdr' ),
				'group' => 'Carousel',
				'dependency' => array( 'element' => 'apply_isotope', 'value' => 'false'),
				'std' => ''
			),

			// Effect
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Effect', 'dtdr'),
				'param_name' => 'carousel_effect',
				'value' => array(
							esc_html__('Default', 'dtdr') => '',
							esc_html__('Fade', 'dtdr') => 'fade',
						),
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'dtdr' ),
				'group' => 'Carousel',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
				'std' => ''
			),

			// Auto Play
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Auto Play', 'dtdr'),
				'param_name' => 'carousel_autoplay',
				'description' => esc_html__( 'Delay between transitions ( in ms ). Leave empty if you don\'t want to auto play.', 'dtdr' ),
				'group' => 'Carousel',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
			),

			// Slides Per View
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Slides Per View','dtdr'),
				'param_name' => 'carousel_slidesperview',
				'value' => array(
							1 => 1,
							2 => 2,
							3 => 3
						),
				'description' => esc_html__( 'Number slides of to show in view port.  2,3 options applicable only for "Type 1" design.', 'dtdr' ),
				'group' => 'Carousel',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
				'std' => 2
			),

			// Enable loop mode
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable Loop Mode','dtdr'),
				'param_name' => 'carousel_loopmode',
				'value' => array(
					esc_html__('False','dtdr') => 'false',
					esc_html__('True','dtdr') => 'true',
				),
				'description' => esc_html__( 'If you wish you can enable continous loop mode for your carousel.', 'dtdr' ),
				'group' => 'Carousel',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
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
				'group' => 'Carousel',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
				'std' => ''
			),

			// Enable Bullet Pagination
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable Bullet Pagination', 'dtdr'),
				'param_name' => 'carousel_bulletpagination',
				'value' => array(
					esc_html__('False', 'dtdr') => 'false',
					esc_html__('True', 'dtdr') => 'true',
				),
				'description' => esc_html__( 'To enable bullet pagination.', 'dtdr' ),
				'group' => 'Carousel',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
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
				'group' => 'Carousel',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
				'std' => ''
			),

			// Space Between Sliders
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Space Between Sliders','dtdr'),
				'param_name' => 'carousel_spacebetween',
				'description' => esc_html__( 'Space between sliders can be given here.', 'dtdr' ),
				'group' => 'Carousel',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
				'std' => 20
			),

		)
	) );
}
?>