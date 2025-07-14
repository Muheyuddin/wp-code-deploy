<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSpContactDetails extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sp-contact-details';
	}

	public function get_title() {
		return esc_html__( 'Contact Details', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'dtsl-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'dtsl-modules-singlepage' );
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

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
					'type2' => esc_html__('Type 2', 'dtsl')
				),
				'description' => esc_html__( 'Choose any of the available type.', 'dtsl' ),
				'default'      => 'type1',
			) );

			$this->add_control( 'contact_details', array(
				'label'       => esc_html__( 'Contact Details', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'list'   => sprintf( esc_html__('%1$s', 'dtsl'), $dt_sl_listing_singular_label ),
					'author' => esc_html__('Author', 'dtsl')
				),
				'description' => esc_html__('Contact details that you like to display.', 'dtsl'),
				'default'      => 'list',
			) );

			$this->add_control( 'include_address', array(
				'label'       => esc_html__( 'Include Address', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show address in this shortcode.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_email', array(
				'label'       => esc_html__( 'Include Email', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show email id in this shortcode.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_phone', array(
				'label'       => esc_html__( 'Include Phone', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show phone in this shortcode.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_mobile', array(
				'label'       => esc_html__( 'Include Mobile', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show mobile in this shortcode.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_skype', array(
				'label'       => esc_html__( 'Include Skype', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show skype in this shortcode.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_website', array(
				'label'       => esc_html__( 'Include Website', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show website in this shortcode.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_direction_link', array(
				'label'       => esc_html__( 'Show Direction Link', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to show direction link along with address.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'requires_buyer_packages', array(
				'label'       => esc_html__( 'Requires Buyer Packages', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if it required to have buyer package. Contact details will be displayed only when buyer purchased the packages.', 'dtsl'),
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
		echo do_shortcode('[dtsl_sp_contact_details '.$attributes.' /]');

	}

}