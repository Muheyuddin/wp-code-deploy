<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSpContactForm extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sp-contact-form';
	}

	public function get_title() {
		return esc_html__( 'Contact Form', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'dtsl-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'dtsl-modules-singlepage' );
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
		$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );

		$this->start_controls_section( 'contact_form_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'textarea_placeholder', array(
				'label'       => esc_html__( 'Textarea Placeholder', 'dtsl' ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'You can customize palceholder text here. Also you can use {{title}} shortcode replace it with %1$s title', 'dtsl' ), strtolower($dt_sl_listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'submit_label', array(
				'label'   => esc_html__( 'Submit Button Label', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'You can customize submit button label here.', 'dtsl' ),
				'default' => ''
			) );

			$this->add_control( 'contact_point', array(
				'label'       => esc_html__( 'Contact Point', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'' => sprintf( esc_html__( '%1$s Email', 'dtsl' ), $dt_sl_listing_singular_label ),
					'author-email' => esc_html__('Author Email', 'dtsl'),
					'incharge-email' => sprintf( esc_html__('%1$s Email', 'dtsl'), $incharge_singular_label )
				),
				'description' => esc_html__( 'Choose design type for this item.', 'dtsl' ),
				'default'      => '',
			) );

			$this->add_control( 'include_admin', array(
				'label'       => esc_html__( 'Include Admin', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to send copy of mail to administrator.', 'dtsl'),
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
		echo do_shortcode('[dtsl_sp_contact_form '.$attributes.' /]');

	}

}