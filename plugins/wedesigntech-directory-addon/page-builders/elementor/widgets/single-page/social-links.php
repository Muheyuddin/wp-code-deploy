<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectorySpSocialLinks extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-social-links';
	}

	public function get_title() {
		return esc_html__( 'Social Links', 'dtdr' );
	}

	public function get_style_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	protected function register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );
		$seller_singular_label = apply_filters( 'seller_label', 'singular' );

		$this->start_controls_section( 'social_links_default_section', array(
			'label' => esc_html__( 'General', 'dtdr' ),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id', 'dtdr'), $listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.', 'dtdr'), strtolower($listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'social_links', array(
				'label'       => esc_html__( 'Social Links', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'list' => sprintf( esc_html__('%1$s', 'dtdr'), $listing_singular_label ),
					'seller' => sprintf( esc_html__('%1$s', 'dtdr'), $seller_singular_label ),
				),
				'description' => esc_html__('Social Links that you like to display.', 'dtdr'),
				'default'      => ''
			) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''      => esc_html__('Default', 'dtdr'),
					'type1' => esc_html__('Type 1', 'dtdr'),
					'type2' => esc_html__('Type 2', 'dtdr'),
					'type3' => esc_html__('Type 3', 'dtdr'),
					'type4' => esc_html__('Type 4', 'dtdr'),
					'type5' => esc_html__('Type 5', 'dtdr'),
					'type6' => esc_html__('Type 6', 'dtdr'),
					'type7' => esc_html__('Type 7', 'dtdr'),
					'type8' => esc_html__('Type 8', 'dtdr')
				),
				'description' => esc_html__( 'Choose any of the available type.', 'dtdr' ),
				'default'      => '',
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
		echo do_shortcode('[dtdr_sp_social_links '.$attributes.' /]');

	}

}