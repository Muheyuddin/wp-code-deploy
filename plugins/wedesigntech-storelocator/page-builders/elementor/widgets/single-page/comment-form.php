<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSpCommentForm extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sp-comment-form';
	}

	public function get_title() {
		return esc_html__( 'Comment Form', 'dtsl' );
	}

	public function get_style_depends() {
		$file_handlers =  dtsl_dependent_files_instance()->dtsl_single_page_module_files( 'dtsl_sp_comment_form' );
		return $file_handlers['css'];
	}

	public function get_script_depends() {
		$file_handlers =  dtsl_dependent_files_instance()->dtsl_single_page_module_files( 'dtsl_sp_comment_form' );
		return $file_handlers['js'];
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

		$this->start_controls_section( 'comment_form_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

			$this->add_control( 'form_title', array(
				'label'       => esc_html__( 'Form Title', 'dtsl' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can provide form title here.', 'dtsl' ),
				'default'     => ''
			) );

			$this->add_control( 'form_comment_field_placeholder', array(
				'label'   => esc_html__( 'Form Comment Field Placeholder', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can provide form comment field placeholder here.', 'dtsl' ),
				'default' => ''
			) );

			$this->add_control( 'form_submit_button_label', array(
				'label'   => esc_html__( 'Form Submit Button Label', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'You can customize submit button label here.', 'dtsl' ),
				'default' => ''
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
		echo do_shortcode('[dtsl_sp_comment_form '.$attributes.' /]');

	}

}