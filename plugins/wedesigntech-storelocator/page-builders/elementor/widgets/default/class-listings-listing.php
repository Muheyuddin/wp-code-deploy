<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorDfListingsListing extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-default-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-df-listings-listing';
	}

	public function get_title() {
		$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );
		return sprintf( esc_html__('%1$s Listing', 'dtsl'), $listing_plural_label );
	}

	public function get_style_depends() {
		return array ( 'swiper', 'dtsl-modules-listing', 'dtsl-modules-default' );
	}

	public function get_script_depends() {
		return array ( 'swiper', 'dtsl-frontend' );
	}

	public function dtsl_dynamic_register_controls() {
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label      = apply_filters( 'dt_sl_listing_label', 'singular' );
		$dt_sl_contracttype_singular_label = apply_filters( 'dt_sl_contracttype_label', 'singular' );
		$contracttype_plural_label   = apply_filters( 'dt_sl_contracttype_label', 'plural' );
		$seller_singular_label       = apply_filters( 'dt_sl_seller_label', 'singular' );
		$incharge_singular_label     = apply_filters( 'dt_sl_incharge_label', 'singular' );
		$dt_sl_amenity_singular_label      = apply_filters( 'dt_sl_amenity_label', 'singular' );
		$amenity_plural_label        = apply_filters( 'dt_sl_amenity_label', 'plural' );

		$this->start_controls_section( 'listings_listing_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1'  => esc_html__('Type 1', 'dtsl'),
					'type2'  => esc_html__('Type 2', 'dtsl'),
					'type3'  => esc_html__('Type 3', 'dtsl'),
					'type4'  => esc_html__('Type 4', 'dtsl'),
					'type5'  => esc_html__('Type 5', 'dtsl'),
					'type6'  => esc_html__('Type 6', 'dtsl'),
					'type7'  => esc_html__('Type 7', 'dtsl'),
					'type8'  => esc_html__('Type 8', 'dtsl'),
					'type9'  => esc_html__('Type 9', 'dtsl'),
					'type10' => esc_html__('Type 10', 'dtsl'),
					'type11' => esc_html__('Type 11', 'dtsl'),
					'type12' => esc_html__('Type 12', 'dtsl')
				),
				'description' => esc_html__('Choose type of layout you like to display.', 'dtsl'),
				'default'      => 'type1',
			) );

			$this->add_control( 'gallery', array(
				'label'       => esc_html__( 'Gallery', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'featured_image'        => esc_html__('Featured Image', 'dtsl'),
					'image_gallery'         => esc_html__('Image Gallery', 'dtsl'),
					'gallery_with_featured' => esc_html__('Image Gallery With Featured Image', 'dtsl'),
				),
				'description' => esc_html__( 'Choose how you like to display image gallery.', 'dtsl' ),
				'condition'   => array( 'type' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type7', 'type8', 'type9', 'type10' ) ),
				'default'      => 'featured_image',
			) );

			$this->add_control( 'post_per_page', array(
				'label'   => esc_html__( 'Post Per Page', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Number of posts to show per page. Rest of the posts will be displayed in pagination.', 'dtsl' ),
				'default' => 4
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1  => esc_html__('I Column', 'dtsl'),
					2  => esc_html__('II Columns', 'dtsl'),
					3  => esc_html__('III Columns', 'dtsl'),
					4  => esc_html__('IV Columns', 'dtsl')
				),
				'description' => esc_html__( 'Number of columns you like to display your items.', 'dtsl' ),
				'condition'   => array( 'type' => array( 'type1', 'type2', 'type4', 'type6', 'type8', 'type10') ),
				'default'      => 1,
			) );

			$this->add_control( 'apply_isotope', array(
				'label'       => esc_html__( 'Apply Isotope', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose true if you like to apply isotope for your items.  Isotope won\'t work along with Carousel.', 'dtsl'),
				'default'      => 'true'
			) );

			$this->add_control( 'isotope_filter', array(
				'label'       => esc_html__( 'Isotope Filter', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''             => esc_html__( 'None', 'dtsl' ),
					'category'     => esc_html__( 'Category', 'dtsl' ),
					'contracttype' => sprintf( esc_html__('%1$s', 'dtsl'), $dt_sl_contracttype_singular_label ),
				),
				'condition'   => array( 'apply_isotope' => 'true' ),
				'description' => esc_html__('Choose isotope filter you like to use.', 'dtsl'),
				'default'      => ''
			) );

			$this->add_control( 'apply_child_of', array(
				'label'       => esc_html__( 'Apply Child Of', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'condition'   => array( 'apply_isotope' => 'true' ),
				'description' => sprintf( esc_html__('If you wish to apply child of specified categories or %1$s in filters, choose "True". If no categories or %1$s specified in "Filter Options" this option won\'t work.', 'dtsl'), strtolower($contracttype_plural_label) ),
				'default'      => 'false'
			) );

			$this->add_control( 'featured_items', array(
				'label'       => esc_html__( 'Featured Items', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose true if you like to display featured items.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'excerpt_length', array(
				'label'   => esc_html__( 'Excerpt Length', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Provide excerpt length here.', 'dtsl' ),
				'condition'   => array( 'type' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type7', 'type8', 'type9', 'type10' ) ),
				'default' => 20
			) );

			$this->add_control( 'features_image_or_icon', array(
				'label'       => esc_html__( 'Features Image or Icon', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''      => esc_html__('None', 'dtsl'),
					'image' => esc_html__('Image', 'dtsl'),
					'icon'  => esc_html__('Icon', 'dtsl')
				),
				'description' => esc_html__('Choose any of the option available to display features.', 'dtsl'),
				'condition'   => array( 'type' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type8', 'type9' ) ),
				'default'      => '',
			) );

			$this->add_control( 'features_include', array(
				'label'       => esc_html__( 'Features Include', 'dtsl' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Give features id separated by comma. Only 4 maximum number of features allowed.', 'dtsl'),
				'condition'   => array( 'type' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type8', 'type9' ) ),
				'default'      => '',
			) );

			$this->add_control( 'no_of_cat_to_display', array(
				'label'       => esc_html__( 'No. Of Categories to Display', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					0  => 0,
					1  => 1,
					2  => 2,
					3  => 3,
					4  => 4
				),
				'description' => esc_html__( 'Number of categories you like to display on your items.', 'dtsl' ),
				'default'      => 2,
			) );

			$this->add_control( 'apply_category_toggle', array(
				'label'       => esc_html__( 'Apply Category Toggle', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'condition'   => array( 'apply_isotope' => 'false' ),
				'description' => esc_html__('Apply category toggle for you items list.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'category_toggle_type', array(
				'label'       => esc_html__( 'Category Toggle Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1'  => esc_html__('Type 1', 'dtsl'),
					'type2'  => esc_html__('Type 2', 'dtsl'),
					'type3'  => esc_html__('Type 3', 'dtsl'),
					'type4'  => esc_html__('Type 4', 'dtsl'),
					'type5'  => esc_html__('Type 5', 'dtsl')
				),
				'condition'   => array( 'apply_category_toggle' => 'true' ),
				'description' => esc_html__('Choose category toggle type for you items list.', 'dtsl'),
				'default'      => 'type1',
			) );

			$this->add_control( 'apply_equal_height', array(
				'label'       => esc_html__( 'Apply Equal Height', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'condition'   => array( 'apply_isotope' => 'false', 'apply_category_toggle' => 'false' ),
				'description' => esc_html__('Apply equal height for you items.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'apply_custom_height', array(
				'label'       => esc_html__( 'Apply Custom Height', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Apply custom height for your entire section.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_responsive_control( 'height', array(
                'label' => esc_html__( 'Height', 'dtsl' ),
                'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Provide height for your section in "px" here.', 'dtsl' ),
				'condition'   => array( 'apply_custom_height' => 'true' ),
                'devices' => array( 'desktop', 'tablet', 'mobile' ),
                'selectors' => array(
					'{{WRAPPER}} .dtsl-listing-output-data-container' => 'height: {{SIZE}}px;',
				),
			) );

			$this->add_control( 'sidebar_widget', array(
				'label'       => esc_html__( 'Sidebar Widget', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => sprintf( esc_html__('%1$s 1) If you wish to show these items in sidebar set this to "True". %2$s %1$s 2) This options is not applicable for "Type 3", "Type 5" and "Type 7". %2$s', 'dtsl'), '<p>', '</p>' ),
				'default'      => 'false'
			) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
				'default' => ''
			) );

		$this->end_controls_section();

		$this->dtsl_dynamic_register_controls();

		// From Location Module

		$dtsl_modules = dtstorelocator_instance()->active_modules;
		if(is_array($dtsl_modules) && !empty($dtsl_modules)) {
			if(in_array('location', $dtsl_modules)) {

				$countries_list = dtsl_countries_list(false);
				$countries_list = array('' => esc_html__('All', 'dtsl')) + $countries_list;

				$this->start_controls_section( 'listings_listing_location_default_section', array(
					'label' => esc_html__( 'Filter Options - Location', 'dtsl' ),
				) );

					$this->add_control( 'cities_ids', array(
						'label'   => sprintf( esc_html__('%1$s Cities Ids', 'dtsl'), $dt_sl_listing_singular_label ),
						'type'    => Controls_Manager::TEXT,
						'description' => sprintf( esc_html__( 'Enter %1$s cities ids separated by commas.', 'dtsl' ), $dt_sl_listing_singular_label ),
						'default' => ''
					) );

					$this->add_control( 'neighborhoods_ids', array(
						'label'   => sprintf( esc_html__('%1$s Neighborhoods Ids', 'dtsl'), $dt_sl_listing_singular_label ),
						'type'    => Controls_Manager::TEXT,
						'description' => sprintf( esc_html__( 'Enter %1$s neighborhoods ids separated by commas.', 'dtsl' ), $dt_sl_listing_singular_label ),
						'default' => ''
					) );

					$this->add_control( 'countiesstates_ids', array(
						'label'   => sprintf( esc_html__('%1$s Counties / States Ids', 'dtsl'), $dt_sl_listing_singular_label ),
						'type'    => Controls_Manager::TEXT,
						'description' => sprintf( esc_html__( 'Enter %1$s counties / states ids separated by commas.', 'dtsl' ), $dt_sl_listing_singular_label ),
						'default' => ''
					) );

					$this->add_control( 'country_id', array(
						'label'   => esc_html__('Countries', 'dtsl'),
						'type'        => Controls_Manager::SELECT,
						'options'     => $countries_list,
						'description' => esc_html__( 'Choose countries for which you like to display items.', 'dtsl' ),
						'default' => ''
					) );

				$this->end_controls_section();

			}
		}

		$this->start_controls_section( 'listings_listing_filter_section', array(
			'label' => esc_html__( 'Filter Options', 'dtsl' ),
		) );

			$this->add_control( 'list_item_ids', array(
				'label'   => sprintf( esc_html__('%1$s Item Ids', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s item ids separated by commas.', 'dtsl' ), $dt_sl_listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'category_ids', array(
				'label'   => sprintf( esc_html__('%1$s Category Ids', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s category ids separated by commas.', 'dtsl' ), $dt_sl_listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'contracttypes_ids', array(
				'label'   => sprintf( esc_html__('%1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $contracttype_plural_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Enter %1$s ids separated by commas', 'dtsl'), $contracttype_plural_label ),
				'default' => ''
			) );

			$this->add_control( 'tag_ids', array(
				'label'   => sprintf( esc_html__('%1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $amenity_plural_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Enter %1$s ids separated by commas', 'dtsl'), $amenity_plural_label ),
				'default' => ''
			) );

			$this->add_control( 'seller_ids', array(
				'label'   => sprintf( esc_html__('%1$s %2$s Ids', 'dtsl'), $dt_sl_listing_singular_label, $seller_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Enter %1$s ids separated by commas.', 'dtsl'), strtolower($seller_singular_label) ),
				'default' => ''
			) );

			$this->add_control( 'incharge_ids', array(
				'label'   => sprintf( esc_html__('%1$s %2$s Ids', 'dtsl'), $dt_sl_listing_singular_label, $incharge_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Enter %1$s ids separated by commas.', 'dtsl'), strtolower($incharge_singular_label) ),
				'default' => ''
			) );

		$this->end_controls_section();


		$this->start_controls_section( 'listings_listing_carousel_section', array(
			'label' => esc_html__( 'Carousel Options', 'dtsl' ),
		) );

			$this->add_control( 'enable_carousel', array(
				'label'       => esc_html__( 'Enable Carousel', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__( 'If you wish you can enable carousel for your item listings. Carousel won\'t work along with "Isotope" & "Equal Height" option.', 'dtsl' ),
				'condition'   => array( 'apply_isotope' => 'false', 'apply_category_toggle' => 'false' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_effect', array(
				'label'       => esc_html__( 'Effect', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'' => esc_html__('Default', 'dtsl'),
					'fade'  => esc_html__('Fade', 'dtsl'),
				),
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'dtsl' ),
				'condition'   => array( 'apply_isotope' => 'false', 'apply_category_toggle' => 'false', 'enable_carousel' => 'true' ),
				'default'      => ''
			) );

			$this->add_control( 'carousel_autoplay', array(
				'label'   => esc_html__( 'Auto Play', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Delay between transitions ( in ms ). Leave empty if you don\'t want to auto play.', 'dtsl' ),
				'condition'   => array( 'apply_isotope' => 'false', 'apply_category_toggle' => 'false', 'enable_carousel' => 'true' ),
				'default' => ''
			) );

			$this->add_control( 'carousel_slidesperview', array(
				'label'       => esc_html__( 'Slides Per View', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
				),
				'description' => sprintf( esc_html__('%1$s 1) Number slides of to show in view port. %2$s %1$s 2) 2,3,4 options not applicable for "type 3", "type 5", "type 7" and "type9". %2$s %1$s 3) If "Sidebar Widget" is set to "True", than "Slides Per View" will be set to "1". %2$s', 'dtsl'), '<p>', '</p>' ),
				'condition'   => array( 'apply_isotope' => 'false', 'apply_category_toggle' => 'false', 'enable_carousel' => 'true' ),
				'default'      => 2
			) );

			$this->add_control( 'carousel_loopmode', array(
				'label'       => esc_html__( 'Enable Loop Mode', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__( 'If you wish you can enable continous loop mode for your carousel.', 'dtsl' ),
				'condition'   => array( 'apply_isotope' => 'false', 'apply_category_toggle' => 'false', 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_mousewheelcontrol', array(
				'label'       => esc_html__( 'Enable Mousewheel Control', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__( 'If you wish you can enable mouse wheel control for your carousel.', 'dtsl' ),
				'condition'   => array( 'apply_isotope' => 'false', 'apply_category_toggle' => 'false', 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_bulletpagination', array(
				'label'       => esc_html__('Enable Bullet Pagination', 'dtsl'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__( 'To enable bullet pagination.', 'dtsl' ),
				'condition'   => array( 'apply_isotope' => 'false', 'apply_category_toggle' => 'false', 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_arrowpagination', array(
				'label'       => esc_html__( 'Enable Arrow Pagination', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__( 'To enable arrow pagination.', 'dtsl' ),
				'condition'   => array( 'apply_isotope' => 'false', 'apply_category_toggle' => 'false', 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_spacebetween', array(
				'label'   => esc_html__( 'Space Between Sliders', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Space between sliders can be given here.', 'dtsl' ),
				'condition'   => array( 'apply_isotope' => 'false', 'apply_category_toggle' => 'false', 'enable_carousel' => 'true' ),
				'default' => 30
			) );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = dtstorelocator_elementor_instance()->dtsl_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtsl_listings_listing '.$attributes.' /]');

	}

}