<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSpSocialShare extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sp-social-share';
	}

	public function get_title() {
		return esc_html__( 'Social Share', 'dtsl' );
	}

	public function get_style_depends() {
		return array ('dtsl-social-share-frontend');
	}

	public function get_script_depends() {
		return array ('dtsl-social-share-frontend');
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

		$this->start_controls_section( 'social_share_default_section', array(
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
					'type1'  => esc_html__('Type 1', 'dtsl'),
					'type2'  => esc_html__('Type 2', 'dtsl')
				),
				'description' => esc_html__('Choose type of social share like to display.', 'dtsl'),
				'default'      => 'type1',
			) );

			$this->add_control( 'show_facebook', array(
				'label'       => esc_html__( 'Show Facebook', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show facebook share.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_delicious', array(
				'label'       => esc_html__( 'Show Delicious', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show delicious share.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_digg', array(
				'label'       => esc_html__( 'Show Digg', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show digg share.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_stumbleupon', array(
				'label'       => esc_html__( 'Show Stumble Upon', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show stumble upon share.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_twitter', array(
				'label'       => esc_html__( 'Show Twitter', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show twitter share.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_googleplus', array(
				'label'       => esc_html__( 'Show Google Plus', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show google plus share.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_linkedin', array(
				'label'       => esc_html__( 'Show LinkedIn', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show linkedin share.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_pinterest', array(
				'label'       => esc_html__( 'Show Pinterest', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show pinterest share.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_whatsapp', array(
				'label'       => esc_html__( 'Show Whatsapp', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show whatsapp share.', 'dtsl'),
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
		echo do_shortcode('[dtsl_sp_social_share '.$attributes.' /]');

	}

}