<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectorySfSellers extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sf-sellers';
	}

	public function get_title() {
        $seller_plural_label = apply_filters( 'seller_label', 'plural' );
		return sprintf( esc_html__('%1$s', 'dtdr'), $seller_plural_label );
	}

	public function get_style_depends() {
		return array ( 'chosen', 'dtdr-fields', 'dtdr-search-frontend');
	}

	public function get_script_depends() {
		return array ( 'chosen', 'dtdr-search-frontend');
	}

	protected function register_controls() {

		$this->start_controls_section( 'sellers_default_section', array(
			'label' => esc_html__( 'General', 'dtdr' ),
		) );

            $this->add_control( 'field_type', array(
                'label'       => esc_html__( 'Field Type', 'dtdr' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    ''         => esc_html__('List', 'dtdr'),
                    'dropdown' => esc_html__('Dropdown', 'dtdr'),
                ),
                'description' => esc_html__( 'Choose type of field you like to use.', 'dtdr' ),
                'default'      => ''
            ) );

			$this->add_control( 'placeholder_text', array(
				'label'       => esc_html__( 'Placeholder Text', 'dtdr' ),
				'type'        => Controls_Manager::TEXT,
                'description' => esc_html__( 'You can provide your own text for placeholder of this item.', 'dtdr' ),
                'condition'   => array( 'field_type' => 'dropdown' ),
				'default'     => ''
			) );

			$this->add_control( 'dropdown_type', array(
				'label'       => esc_html__( 'Dropdown Type', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''         => esc_html__('Single', 'dtdr'),
					'multiple' => esc_html__('Multiple', 'dtdr'),
				),
				'description' => esc_html__( 'Choose type of dropdown you like to use.', 'dtdr' ),
				'condition'   => array( 'field_type' => 'dropdown' ),
				'default'      => ''
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
		echo do_shortcode('[dtdr_sf_sellers_field '.$attributes.' /]');

	}

}