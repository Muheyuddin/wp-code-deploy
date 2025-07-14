<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryDfLoginLogoutLinks extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-default-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-df-login-logout-links';
	}

	public function get_title() {
		return esc_html__( 'Login / Logout Links', 'dtdr' );
	}

	public function get_style_depends() {
		return array ( 'dtdr-modules-default' );
	}

	public function get_script_depends() {
		return array ( 'dtdr-frontend' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'login_logout_links_default_section', array(
			'label' => esc_html__( 'General', 'dtdr' ),
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
		echo do_shortcode('[dtdr_login_logout_links '.$attributes.' /]');

	}

}