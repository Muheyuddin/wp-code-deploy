<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectorySfFeatures extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sf-features';
	}

	public function get_title() {
		return esc_html__( 'Features', 'dtdr' );
	}

	public function get_style_depends() {
		return array ( 'jquery-ui', 'chosen', 'dtdr-fields', 'dtdr-search-frontend');
	}

	public function get_script_depends() {
		return array ( 'jquery-ui-slider', 'chosen', 'dtdr-search-frontend');
	}

	protected function register_controls() {

		$this->start_controls_section( 'features_default_section', array(
			'label' => esc_html__( 'General', 'dtdr' ),
		) );

            $this->add_control( 'tab_id', array(
                'label'   => esc_html__( 'Tab Id', 'dtdr' ),
                'type'    => Controls_Manager::TEXT,
                'description' => esc_html__( 'Provide tab id for features item that you want to use in search form. Without this tab id shortcode doesn\'t work.', 'dtdr' ),
                'default' => ''
            ) );

            $this->add_control( 'field_type', array(
                'label'       => esc_html__( 'Field Type', 'dtdr' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    'range'    => esc_html__('Range', 'dtdr'),
                    'list'     => esc_html__('List', 'dtdr'),
                    'dropdown' => esc_html__('Dropdown', 'dtdr'),
                ),
                'description' => esc_html__('Choose field type that you like to use for this feature item.', 'dtdr'),
                'default'      => 'range'
            ) );

			$this->add_control( 'placeholder_text', array(
				'label'       => esc_html__( 'Placeholder Text', 'dtdr' ),
				'type'        => Controls_Manager::TEXT,
                'description' => esc_html__( 'You can provide your own text for placeholder of this item.', 'dtdr' ),
                'condition'   => array( 'field_type' => 'dropdown' ),
				'default'     => ''
			) );

            $this->add_control( 'min_value', array(
				'label'   => esc_html__( 'Minimum Value', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
                'description' => esc_html__( 'Set minimum value range.', 'dtdr' ),
                'condition'   => array( 'field_type' => 'range' ),
				'default' => 1
            ) );

            $this->add_control( 'max_value', array(
				'label'   => esc_html__( 'Maximum Value', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
                'description' => esc_html__( 'Set maximum value range.', 'dtdr' ),
                'condition'   => array( 'field_type' => 'range' ),
				'default' => 100
            ) );

            $this->add_control( 'dropdownlist_options', array(
				'label'   => esc_html__( 'Dropdown Options', 'dtdr' ),
				'type'    => Controls_Manager::TEXTAREA,
                'description' => esc_html__('Add dropdown options in comma separated values.', 'dtdr'),
                'condition'   => array( 'field_type' => array ('dropdown', 'list') ),
				'default' => ''
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

            $this->add_control( 'item_unit', array(
				'label'   => esc_html__( 'Item Unit', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'You can provide item unit for your label here.', 'dtdr' ),
				'default' => ''
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
		echo do_shortcode('[dtdr_sf_features_field '.$attributes.' /]');

	}

}