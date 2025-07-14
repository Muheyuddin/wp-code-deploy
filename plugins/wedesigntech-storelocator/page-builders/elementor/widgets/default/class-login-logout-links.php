<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorDfLoginLogoutLinks extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-default-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-df-login-logout-links';
	}

	public function get_title() {
		return esc_html__( 'Login / Logout Links', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'dtsl-modules-default' );
	}

	public function get_script_depends() {
		return array ( 'dtsl-frontend' );
	}

	protected function _register_controls() {

		$this->start_controls_section( 'login_logout_links_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
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
		echo do_shortcode('[dtsl_login_logout_links '.$attributes.' /]');

	}

}