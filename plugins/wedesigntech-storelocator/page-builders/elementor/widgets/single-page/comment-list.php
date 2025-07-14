<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSpComments extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sp-comments';
	}

	public function get_title() {
		return esc_html__( 'Comments', 'dtsl' );
	}

	public function get_style_depends() {
		$file_handlers =  dtsl_dependent_files_instance()->dtsl_single_page_module_files( 'dtsl_sp_comments' );
		return $file_handlers['css'];
	}

	public function get_script_depends() {
		$file_handlers =  dtsl_dependent_files_instance()->dtsl_single_page_module_files( 'dtsl_sp_comments' );
		return $file_handlers['js'];
	}

	protected function _register_controls() {

		$this->start_controls_section( 'comments_default_section', array(
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
		echo do_shortcode('[dtsl_sp_comments '.$attributes.' /]');

	}

}