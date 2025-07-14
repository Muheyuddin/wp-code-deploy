<?php

if( !function_exists('netlink_single_post_params_default') ) {
    function netlink_single_post_params_default() {
        $params = array(
            'enable_title'   		 => 0,
            'enable_image_lightbox'  => 0,
            'enable_disqus_comments' => 0,
            'post_disqus_shortname'  => '',
            'post_dynamic_elements'  => array( 'content', 'comment_box', 'navigation' ),
            'post_commentlist_style' => 'rounded'
        );

        return $params;
    }
}

if( !function_exists('netlink_single_post_misc_default') ) {
    function netlink_single_post_misc_default() {
        $params = array(
            'enable_related_article'=> 0,
            'rposts_title'   		=> esc_html__('Related Posts', 'netlink'),
            'rposts_column'         => 'one-third-column',
            'rposts_count'          => 3,
            'rposts_excerpt'        => 0,
            'rposts_excerpt_length' => 25,
            'rposts_carousel'       => 0,
            'rposts_carousel_nav'   => ''
        );

        return $params;
    }
}

if( !function_exists('netlink_single_post_params') ) {
    function netlink_single_post_params() {
        $params = netlink_single_post_params_default();
        return apply_filters( 'netlink_single_post_params', $params );
    }
}

add_action( 'netlink_after_main_css', 'post_style' );
function post_style() {
    if( is_singular('post') || is_attachment() ) {
        wp_enqueue_style( 'netlink-post', get_theme_file_uri('/modules/post/assets/css/post.css'), false, NETLINK_THEME_VERSION, 'all');

        $post_style = netlink_get_single_post_style( get_the_ID() );
        if ( file_exists( get_theme_file_path('/modules/post/templates/'.$post_style.'/assets/css/post-'.$post_style.'.css') ) ) {
            wp_enqueue_style( 'netlink-post-'.$post_style, get_theme_file_uri('/modules/post/templates/'.$post_style.'/assets/css/post-'.$post_style.'.css'), false, NETLINK_THEME_VERSION, 'all');
        }
    }
}

if( !function_exists('netlink_get_single_post_style') ) {
	function netlink_get_single_post_style( $post_id ) {
		return apply_filters( 'netlink_single_post_style', 'minimal', $post_id );
	}
}

if( !function_exists('netlink_breadcrumb_template_part') ) {
    function netlink_breadcrumb_template_part($args, $post_id) {
        $post_style = netlink_get_single_post_style( get_the_ID() );
        if(is_single($post_id) && $post_style == 'simple') {
           return;
        } else{
            echo netlink_html_output($args);
        }
    }
    add_filter( 'netlink_breadcrumb_get_template_part', 'netlink_breadcrumb_template_part', 10, 2 );
}

if( ! function_exists( 'netlink_breadcrumb_header_wrapper_classes' )  ) {
	function netlink_breadcrumb_header_wrapper_classes($classes) {
        $post_id = get_the_ID();
        $post_style = netlink_get_single_post_style( $post_id );
        if(is_single($post_id) && $post_style == 'simple') {
            array_push($classes, 'wdt-no-breadcrumb');
        }
        return $classes;
	}
	add_filter( 'netlink_header_wrapper_classes', 'netlink_breadcrumb_header_wrapper_classes', 10, 1 );
}

add_action( 'netlink_after_main_css', 'netlink_single_post_enqueue_css' );
if( !function_exists( 'netlink_single_post_enqueue_css' ) ) {
    function netlink_single_post_enqueue_css() {

        wp_enqueue_style( 'netlink-magnific-popup', get_theme_file_uri('/modules/post/assets/css/magnific-popup.css'), false, NETLINK_THEME_VERSION, 'all');
    }
}

add_action( 'netlink_before_enqueue_js', 'netlink_single_post_enqueue_js' );
if( !function_exists( 'netlink_single_post_enqueue_js' ) ) {
    function netlink_single_post_enqueue_js() {

        wp_enqueue_script('jquery-magnific-popup', get_theme_file_uri('/modules/post/assets/js/jquery.magnific-popup.js'), array(), false, true);
    }
}

add_filter('post_class', 'netlink_single_set_post_class', 10, 3);
if( !function_exists('netlink_single_set_post_class') ) {
    function netlink_single_set_post_class( $classes, $class, $post_id ) {

        if( is_singular('post') || is_attachment() ) {
        	$classes[] = 'blog-single-entry';
        	$classes[] = 'post-'.netlink_get_single_post_style( $post_id );
        }

        return $classes;
    }
}

add_filter( 'comment_form_default_fields', 'netlink_custom_placeholder_comment_section', 10 );
function netlink_custom_placeholder_comment_section( $fields ) {

    $req = get_option( 'require_name_email' );
    $required_attribute = 'required="required"';
    $required_indicator = '<span class="required" aria-hidden="true">*</span>';

    $fields['author'] = sprintf(
        '<p class="comment-form-author">%s %s</p>',
        sprintf(
            '<input id="author" name="author" type="text" value="%s" size="30" maxlength="245" %s placeholder="Name *" />',
            esc_attr( isset($commenter['comment_author']) && !empty($commenter['comment_author']) ? $commenter['comment_author'] : '' ),
            ( $req ? $required_attribute : '' )
        ),
        sprintf(
            esc_html__( '', 'netlink' ),
            ( $req ? $required_indicator : '' )
        )
    );
    $fields['email'] = sprintf(
        '<p class="comment-form-email">%s %s</p>',
        sprintf(
            '<input id="email" name="email" type="email" value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s placeholder="Email *" />',
            esc_attr( isset($commenter['comment_author_email']) && !empty($commenter['comment_author_email']) ? $commenter['comment_author_email'] : '' ),
            ( $req ? $required_attribute : '' )
        ),
        sprintf(
            esc_html__( '', 'netlink' ),
            ( $req ? $required_indicator : '' )
        )
    );
    $fields['url'] = sprintf(
        '<p class="comment-form-url">%s %s</p>',
        sprintf(
            '<input id="url" name="url" type="text" value="%s" size="30" maxlength="200" placeholder="Website *"/>',
            esc_attr( isset($commenter['comment_author_url']) && !empty($commenter['comment_author_url']) ? $commenter['comment_author_url'] : '' )
        ),
        sprintf(
            esc_html__( '', 'netlink' )
        )
    );

    return $fields;

}

add_filter( 'comment_form_defaults', 'netlink_custom_placeholder_textarea_section', 10 );
function netlink_custom_placeholder_textarea_section( $fields ) {

    $req = get_option( 'require_name_email' );
    $required_attribute = 'required="required"';
    $required_indicator = '<span class="required" aria-hidden="true">*</span>';

    $replace_comment = esc_html__('Enter your comment', 'netlink');

    $fields['comment_field'] = sprintf(
        '<p class="comment-form-comment">%s %s</p>',
        '<textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" ' . $required_attribute . ' placeholder="Comment *"></textarea>',
        sprintf(
            esc_html__( '', 'netlink' ),
            $required_indicator
        )
    );

    return $fields;
}