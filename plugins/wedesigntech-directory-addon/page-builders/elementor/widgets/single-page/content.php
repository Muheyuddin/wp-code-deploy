<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectorySpContent extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-content';
	}

	public function get_title() {
		return esc_html__( 'Content', 'dtdr' );
	}

	public function get_style_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	protected function register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );
		$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );

		$this->start_controls_section( 'content_default_section', array(
			'label' => esc_html__( 'General', 'dtdr' ),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id', 'dtdr'), $listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.', 'dtdr'), strtolower($listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'excerpt' => esc_html__( 'Excerpt', 'dtdr' ),
					'content' => esc_html__( 'Content', 'dtdr' )
				),
				'description' => esc_html__('Choose type of content that you like to display.', 'dtdr'),
				'default'      => 'excerpt'
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
		echo do_shortcode('[dtdr_sp_content '.$attributes.' /]');

	}

}