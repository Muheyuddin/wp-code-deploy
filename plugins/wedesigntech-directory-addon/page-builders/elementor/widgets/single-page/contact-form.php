<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectorySpContactForm extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-contact-form';
	}

	public function get_title() {
		return esc_html__( 'Contact Form', 'dtdr' );
	}

	public function get_style_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	protected function register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );
		$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );

		$this->start_controls_section( 'contact_form_default_section', array(
			'label' => esc_html__( 'General', 'dtdr' ),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id', 'dtdr'), $listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.', 'dtdr'), strtolower($listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'textarea_placeholder', array(
				'label'       => esc_html__( 'Textarea Placeholder', 'dtdr' ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'You can customize palceholder text here. Also you can use {{title}} shortcode replace it with %1$s title', 'dtdr' ), strtolower($listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'submit_label', array(
				'label'   => esc_html__( 'Submit Button Label', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'You can customize submit button label here.', 'dtdr' ),
				'default' => ''
			) );

			$this->add_control( 'contact_point', array(
				'label'       => esc_html__( 'Contact Point', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'' => sprintf( esc_html__( '%1$s Email', 'dtdr' ), $listing_singular_label ),
					'author-email' => esc_html__('Author Email', 'dtdr'),
					'incharge-email' => sprintf( esc_html__('%1$s Email', 'dtdr'), $incharge_singular_label )
				),
				'description' => esc_html__( 'Choose design type for this item.', 'dtdr' ),
				'default'      => '',
			) );

			$this->add_control( 'include_admin', array(
				'label'       => esc_html__( 'Include Admin', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to send copy of mail to administrator.', 'dtdr'),
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
		echo do_shortcode('[dtdr_sp_contact_form '.$attributes.' /]');

	}

}