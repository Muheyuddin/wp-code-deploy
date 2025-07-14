<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectorySpFeatures extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-features';
	}

	public function get_title() {
		return esc_html__( 'Features', 'dtdr' );
	}

	public function get_style_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	protected function register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );
		$seller_plural_label    = apply_filters( 'seller_label', 'plural' );

		$this->start_controls_section( 'features_default_section', array(
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
					'type1' => esc_html__('Type 1', 'dtdr'),
					'type2' => esc_html__('Type 2', 'dtdr'),
					'type3' => esc_html__('Type 3', 'dtdr'),
					'type4' => esc_html__('Type 4', 'dtdr'),
					'type5' => esc_html__('Type 5', 'dtdr'),
					'type6' => esc_html__('Type 6', 'dtdr'),
					'type7' => esc_html__('Type 7', 'dtdr')
				),
				'description' => esc_html__( 'Choose any of the available type.', 'dtdr' ),
				'default'      => 'type1',
			) );

			$this->add_control( 'include', array(
				'label'   => esc_html__( 'Include', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you like, you can include only certain items. Leave empty if you like to display all.', 'dtdr' ),
				'default' => ''
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					-1  => esc_html__('No Column', 'dtdr'),
					1  => esc_html__('I Column', 'dtdr'),
					2  => esc_html__('II Columns', 'dtdr'),
					3  => esc_html__('III Columns', 'dtdr'),
					4  => esc_html__('IV Columns', 'dtdr'),
				),
				'description' => sprintf( esc_html__( 'Number of columns you like to display your %1$s.', 'dtdr' ), strtolower($seller_plural_label) ),
				'default'      => 4,
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
		echo do_shortcode('[dtdr_sp_features '.$attributes.' /]');

	}

}