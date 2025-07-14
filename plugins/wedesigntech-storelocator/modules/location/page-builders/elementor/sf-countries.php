<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSfCountries extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sf-countries';
	}

	public function get_title() {
		return esc_html__( 'Countries', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'chosen', 'dtsl-location-search' );
	}

	public function get_script_depends() {
		return array ( 'chosen', 'dtsl-location-search' );
	}

	protected function _register_controls() {

		$this->start_controls_section( 'countries_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

            $this->add_control( 'field_type', array(
                'label'       => esc_html__( 'Field Type', 'dtsl' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    ''         => esc_html__('List', 'dtsl'),
                    'dropdown' => esc_html__('Dropdown', 'dtsl'),
                ),
                'description' => esc_html__( 'Choose type of field you like to use.', 'dtsl' ),
                'default'      => ''
            ) );

			$this->add_control( 'placeholder_text', array(
				'label'       => esc_html__( 'Placeholder Text', 'dtsl' ),
				'type'        => Controls_Manager::TEXT,
                'description' => esc_html__( 'You can provide your own text for placeholder of this item.', 'dtsl' ),
                'condition'   => array( 'field_type' => 'dropdown' ),
				'default'     => ''
			) );

			$this->add_control( 'dropdown_type', array(
				'label'       => esc_html__( 'Dropdown Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''         => esc_html__('Single', 'dtsl'),
					'multiple' => esc_html__('Multiple', 'dtsl'),
				),
				'description' => esc_html__( 'Choose type of dropdown you like to use.', 'dtsl' ),
				'condition'   => array( 'field_type' => 'dropdown' ),
				'default'      => ''
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
		echo do_shortcode('[dtsl_sf_countries_field '.$attributes.' /]');

	}

}