<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectorySfPriceRange extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sf-pricerange';
	}

	public function get_title() {
        return esc_html__( 'Price Range', 'dtdr' );
	}

	public function get_style_depends() {
		return array ( 'jquery-ui', 'dtdr-pricing-search');
	}

	public function get_script_depends() {
		return array ( 'jquery-ui-slider', 'dtdr-pricing-search');
	}

	protected function register_controls() {

		$this->start_controls_section( 'pricerange_default_section', array(
			'label' => esc_html__( 'General', 'dtdr' ),
		) );

            $this->add_control( 'min_price', array(
				'label'   => esc_html__( 'Minimum Price', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Set minimum price range.', 'dtdr' ),
				'default' => 1
            ) );

            $this->add_control( 'max_price', array(
				'label'   => esc_html__( 'Maximum Price', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Set maximum price range.', 'dtdr' ),
				'default' => 100
			) );

			$this->add_control( 'ajax_load', array(
				'label'       => esc_html__( 'Ajax Load', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('If you want to display the output in same page choose "True" here.', 'dtdr'),
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
		echo do_shortcode('[dtdr_sf_price_range_field '.$attributes.' /]');

	}

}