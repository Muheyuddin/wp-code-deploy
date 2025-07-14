<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSpFeatures extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sp-features';
	}

	public function get_title() {
		return esc_html__( 'Features', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'dtsl-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'dtsl-modules-singlepage' );
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
		$seller_plural_label    = apply_filters( 'dt_sl_seller_label', 'plural' );

		$this->start_controls_section( 'features_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1' => esc_html__('Type 1', 'dtsl'),
					'type2' => esc_html__('Type 2', 'dtsl'),
					'type3' => esc_html__('Type 3', 'dtsl'),
					'type4' => esc_html__('Type 4', 'dtsl'),
					'type5' => esc_html__('Type 5', 'dtsl'),
					'type6' => esc_html__('Type 6', 'dtsl'),
					'type7' => esc_html__('Type 7', 'dtsl')
				),
				'description' => esc_html__( 'Choose any of the available type.', 'dtsl' ),
				'default'      => 'type1',
			) );

			$this->add_control( 'include', array(
				'label'   => esc_html__( 'Include', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you like, you can include only certain items. Leave empty if you like to display all.', 'dtsl' ),
				'default' => ''
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					-1  => esc_html__('No Column', 'dtsl'),
					1  => esc_html__('I Column', 'dtsl'),
					2  => esc_html__('II Columns', 'dtsl'),
					3  => esc_html__('III Columns', 'dtsl'),
					4  => esc_html__('IV Columns', 'dtsl'),
				),
				'description' => sprintf( esc_html__( 'Number of columns you like to display your %1$s.', 'dtsl' ), strtolower($seller_plural_label) ),
				'default'      => 4,
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
		echo do_shortcode('[dtsl_sp_features '.$attributes.' /]');

	}

}