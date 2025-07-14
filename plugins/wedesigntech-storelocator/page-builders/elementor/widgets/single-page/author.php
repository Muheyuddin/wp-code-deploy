<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSpAuthor extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sp-author';
	}

	public function get_title() {
		return esc_html__( 'Author Details', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'swiper', 'dtsl-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'swiper', 'dtsl-modules-singlepage' );
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
		$incharge_plural_label = apply_filters( 'dt_sl_incharge_label', 'plural' );

		$this->start_controls_section( 'author_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'content_type', array(
				'label'       => esc_html__( 'Content Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'author'             => esc_html__( 'Post Author', 'dtsl' ),
					'incharges_included' => sprintf( esc_html__('%1$s Included', 'dtsl'), $incharge_plural_label ),
					'both'               => esc_html__( 'Both', 'dtsl' )
				),
				'description' => esc_html__('Contact type that you like to display.', 'dtsl'),
				'default'      => 'author'
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1  => esc_html__('I Column', 'dtsl'),
					2  => esc_html__('II Columns', 'dtsl')
				),
				'description' => sprintf( esc_html__( 'Number of columns you like to display your %1$s.', 'dtsl' ), strtolower($seller_plural_label) ),
				'default'      => 1,
			) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
				'default' => ''
			) );

		$this->end_controls_section();


		$this->start_controls_section( 'authorcarousel_section', array(
			'label' => esc_html__( 'Carousel Options', 'dtsl' ),
		) );

			$this->add_control( 'enable_carousel', array(
				'label'       => esc_html__( 'Enable Carousel', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__( 'If you wish you can enable carousel for your item listings.', 'dtsl' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_pagination', array(
				'label'       => esc_html__( 'Carousel Pagination', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''        => esc_html__('None', 'dtsl'),
					'bullets' => esc_html__('Bullets', 'dtsl'),
					'arrows'  => esc_html__('Arrows', 'dtsl'),
				),
				'description' => esc_html__( 'Choose one of the available paginations.', 'dtsl' ),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => ''
			) );

			$this->add_control( 'carousel_pagination_type', array(
				'label'       => esc_html__( 'Carousel Pagination Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1' => esc_html__('Type 1', 'dtsl'),
					'type2' => esc_html__('Type 2', 'dtsl')
				),
				'description' =>  esc_html__( 'Choose one of the available pagination design types.', 'dtsl' ),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 'type1'
			) );

			$this->add_control( 'carousel_spacebetween', array(
				'label'   => esc_html__( 'Space Between Sliders', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Space between sliders can be given here.', 'dtsl' ),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default' => 20
			) );

		$this->end_controls_section();


	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = dtstorelocator_elementor_instance()->dtsl_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtsl_sp_author '.$attributes.' /]');

	}

}