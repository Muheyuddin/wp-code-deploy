<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSfSubmitButton extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sf-submit-button';
	}

	public function get_title() {
		return esc_html__( 'Submit Button', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'dtsl-fields', 'dtsl-search-frontend');
	}

	public function get_script_depends() {
		return array ( 'dtsl-search-frontend');
	}

	protected function _register_controls() {

		$this->start_controls_section( 'submit_button_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

			$this->add_control( 'output_type', array(
				'label'       => esc_html__( 'Output Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''              => esc_html__('Same Page - Ajax Load', 'dtsl'),
					'separate-page' => esc_html__('Separate Page', 'dtsl'),
				),
				'description' => esc_html__( 'Choose how you like to display search output.', 'dtsl' ),
				'default'      => ''
			) );

			$this->add_control( 'separate_page_url', array(
				'label'   => esc_html__( 'Separate Page URL', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
                'description' => esc_html__( 'Separate page url in which search content have to displayed. You have to create that page with search form shortcode.', 'dtsl' ),
                'condition'   => array( 'output_type' => 'separate-page' ),
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
		echo do_shortcode('[dtsl_sf_submit_button '.$attributes.' /]');

	}

}