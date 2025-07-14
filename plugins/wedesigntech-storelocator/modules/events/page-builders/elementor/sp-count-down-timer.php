<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSpCountDownTimer extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sp-countdown-timer';
	}

	public function get_title() {
		return esc_html__( 'Countdown Timer', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'dtsl-events-frontend' );
	}

	public function get_script_depends() {
		return array ('dtsl-events-frontend');
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

		$this->start_controls_section( 'countdown_timer_default_section', array(
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

			$this->add_control( 'timer_for', array(
				'label'       => esc_html__( 'Timer For', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'start-date' => esc_html__('Start Date', 'dtsl'),
					'end-date'  => esc_html__('End Date', 'dtsl'),
				),
				'description' => esc_html__('Choose for which you like to have timer.', 'dtsl'),
				'default'      => 'start-date'
			) );

			$this->add_control( 'include_time', array(
				'label'       => esc_html__( 'Include Time', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to include time along with date.', 'dtsl'),
				'default'      => 'start-date'
			) );

			$this->add_control( 'disable_shortcode_section', array(
				'label'       => esc_html__( 'Disable Shortcode Section', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to disable this shortcode section completely on countdown timer completion.', 'dtsl'),
				'default'      => 'false'
			) );

			$this->add_control( 'countdown_completed_text', array(
				'label'       => esc_html__('Countdown Completed Text', 'dtsl'),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__('Add text that you like to display on countdown completion.', 'dtsl')
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
		echo do_shortcode('[dtsl_sp_countdown_timer '.$attributes.' /]');

	}

}