<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Speed_Test {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function name() {
		return 'wdt-speed-test';
	}

	public function title() {
		return esc_html__( 'Speed Test', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'eicon-flash';
	}

	public function init_styles() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/speed-test/assets/css/style.css'
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/speed-test/assets/js/script.js'
		);
	}

	public function create_elementor_controls($elementor_object) {

        $elementor_object->start_controls_section(
			'wdt_section_content',
			array (
				'label' => esc_html__( 'Data', 'wdt-elementor-addon' ),
			)
		);

        $elementor_object->add_control(
            'speed_test_title',
            array(
                'label'       => esc_html__( 'Speec Test Heading', 'wdt-elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Example Title', 'wdt-elementor-addon' ),
                'placeholder' => esc_html__( 'Example Title', 'wdt-elementor-addon' ),
            )
        );

        $elementor_object->add_control(
            'speed_test_sub_title',
            array(
                'label'       => esc_html__( 'Speec Test Sub Heading', 'wdt-elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Example Sub Title', 'wdt-elementor-addon' ),
                'placeholder' => esc_html__( 'Example Sub Title', 'wdt-elementor-addon' ),
            )
        );

        $elementor_object->end_controls_section();

	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}
        extract($settings);

		$output = '';

		$output .= '<div class="wdt-speed-test-container">';

            if(isset($speed_test_title) && !empty($speed_test_title)) {
                $output .= '<h4>'.esc_attr($speed_test_title).'</h4>';
            }
            if(isset($speed_test_sub_title) && !empty($speed_test_sub_title)) {
                $output .= '<span>'.esc_attr($speed_test_sub_title).'</span>';
            }
                $output .= '<div class="wdt-speed-test-content">';
                    $speedtest_date = date( 'l M d Y' );
                    $speedtest_time = date('e O');
					$speedtest_ip = getenv("REMOTE_ADDR") ;
                    $output .= '<span>'.esc_attr($speedtest_date).' <span class="wdt-speed-test-time"></span> '.esc_attr($speedtest_time).'</span>';
                    $output .= '<p>'.esc_html__( 'Your IP ', 'wdt-elementor-addon' ).esc_attr($speedtest_ip).'</p>';
                $output .= '</div>';
        $output .= '</div>';

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_speed_test' ) ) {
    function wedesigntech_widget_base_speed_test() {
        return WeDesignTech_Widget_Base_Speed_Test::instance();
    }
}