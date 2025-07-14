<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectorySpFeaturedComments extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-featured-comments';
	}

	public function get_title() {
		return esc_html__( 'Comments - Featured', 'dtdr' );
	}

	public function get_style_depends() {
		return array ('dtdr-comments-frontend');
	}

	public function get_script_depends() {
		return array ('dtdr-comments-common', 'dtdr-comments-frontend');
	}

	protected function register_controls() {

		$this->start_controls_section( 'featured_comments_default_section', array(
			'label' => esc_html__( 'General', 'dtdr' ),
		) );

			$this->add_control( 'enable_title', array(
				'label'       => esc_html__( 'Enable Title', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'default'      => 'false'
			) );

			$this->add_control( 'enable_rating', array(
				'label'       => esc_html__( 'Enable Rating', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'default'      => 'false'
			) );

			$this->add_control( 'enable_media', array(
				'label'       => esc_html__( 'Enable Media', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
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
		echo do_shortcode('[dtdr_sp_featured_comments '.$attributes.' /]');

	}

}