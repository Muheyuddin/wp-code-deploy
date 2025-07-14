<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NetlinkPlusCustomizer' ) ) {
    class NetlinkPlusCustomizer {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            /**
             * Before Hook
             */
            do_action( 'netlink_plus_before_fw_customizer_load' );

                add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_scripts') );
                add_filter( 'customize_previewable_devices', array( $this, 'previewable_devices' ) );

                add_action( 'customize_register', array( $this, 'extend_panels' ), 5 );
                add_action( 'customize_register', array( $this, 'extend_sections' ), 5 );
                add_action( 'customize_register', array( $this, 'extend_controls' ), 10 );

            /**
             * Adter Hook
             */
            do_action( 'netlink_plus_after_fw_customizer_load' );
        }

        function enqueue_scripts() {
            wp_enqueue_style( 'netlink-plus-customizer', NETLINK_PLUS_DIR_URL.'customizer/assets/css/customizer.css', array(), NETLINK_PLUS_VERSION, 'all' );

            wp_enqueue_script( 'netlink-plus-customizer', NETLINK_PLUS_DIR_URL.'customizer/assets/js/customizer.js', array(), NETLINK_PLUS_VERSION, true );
            wp_enqueue_script( 'netlink-plus-customizer-color-picker', NETLINK_PLUS_DIR_URL.'customizer/assets/js/wp-color-picker-alpha.js', array( 'jquery', 'wp-color-picker' ), NETLINK_PLUS_VERSION, true );
            wp_enqueue_script( 'netlink-plus-customizer-interdependencies', NETLINK_PLUS_DIR_URL.'customizer/assets/js/jquery.interdependencies.js', array( 'jquery' ), NETLINK_PLUS_VERSION, true );
            wp_enqueue_script( 'netlink-plus-customizer-dependencies', NETLINK_PLUS_DIR_URL.'customizer/assets/js/jquery.dependencies.js', array( 'netlink-plus-customizer-interdependencies' ), NETLINK_PLUS_VERSION, true );
        }

        function previewable_devices( $devices ) {

			$devices = array(
				'desktop' => array(
					'label' => esc_html__( 'Enter desktop preview mode', 'netlink-plus'),
					'default' => true,
				),
				'tablet-landscape' => array(
					'label' => esc_html__( 'Enter tablet landscape preview mode', 'netlink-plus'),
				),
				'tablet' => array(
					'label' => esc_html__( 'Enter tablet preview mode', 'netlink-plus'),
				),
				'mobile' => array(
					'label' => esc_html__( 'Enter mobile preview mode', 'netlink-plus'),
				),
			);

            return $devices;
        }

        function extend_panels( $wp_customize ) {
            require_once NETLINK_PLUS_DIR_PATH . 'customizer/lib/class-wp-customize-panel.php';
            $wp_customize->register_panel_type( 'Netlink_Customize_Panel' );
        }

        function extend_sections( $wp_customize ) {
            require_once NETLINK_PLUS_DIR_PATH . 'customizer/lib/class-wp-customize-section.php';
            $wp_customize->register_panel_type( 'Netlink_Customize_Section' );
        }

        function extend_controls( $wp_customize ) {

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/class-base-control.php';
            $wp_customize->register_control_type('Netlink_Customize_Control');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/separator/class-control-separator.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Separator');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/description/class-control-description.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Description');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/radio-image/class-control-radio-image.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Radio_Image');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/sortable/class-control-sortable.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Sortable');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/slider/class-control-slider.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Slider');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/responsive-slider/class-control-responsive-slider.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Responsive_Slider');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/responsive-number/class-control-responsive-number.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Responsive_Number');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/responsive-spacing/class-control-responsive-spacing.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Responsive_Spacing');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/spacing/class-control-spacing.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Spacing');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/color/class-control-color.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Color');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/background/class-control-background.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Background');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/typography/class-control-typography.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Typography');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/fontawesome/class-control-fontawesome.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Fontawesome');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/switch/class-control-switch.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Switch');

			require NETLINK_PLUS_DIR_PATH . 'customizer/controls/upload/class-control-upload.php';
			$wp_customize->register_control_type('Netlink_Customize_Control_Upload');
        }
    }
}

NetlinkPlusCustomizer::instance();