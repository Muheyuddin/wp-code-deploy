<?php
add_action( 'netlink_after_main_css', 'footer_style' );
function footer_style() {
    wp_enqueue_style( 'netlink-footer', get_theme_file_uri('/modules/footer/assets/css/footer.css'), false, NETLINK_THEME_VERSION, 'all');
}

add_action( 'netlink_footer', 'footer_content' );
function footer_content() {
    netlink_template_part( 'content', 'content', 'footer' );
}