<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectorySpCountDownTimer extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-countdown-timer';
	}

	public function get_title() {
		return esc_html__( 'Countdown Timer', 'dtdr' );
	}

	public function get_style_depends() {
		return array ( 'dtdr-events-frontend' );
	}

	public function get_script_depends() {
		return array ('dtdr-events-frontend');
	}

	protected function register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

		$this->start_controls_section( 'countdown_timer_default_section', array(
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

			$this->add_control( 'timer_for', array(
				'label'       => esc_html__( 'Timer For', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'start-date' => esc_html__('Start Date', 'dtdr'),
					'end-date'  => esc_html__('End Date', 'dtdr'),
				),
				'description' => esc_html__('Choose for which you like to have timer.', 'dtdr'),
				'default'      => 'start-date'
			) );

			$this->add_control( 'include_time', array(
				'label'       => esc_html__( 'Include Time', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to include time along with date.', 'dtdr'),
				'default'      => 'start-date'
			) );

			$this->add_control( 'disable_shortcode_section', array(
				'label'       => esc_html__( 'Disable Shortcode Section', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to disable this shortcode section completely on countdown timer completion.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'countdown_completed_text', array(
				'label'       => esc_html__('Countdown Completed Text', 'dtdr'),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__('Add text that you like to display on countdown completion.', 'dtdr')
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
		echo do_shortcode('[dtdr_sp_countdown_timer '.$attributes.' /]');

	}

}