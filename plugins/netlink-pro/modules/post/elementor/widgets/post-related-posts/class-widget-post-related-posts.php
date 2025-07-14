<?php
use NetlinkElementor\Widgets\NetlinkElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Post_Related_Posts extends NetlinkElementorWidgetBase {

    public function get_name() {
        return 'wdt-post-related-posts';
    }

    public function get_title() {
        return esc_html__('Post - Related Posts', 'netlink-pro');
    }

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'netlink-pro'),
        ) );

            $this->add_control( 'related_title', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Title', 'netlink-pro'),
                'default'     => esc_html__('Related Posts', 'netlink-pro'),
				'description' => esc_html__('Put the related posts section title.', 'netlink-pro'),
            ) );

            $this->add_control( 'related_column', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Column', 'netlink-pro'),
                'default' => 'one-third-column',
                'options' => array(
                    'one-column'  		=> esc_html__('I Column', 'netlink-pro'),
                    'one-half-column'  	=> esc_html__('II Columns', 'netlink-pro'),
                    'one-third-column'  => esc_html__('III Columns', 'netlink-pro'),
                ),
            ) );

            $this->add_control( 'related_count', array(
                'type'        => Controls_Manager::NUMBER,
                'label'       => esc_html__('Count', 'netlink-pro'),
                'default'     => '3',
                'placeholder' => esc_html__( 'Put no.of related posts to show.', 'netlink-pro' ),
            ) );

            $this->add_control( 'related_excerpt', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Excerpt?', 'netlink-pro'),
                'label_on'     => esc_html__( 'Yes', 'netlink-pro' ),
                'label_off'    => esc_html__( 'No', 'netlink-pro' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );

            $this->add_control( 'related_excerpt_length', array(
                'type'        => Controls_Manager::NUMBER,
                'label'       => esc_html__('Excerpt Length', 'netlink-pro'),
                'default'     => '25',
                'condition' => array( 'related_excerpt' => 'yes' )
            ) );

            $this->add_control( 'related_carousel', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Carousel?', 'netlink-pro'),
                'label_on'     => esc_html__( 'Yes', 'netlink-pro' ),
                'label_off'    => esc_html__( 'No', 'netlink-pro' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );

            $this->add_control( 'related_nav_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Navigation Style', 'netlink-pro'),
                'default' => '',
                'options' => array(
                    ''  		  => esc_html__('None', 'netlink-pro'),
                    'navigation'  => esc_html__('Navigations', 'netlink-pro'),
                    'pager'  	  => esc_html__('Pager', 'netlink-pro'),
                ),
				'condition' => array( 'related_carousel' => 'yes' )
            ) );

            $this->add_control( 'el_class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Extra class name', 'netlink-pro'),
                'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'netlink-pro')
            ) );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

		$out = '';

        global $post;
        $post_id =  $post->ID;

		$template_args['post_ID'] = $post_id;
		$template_args['related_Title'] = $related_title;
		$template_args['related_Column'] = $related_column;
		$template_args['related_Count'] = $related_count;
		$template_args['related_Excerpt'] = $related_excerpt;
		$template_args['related_Excerpt_Length'] = $related_excerpt_length;
		$template_args['related_Carousel'] = $related_carousel;
		$template_args['related_Nav_Style'] = $related_nav_style;

		$out .= '<div class="entry-related-posts-wrapper '.$el_class.'">';
           $out .= netlink_get_template_part( 'post', 'templates/post-extra/related_posts', '', $template_args );
		$out .= '</div>';

		echo $out;
	}

}