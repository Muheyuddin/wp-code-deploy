<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSpUtils extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sp-utils';
	}

	public function get_title() {
		return esc_html__( 'Utils', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'dtsl-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'dtsl-modules-singlepage' );
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label      = apply_filters( 'dt_sl_listing_label', 'singular' );
		$dt_sl_contracttype_singular_label = apply_filters( 'dt_sl_contracttype_label', 'singular' );
		$seller_singular_label       = apply_filters( 'dt_sl_seller_label', 'singular' );
		$dt_sl_amenity_singular_label      = apply_filters( 'dt_sl_amenity_label', 'singular' );

		$this->start_controls_section( 'utils_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'show_title', array(
				'label'       => esc_html__( 'Show Title', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show title.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_favourite', array(
				'label'       => esc_html__( 'Show Favourite', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show favourite option.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_pageview', array(
				'label'       => esc_html__( 'Show Page View', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show page view.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_print', array(
				'label'       => esc_html__( 'Show Print', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show print option.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_socialshare', array(
				'label'       => esc_html__( 'Show Social Share', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' =>  esc_html__('Choose "True" if you like to show social share option.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_averagerating', array(
				'label'       => esc_html__( 'Show Average Rating', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show average rating.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_featured', array(
				'label'       => esc_html__( 'Show Featured Item', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show featured item.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_categories', array(
				'label'       => esc_html__( 'Show Categories', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show categories.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_cities', array(
				'label'       => esc_html__( 'Show Cities', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show cities.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_neighborhoods', array(
				'label'       => esc_html__( 'Show Neighborhoods', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show neighborhoods.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_countystate', array(
				'label'       => esc_html__( 'Show County / State', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show county / state.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_contracttype', array(
				'label'       => sprintf( esc_html__('Show %1$s', 'dtsl'), $dt_sl_contracttype_singular_label ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => sprintf( esc_html__('Choose "True" if you like to show %1$s', 'dtsl'), strtolower($dt_sl_contracttype_singular_label) ),
				'default'      => 'false'
			) );

			$this->add_control( 'show_amenity', array(
				'label'       => sprintf( esc_html__('Show %1$s', 'dtsl'), $dt_sl_amenity_singular_label ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => sprintf( esc_html__('Choose "True" if you like to show %1$s', 'dtsl'), strtolower($dt_sl_amenity_singular_label) ),
				'default'      => 'false'
			) );

			$this->add_control( 'show_price', array(
				'label'       => esc_html__( 'Show Price', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show price.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_address', array(
				'label'       => esc_html__( 'Show Address', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show address.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_contactdetails', array(
				'label'       => esc_html__( 'Show Contact Details', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''       => esc_html__( 'None', 'dtsl' ),
					'list'   => sprintf( esc_html__('%1$s', 'dtsl'), $dt_sl_listing_singular_label ),
					'seller' => sprintf( esc_html__('%1$s', 'dtsl'), $seller_singular_label )
				),
				'description' => esc_html__('Contact details that you like to display.', 'dtsl'),
				'default'      => ''
			) );

			$this->add_control( 'show_contactdetails_onrequest', array(
				'label'       => esc_html__( 'Show Contact Details - On Request', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show contact details on request.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_startdate', array(
				'label'       => esc_html__( 'Show Start Date', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show start date.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_enddate', array(
				'label'       => esc_html__( 'Show End Date', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show end date.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_posteddate', array(
				'label'       => esc_html__( 'Show Posted Date', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show posted date.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_mergeddates', array(
				'label'       => esc_html__( 'Show Merged Date', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show merged date.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
				'default' => ''
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = dtstorelocator_elementor_instance()->dtsl_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtsl_sp_utils '.$attributes.' /]');

	}

}