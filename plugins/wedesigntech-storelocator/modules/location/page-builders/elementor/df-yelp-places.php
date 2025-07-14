<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorDfYelpPlaces extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-default-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-df-yelp-places';
	}

	public function get_title() {
		return esc_html__( 'Yelp Places', 'dtsl' );
	}

	public function get_style_depends() {
		return array ('dtsl-location-frontend');
	}

	public function get_script_depends() {
		return array ();
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

		$this->start_controls_section( 'yelp_places_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

			$this->add_control( 'categories', array(
				'label'   => esc_html__( 'Categories', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('%1$s 1) Please specify categories you like to show. %2$s %1$s 2) Refer https://www.yelp.com/developers/documentation/v3/business_search for details. %2$s', 'dtsl'), '<p>', '</p>' ),
				'default' => ''
			) );

			$this->add_control( 'term', array(
				'label'   => esc_html__( 'Term', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('%1$s 1) Please specify term you like to show. %2$s %1$s 2) Refer https://www.yelp.com/developers/documentation/v3/business_search for details. %2$s', 'dtsl'), '<p>', '</p>' ),
				'default' => ''
			) );

			$this->add_control( 'location_type', array(
				'label'       => esc_html__( 'Location Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'location' => esc_html__('Location', 'dtsl'),
					'lat_n_long'  => esc_html__('Latitude & Longitude', 'dtsl')
				),
				'description' => esc_html__('Choose whether you like to show Location or Latitude & Longitude', 'dtsl'),
				'default'      => 'location',
			) );

			$this->add_control( 'location', array(
				'label'   => esc_html__( 'Location', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Please specify location to display.', 'dtsl' ),
				'default' => ''
			) );

			$this->add_control( 'latitude', array(
				'label'   => esc_html__( 'Latitude', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Please specify latitude of the location to display.', 'dtsl' ),
				'default' => ''
			) );

			$this->add_control( 'longitude', array(
				'label'   => esc_html__( 'Longitude', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Please specify longitude of the location to display.', 'dtsl' ),
				'default' => ''
			) );

			$this->add_control( 'count', array(
				'label'       => esc_html__( 'Number Of Items to Show', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
				),
				'description' => esc_html__('Total number of items to show.', 'dtsl'),
				'default'      => 2,
			) );

			$this->add_control( 'api_key', array(
				'label'   => esc_html__( 'Yelp API Key', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Provide Yelp API key here.', 'dtsl' ),
				'default' => ''
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
		echo do_shortcode('[dtsl_yelp_places '.$attributes.' /]');

	}

}