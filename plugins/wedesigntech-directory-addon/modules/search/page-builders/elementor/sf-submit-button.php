<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectorySfSubmitButton extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sf-submit-button';
	}

	public function get_title() {
		return esc_html__( 'Submit Button', 'dtdr' );
	}

	public function get_style_depends() {
		return array ( 'dtdr-fields', 'dtdr-search-frontend');
	}

	public function get_script_depends() {
		return array ( 'dtdr-search-frontend');
	}

	protected function register_controls() {

		$this->start_controls_section( 'submit_button_default_section', array(
			'label' => esc_html__( 'General', 'dtdr' ),
		) );

			$this->add_control( 'output_type', array(
				'label'       => esc_html__( 'Output Type', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''              => esc_html__('Same Page - Ajax Load', 'dtdr'),
					'separate-page' => esc_html__('Separate Page', 'dtdr'),
				),
				'description' => esc_html__( 'Choose how you like to display search output.', 'dtdr' ),
				'default'      => ''
			) );

			$this->add_control( 'separate_page_url', array(
				'label'   => esc_html__( 'Separate Page URL', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
                'description' => esc_html__( 'Separate page url in which search content have to displayed. You have to create that page with search form shortcode.', 'dtdr' ),
                'condition'   => array( 'output_type' => 'separate-page' ),
				'default' => ''
			) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtdr' ),
				'default' => ''
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = dtdirectory_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtdr_sf_submit_button '.$attributes.' /]');

	}

}