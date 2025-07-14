<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSfRadius extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sf-radius';
	}

	public function get_title() {
		return esc_html__( 'Radius', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'jquery-ui', 'dtsl-location-search' );
	}

	public function get_script_depends() {
		return array ( 'jquery-ui-slider', 'dtsl-map', 'dtsl-location-search' );
	}

	protected function _register_controls() {

		$this->start_controls_section( 'radius_default_section', array(
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

			$this->add_control( 'min_radius', array(
				'label'   => esc_html__( 'Minimum Radius', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Set minimum radius here.', 'dtsl' ),
				'default' => 1
			) );

			$this->add_control( 'max_radius', array(
				'label'   => esc_html__( 'Maximum Radius', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Set maximum radius here.', 'dtsl' ),
				'default' => 100
			) );

			$this->add_control( 'default_radius', array(
				'label'   => esc_html__( 'Default Radius', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Set default radius value to search.', 'dtsl' ),
				'default' => 20
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
		echo do_shortcode('[dtsl_sf_radius_field '.$attributes.' /]');

	}

}