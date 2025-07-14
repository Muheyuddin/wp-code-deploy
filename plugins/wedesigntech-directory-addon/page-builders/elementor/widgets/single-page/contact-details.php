<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectorySpContactDetails extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-contact-details';
	}

	public function get_title() {
		return esc_html__( 'Contact Details', 'dtdr' );
	}

	public function get_style_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	protected function register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

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
					'type2' => esc_html__('Type 2', 'dtdr')
				),
				'description' => esc_html__( 'Choose any of the available type.', 'dtdr' ),
				'default'      => 'type1',
			) );

			$this->add_control( 'contact_details', array(
				'label'       => esc_html__( 'Contact Details', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'list'   => sprintf( esc_html__('%1$s', 'dtdr'), $listing_singular_label ),
					'author' => esc_html__('Author', 'dtdr')
				),
				'description' => esc_html__('Contact details that you like to display.', 'dtdr'),
				'default'      => 'list',
			) );

			$this->add_control( 'include_address', array(
				'label'       => esc_html__( 'Include Address', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to show address in this shortcode.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_email', array(
				'label'       => esc_html__( 'Include Email', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to show email id in this shortcode.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_phone', array(
				'label'       => esc_html__( 'Include Phone', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to show phone in this shortcode.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_mobile', array(
				'label'       => esc_html__( 'Include Mobile', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to show mobile in this shortcode.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_skype', array(
				'label'       => esc_html__( 'Include Skype', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to show skype in this shortcode.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_website', array(
				'label'       => esc_html__( 'Include Website', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to show website in this shortcode.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_direction_link', array(
				'label'       => esc_html__( 'Show Direction Link', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to show direction link along with address.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'requires_buyer_packages', array(
				'label'       => esc_html__( 'Requires Buyer Packages', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if it required to have buyer package. Contact details will be displayed only when buyer purchased the packages.', 'dtdr'),
				'default'      => 'false'
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
		echo do_shortcode('[dtdr_sp_contact_details '.$attributes.' /]');

	}

}