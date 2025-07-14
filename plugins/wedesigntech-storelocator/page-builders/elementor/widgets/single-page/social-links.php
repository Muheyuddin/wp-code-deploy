<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSpSocialLinks extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sp-social-links';
	}

	public function get_title() {
		return esc_html__( 'Social Links', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'dtsl-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'dtsl-modules-singlepage' );
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
		$seller_singular_label = apply_filters( 'dt_sl_seller_label', 'singular' );

		$this->start_controls_section( 'social_links_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'social_links', array(
				'label'       => esc_html__( 'Social Links', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'list' => sprintf( esc_html__('%1$s', 'dtsl'), $dt_sl_listing_singular_label ),
					'seller' => sprintf( esc_html__('%1$s', 'dtsl'), $seller_singular_label ),
				),
				'description' => esc_html__('Social Links that you like to display.', 'dtsl'),
				'default'      => ''
			) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''      => esc_html__('Default', 'dtsl'),
					'type1' => esc_html__('Type 1', 'dtsl'),
					'type2' => esc_html__('Type 2', 'dtsl'),
					'type3' => esc_html__('Type 3', 'dtsl'),
					'type4' => esc_html__('Type 4', 'dtsl'),
					'type5' => esc_html__('Type 5', 'dtsl'),
					'type6' => esc_html__('Type 6', 'dtsl'),
					'type7' => esc_html__('Type 7', 'dtsl'),
					'type8' => esc_html__('Type 8', 'dtsl')
				),
				'description' => esc_html__( 'Choose any of the available type.', 'dtsl' ),
				'default'      => '',
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
		echo do_shortcode('[dtsl_sp_social_links '.$attributes.' /]');

	}

}