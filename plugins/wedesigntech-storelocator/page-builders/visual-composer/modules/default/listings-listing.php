<?php
add_action( 'vc_before_init', 'dtsl_listings_listing_vc_map' );

function dtsl_listings_listing_vc_map() {

	$dt_sl_listing_singular_label      = apply_filters( 'dt_sl_listing_label', 'singular' );
	$listing_plural_label        = apply_filters( 'dt_sl_listing_label', 'plural' );
	$dt_sl_contracttype_singular_label = apply_filters( 'dt_sl_contracttype_label', 'singular' );
	$contracttype_plural_label   = apply_filters( 'dt_sl_contracttype_label', 'plural' );
	$seller_singular_label       = apply_filters( 'dt_sl_seller_label', 'singular' );
	$incharge_singular_label     = apply_filters( 'dt_sl_incharge_label', 'singular' );
	$dt_sl_amenity_singular_label      = apply_filters( 'dt_sl_amenity_label', 'singular' );
	$amenity_plural_label        = apply_filters( 'dt_sl_amenity_label', 'plural' );


	$dtsl_listings_listing_vc_map_module_args = apply_filters('dtsl_listings_listing_vc_map_module_args', array ());

	// From Location Module

	$dtsl_location_city_args = $dtsl_location_neighborhoods_args = $dtsl_location_countiesstates_args = $dtsl_location_countries_args = array ();
	$dtsl_modules = dtstorelocator_instance()->active_modules;
	if(is_array($dtsl_modules) && !empty($dtsl_modules)) {
		if(in_array('location', $dtsl_modules)) {

			$countries_list = dtsl_countries_list(false);
			$countries_list = array_flip($countries_list);

			$countries_list = array(esc_html__('All', 'dtsl') => '') + $countries_list;

			// Cities Ids
			$dtsl_location_city_args = array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Cities Ids', 'dtsl'), $dt_sl_listing_singular_label ),
				'param_name' => 'cities_ids',
				'value' => '',
				'description' => esc_html__( 'Enter cities ids separated by commas.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Filters - Location',
				'std' => ''
			);

			// Neighborhoods Ids
			$dtsl_location_neighborhoods_args = array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Neighborhoods Ids', 'dtsl'), $dt_sl_listing_singular_label ),
				'param_name' => 'neighborhoods_ids',
				'value' => '',
				'description' => esc_html__( 'Enter neighborhoods ids separated by commas.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Filters - Location',
				'std' => ''
			);

			// Counties / States Ids
			$dtsl_location_countiesstates_args = array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Counties / States Ids', 'dtsl'), $dt_sl_listing_singular_label ),
				'param_name' => 'countiesstates_ids',
				'value' => '',
				'description' => esc_html__( 'Enter counties / states ids separated by commas.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Filters - Location',
				'std' => ''
			);

			// Countries
			$dtsl_location_countries_args = array(
				'type' => 'dropdown',
				'heading' => esc_html__('Countries','dtsl'),
				'param_name' => 'country_id',
				'value' => $countries_list,
				'description' => esc_html__( 'Choose countries for which you like to display items.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Filters - Location',
				'std' => ''
			);

		}
	}

	vc_map( array(
		"name" => sprintf( esc_html__('%1$s Listing', 'dtsl'), $listing_plural_label ),
		"base" => "dtsl_listings_listing",
		"icon" => "dtsl_listings_listing",
		"category" => DTSL_PB_MODULE_DEFAULT_TITLE,
		"params" => array(

						// Default Options

							// Type
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Type','dtsl'),
								'param_name' => 'type',
								'value' => array(
									esc_html__( 'Type 1', 'dtsl' )  => 'type1',
									esc_html__( 'Type 2', 'dtsl' )  => 'type2',
									esc_html__( 'Type 3', 'dtsl' )  => 'type3',
									esc_html__( 'Type 4', 'dtsl' )  => 'type4',
									esc_html__( 'Type 5', 'dtsl' )  => 'type5',
									esc_html__( 'Type 6', 'dtsl' )  => 'type6',
									esc_html__( 'Type 7', 'dtsl' )  => 'type7',
									esc_html__( 'Type 8', 'dtsl' )  => 'type8',
									esc_html__( 'Type 9', 'dtsl' )  => 'type9',
									esc_html__( 'Type 10', 'dtsl' ) => 'type10',
									esc_html__( 'Type 11', 'dtsl' ) => 'type11',
									esc_html__( 'Type 12', 'dtsl' ) => 'type12'
								),
								'description' => esc_html__('Choose type of layout you like to display.', 'dtsl'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'std' => 'type1',
							),

							// Gallery
							array (
								'type' => 'dropdown',
								'heading' => esc_html__('Gallery','dtsl'),
								'param_name' => 'gallery',
								'value' => array(
									esc_html__('Featured Image', 'dtsl') => 'featured_image',
									esc_html__('Image Gallery', 'dtsl') => 'image_gallery',
									esc_html__('Image Gallery With Featured Image', 'dtsl') => 'gallery_with_featured',
								),
								'description' => esc_html__( 'Choose how you like to display image gallery.', 'dtsl' ),
								'dependency' => array( 'element' => 'type', 'value' => array( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type7', 'type8', 'type9', 'type10' )),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'std' => 'featured_image',
							),

							// Post Per Page
							array(
								'type' => 'textfield',
								'heading' => esc_html__( 'Post Per Page', 'dtsl' ),
								'param_name' => 'post_per_page',
								'description' => esc_html__( 'Number of posts to show per page. Rest of the posts will be displayed in pagination.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Columns
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Columns', 'dtsl'),
								'param_name' => 'columns',
								'value' => array(
											esc_html__('I Column', 'dtsl') => 1 ,
											esc_html__('II Columns', 'dtsl') => 2 ,
											esc_html__('III Columns', 'dtsl') => 3,
											esc_html__('IV Columns', 'dtsl') => 4/* ,
											esc_html__('V Columns', 'dtsl') => 5,
											esc_html__('VI Columns', 'dtsl') => 6, */
										),
								'description' => esc_html__( 'Number of columns you like to display your items.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'type', 'value' => array( 'type1', 'type2', 'type4', 'type6', 'type8', 'type10')),
								'std' => 1
							),

							// Apply Isotope
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Apply Isotope','dtsl'),
								'param_name' => 'apply_isotope',
								'value' => array(
									esc_html__( 'False', 'dtsl' ) => 'false',
									esc_html__( 'True', 'dtsl' ) => 'true',
								),
								'std' => 'true',
								'description' => esc_html__('Choose true if you like to apply isotope for your items.', 'dtsl'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Isotope Filter
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Isotope Filter','dtsl'),
								'param_name' => 'isotope_filter',
								'value' => array(
									esc_html__( 'None', 'dtsl' ) => '',
									esc_html__( 'Category', 'dtsl' ) => 'category',
									sprintf( esc_html__('%1$s', 'dtsl'), $dt_sl_contracttype_singular_label ) => 'contracttype',
								),
								'std' => '',
								'description' => esc_html__('Choose isotope filter you like to use.', 'dtsl'),
								'dependency' => array( 'element' => 'apply_isotope', 'value' =>'true' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Apply Child Of
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Apply Child Of','dtsl'),
								'param_name' => 'apply_child_of',
								'value' => array(
									esc_html__( 'False', 'dtsl' ) => 'false',
									esc_html__( 'True', 'dtsl' ) => 'true',
								),
								'std' => 'false',
								'description' => sprintf( esc_html__('If you wish to apply child of specified categories or %1$s in filters, choose "True". If no categories or %1$s specified in "Filter Options" this option won\'t work.', 'dtsl'), strtolower($contracttype_plural_label) ),
								'dependency' => array( 'element' => 'apply_isotope', 'value' =>'true' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Featured Items
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Featured Items','dtsl'),
								'param_name' => 'featured_items',
								'value' => array(
									esc_html__( 'False', 'dtsl' ) => 'false',
									esc_html__( 'True', 'dtsl' ) => 'true',
								),
								'description' => esc_html__('Choose true if you like to display featured items.', 'dtsl'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Excerpt Length
							array(
								'type' => 'textfield',
								'heading' => esc_html__( 'Excerpt Length', 'dtsl' ),
								'param_name' => 'excerpt_length',
								'description' => esc_html__( 'Provide excerpt length here.', 'dtsl' ),
								'dependency' => array( 'element' => 'type', 'value' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type7', 'type8', 'type9', 'type10' )),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'std' => 20
							),

							// Features Image or Icon
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Features Image or Icon','dtsl'),
								'param_name' => 'features_image_or_icon',
								'value' => array(
									esc_html__( 'None', 'dtsl' ) => '',
									esc_html__( 'Image', 'dtsl' ) => 'image',
									esc_html__( 'Icon', 'dtsl' ) => 'icon'
								),
								'description' => esc_html__('Choose any of the option available to display features.', 'dtsl'),
								'dependency' => array( 'element' => 'type', 'value' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type8', 'type9' )),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'std' => '',
							),

							// Features Include
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Features Include','dtsl'),
								'param_name' => 'features_include',
								'description' => esc_html__('Give features id separated by comma. Only 4 maximum number of features allowed.', 'dtsl'),
								'std' => '',
								'dependency' => array( 'element' => 'type', 'value' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type8', 'type9' )),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// No. Of Categories to Display
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('No. Of Categories to Display', 'dtsl'),
								'param_name' => 'no_of_cat_to_display',
								'value' => array(
									0  => 0,
									1  => 1,
									2  => 2,
									3  => 3,
									4  => 4,
									5  => 5
								),
								'description' => esc_html__( 'Number of categories you like to display on your items.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'std' => 2
							),

							// Apply Category Toggle
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Apply Category Toggle','dtsl'),
								'param_name' => 'apply_category_toggle',
								'value' => array(
									esc_html__( 'False', 'dtsl' ) => 'false',
									esc_html__( 'True', 'dtsl' ) => 'true',
								),
								'description' => esc_html__('Apply category toggle for you items list.', 'dtsl'),
								'std' => 'false',
								'dependency' => array( 'element' => 'apply_isotope', 'value' =>'false' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Category Toggle Type
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Category Toggle Type','dtsl'),
								'param_name' => 'category_toggle_type',
								'value' => array(
									esc_html__( 'Type 1', 'dtsl' )  => 'type1',
									esc_html__( 'Type 2', 'dtsl' )  => 'type2',
									esc_html__( 'Type 3', 'dtsl' )  => 'type3',
									esc_html__( 'Type 4', 'dtsl' )  => 'type4',
									esc_html__( 'Type 5', 'dtsl' )  => 'type5'
								),
								'description' => esc_html__('Choose category toggle type for you items list.', 'dtsl'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'apply_category_toggle', 'value' =>'false' ),
								'std' => 'type1',
							),

							// Apply Equal Height
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Apply Equal Height','dtsl'),
								'param_name' => 'apply_equal_height',
								'value' => array(
									esc_html__( 'False', 'dtsl' ) => 'false',
									esc_html__( 'True', 'dtsl' ) => 'true',
								),
								'description' => esc_html__('Apply equal height for you items.', 'dtsl'),
								'std' => 'false',
								'dependency' => array( 'element' => 'apply_isotope', 'value' =>'false' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Apply Custom Height
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Apply Custom Height','dtsl'),
								'param_name' => 'apply_custom_height',
								'value' => array(
									esc_html__( 'False', 'dtsl' ) => 'false',
									esc_html__( 'True', 'dtsl' ) => 'true',
								),
								'description' => esc_html__('Apply custom height for your entire section.', 'dtsl'),
								'std' => 'false',
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Height
							array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Height', 'dtsl' ),
								'param_name' => 'vc_height',
								'description' => esc_html__( 'Provide height for your section in "px" here.', 'dtsl' ),
								'dependency' => array( 'element' => 'apply_custom_height', 'value' =>'true' ),
								'edit_field_class' => 'vc_column vc_col-sm-6'
							),

							// Sidebar Widget
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Sidebar Widget','dtsl'),
								'param_name' => 'sidebar_widget',
								'value' => array(
									esc_html__( 'False', 'dtsl' ) => 'false',
									esc_html__( 'True', 'dtsl' ) => 'true',
								),
								'description' => esc_html__('If you wish to show these items in sidebar set this to "True". This options is not applicable for "Type 3", "Type 5" and "Type 7"', 'dtsl'),
								'std' => 'false',
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Class
							array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Class', 'dtsl' ),
								'param_name' => 'class',
								'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

						// Module Options

							$dtsl_listings_listing_vc_map_module_args,

						// Filter Location Options

							$dtsl_location_city_args,
							$dtsl_location_neighborhoods_args,
							$dtsl_location_countiesstates_args,
							$dtsl_location_countries_args,

						// Filter Options

							// Listing Item Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Item Ids', 'dtsl'), $dt_sl_listing_singular_label ),
								'param_name' => 'list_item_ids',
								'value' => '',
								'description' => sprintf( esc_html__( 'Enter %1$s item ids separated by commas.', 'dtsl' ), $dt_sl_listing_singular_label ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Category Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Category Ids', 'dtsl'), $dt_sl_listing_singular_label ),
								'param_name' => 'category_ids',
								'value' => '',
								'description' => esc_html__( 'Enter category ids separated by commas.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Contract Types Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $contracttype_plural_label ),
								'param_name' => 'contracttypes_ids',
								'value' => '',
								'description' => sprintf( esc_html__('Enter %1$s ids separated by commas', 'dtsl'), $contracttype_plural_label ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Tag Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $amenity_plural_label ),
								'param_name' => 'tag_ids',
								'value' => '',
								'description' => sprintf( esc_html__('Enter %1$s ids separated by commas', 'dtsl'), $amenity_plural_label ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Seller Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s %2$s Ids', 'dtsl'), $dt_sl_listing_singular_label, $seller_singular_label ),
								'param_name' => 'seller_ids',
								'value' => '',
								'description' => sprintf( esc_html__('Enter %1$s ids separated by commas.', 'dtsl'), strtolower($seller_singular_label) ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Incharge Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s %2$s Ids', 'dtsl'), $dt_sl_listing_singular_label, $incharge_singular_label ),
								'param_name' => 'incharge_ids',
								'value' => '',
								'description' => sprintf( esc_html__('Enter %1$s ids separated by commas.', 'dtsl'), strtolower($incharge_singular_label) ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

						// Carousel Options

							// Enable Carousel
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Enable Carousel','dtsl'),
								'param_name' => 'enable_carousel',
								'value' => array(
											esc_html__('False','dtsl') => '',
											esc_html__('True','dtsl') => 'true',
										),
								'description' => esc_html__( 'If you wish you can enable carousel for your item listings. Carousel won\'t work along with "Isotope" & "Equal Height" option.', 'dtsl' ),
								'group' => 'Carousel',
								'dependency' => array( 'element' => 'apply_isotope', 'value' => 'false'),
								'std' => ''
							),

							// Effect
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Effect', 'dtsl'),
								'param_name' => 'carousel_effect',
								'value' => array(
											esc_html__('Default', 'dtsl') => '',
											esc_html__('Fade', 'dtsl') => 'fade',
										),
								'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'dtsl' ),
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
								'std' => ''
							),

							// Auto Play
							array(
								'type' => 'textfield',
								'heading' => esc_html__('Auto Play', 'dtsl'),
								'param_name' => 'carousel_autoplay',
								'description' => esc_html__( 'Delay between transitions ( in ms ). Leave empty if you don\'t want to auto play.', 'dtsl' ),
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
							),

							// Slides Per View
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Slides Per View','dtsl'),
								'param_name' => 'carousel_slidesperview',
								'value' => array(
											1 => 1,
											2 => 2,
											3 => 3,
											4 => 4,
										),
								'description' => esc_html__( 'Number slides of to show in view port. 2,3,4 options not applicable for "type 3", "type 5", "type 7" and "type9". If "Sidebar Widget" is set to "True", than "Slides Per View" will be set to "1".', 'dtsl' ),
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
								'std' => 2
							),

							// Enable loop mode
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Enable Loop Mode','dtsl'),
								'param_name' => 'carousel_loopmode',
								'value' => array(
									esc_html__('False','dtsl') => 'false',
									esc_html__('True','dtsl') => 'true',
								),
								'description' => esc_html__( 'If you wish you can enable continous loop mode for your carousel.', 'dtsl' ),
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
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
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
								'std' => ''
							),

							// Enable Bullet Pagination
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Enable Bullet Pagination', 'dtsl'),
								'param_name' => 'carousel_bulletpagination',
								'value' => array(
									esc_html__('False', 'dtsl') => 'false',
									esc_html__('True', 'dtsl') => 'true',
								),
								'description' => esc_html__( 'To enable bullet pagination.', 'dtsl' ),
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
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
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
								'std' => ''
							),

							// Space Between Sliders
							array(
								'type' => 'textfield',
								'heading' => esc_html__('Space Between Sliders','dtsl'),
								'param_name' => 'carousel_spacebetween',
								'description' => esc_html__( 'Space between sliders can be given here.', 'dtsl' ),
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
								'std' => 30
							)

					)

	) );
}
?>