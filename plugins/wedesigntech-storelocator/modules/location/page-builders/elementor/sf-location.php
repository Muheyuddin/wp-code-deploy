<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSfLocation extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sf-location';
	}

	public function get_title() {
		return esc_html__( 'Location', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'dtsl-location-search' );
	}

	public function get_script_depends() {
		return array ( 'dtsl-map', 'dtsl-location-search' );
	}

	protected function _register_controls() {

		$this->start_controls_section( 'location_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

			$this->add_control( 'ajax_load', array(
				'label'       => esc_html__( 'Ajax Load', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('If you want to display the output in same page choose "True" here.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'placeholder_text', array(
				'label'       => esc_html__( 'Placeholder Text', 'dtsl' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'You can provide your own text for placeholder of this item.', 'dtsl' ),
				'default'     => ''
			) );

			$this->add_control( 'auto_complete', array(
				'label'       => esc_html__( 'Enable Auto Complete', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to enable autocomplete location.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'max_radius', array(
				'label'   => esc_html__( 'Maximum Radius', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Set maximum radius to search for.', 'dtsl' ),
				'default' => 100
			) );

			$this->add_control( 'radius_unit', array(
				'label'       => esc_html__( 'Radius Unit', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'mi' => esc_html__( 'mi', 'dtsl' ),
					'km' => esc_html__( 'km', 'dtsl' ),
					'm'  => esc_html__( 'm', 'dtsl' ),
				),
				'description' => esc_html__('You can specify radius unit that you like to calculate distance.', 'dtsl'),
				'default'      => 'km'
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
		echo do_shortcode('[dtsl_sf_location_field '.$attributes.' /]');

	}

}