<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSpVideo extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sp-video';
	}

	public function get_title() {
		return esc_html__( 'Video', 'dtsl' );
	}

	public function get_style_depends() {
		$file_handlers =  dtsl_dependent_files_instance()->dtsl_single_page_module_files( 'dtsl_sp_video' );
		return $file_handlers['css'];
	}

	public function get_script_depends() {
		$file_handlers =  dtsl_dependent_files_instance()->dtsl_single_page_module_files( 'dtsl_sp_video' );
		return $file_handlers['js'];
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

		$this->start_controls_section( 'video_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'default'     => ''
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
		echo do_shortcode('[dtsl_sp_video '.$attributes.' /]');

	}

}