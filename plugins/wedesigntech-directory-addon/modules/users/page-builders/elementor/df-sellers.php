<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryDfSellers extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-default-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-df-sellers';
	}

	public function get_title() {
		return esc_html__( 'Sellers Listing', 'dtdr' );
	}

	public function get_style_depends() {
		return array ( 'dtdr-users-frontend' );
	}

	public function get_script_depends() {
		return array ();
	}

	protected function register_controls() {

		$seller_plural_label = apply_filters( 'seller_label', 'plural' );
		$seller_singular_label = apply_filters( 'seller_label', 'singular' );

		$this->start_controls_section( 'sellers_default_section', array(
			'label' => esc_html__( 'General', 'dtdr' ),
		) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1' => esc_html__('Type 1', 'dtdr'),
					'type2' => esc_html__('Type 2', 'dtdr'),
					'type3' => esc_html__('Type 3', 'dtdr')
				),
				'description' => sprintf( esc_html__( 'Choose the type that you like to display for your %1$s.', 'dtdr' ), $seller_plural_label),
				'default'      => 'type1',
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'' => esc_html__('None', 'dtdr'),
					1  => esc_html__('I Column', 'dtdr'),
					2  => esc_html__('II Columns', 'dtdr'),
					3  => esc_html__('III Columns', 'dtdr')
				),
				'description' => sprintf( esc_html__( 'Number of columns you like to display your %1$s.', 'dtdr' ), strtolower($seller_plural_label) ),
				'condition'   => array( 'type' => array ( 'type1', 'type2' ) ),
				'default'      => '',
			) );

			$this->add_control( 'include', array(
				'label'   => esc_html__( 'Include', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'List of %1$s ids separated by commas.', 'dtdr' ), strtolower($seller_singular_label) ),
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
		echo do_shortcode('[dtdr_sellers '.$attributes.' /]');

	}

}