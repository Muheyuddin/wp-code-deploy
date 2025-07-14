<?php

namespace NetlinkElementor\Widgets;
use NetlinkElementor\Widgets\Netlink_Shop_Widget_Product_Summary;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;


class Netlink_Shop_Widget_Product_Summary_Extend extends Netlink_Shop_Widget_Product_Summary {

	function dynamic_register_controls() {

		$this->start_controls_section( 'product_summary_extend_section', array(
			'label' => esc_html__( 'Social Options', 'netlink-pro' ),
		) );

			$this->add_control( 'share_follow_type', array(
				'label'   => esc_html__( 'Share / Follow Type', 'netlink-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'share',
				'options' => array(
					''       => esc_html__('None', 'netlink-pro'),
					'share'  => esc_html__('Share', 'netlink-pro'),
					'follow' => esc_html__('Follow', 'netlink-pro'),
				),
				'description' => esc_html__( 'Choose between Share / Follow you would like to use.', 'netlink-pro' ),
			) );

			$this->add_control( 'social_icon_style', array(
				'label'   => esc_html__( 'Social Icon Style', 'netlink-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'simple'        => esc_html__( 'Simple', 'netlink-pro' ),
					'bgfill'        => esc_html__( 'BG Fill', 'netlink-pro' ),
					'brdrfill'      => esc_html__( 'Border Fill', 'netlink-pro' ),
					'skin-bgfill'   => esc_html__( 'Skin BG Fill', 'netlink-pro' ),
					'skin-brdrfill' => esc_html__( 'Skin Border Fill', 'netlink-pro' ),
				),
				'description' => esc_html__( 'This option is applicable for all buttons used in product summary.', 'netlink-pro' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

			$this->add_control( 'social_icon_radius', array(
				'label'   => esc_html__( 'Social Icon Radius', 'netlink-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'square'  => esc_html__( 'Square', 'netlink-pro' ),
					'rounded' => esc_html__( 'Rounded', 'netlink-pro' ),
					'circle'  => esc_html__( 'Circle', 'netlink-pro' ),
				),
				'condition'   => array(
					'social_icon_style' => array ('bgfill', 'brdrfill', 'skin-bgfill', 'skin-brdrfill'),
					'share_follow_type' => array ('share', 'follow')
				),
			) );

			$this->add_control( 'social_icon_inline_alignment', array(
				'label'        => esc_html__( 'Social Icon Inline Alignment', 'netlink-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'netlink-pro' ),
				'label_off'    => esc_html__( 'no', 'netlink-pro' ),
				'default'      => '',
				'return_value' => 'true',
				'description'  => esc_html__( 'This option is applicable for all buttons used in product summary.', 'netlink-pro' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

		$this->end_controls_section();

	}

}