<?php

if( ! function_exists('netlink_event_breadcrumb_title') ) {
    function netlink_event_breadcrumb_title($title) {
        if( get_post_type() == 'tribe_events' && is_single()) {
            $etitle = esc_html__( 'Event Detail', 'netlink' );
            return '<h1>'.$etitle.'</h1>';
        } else {
            return $title;
        }
    }

    add_filter( 'netlink_breadcrumb_title', 'netlink_event_breadcrumb_title', 20, 1 );
}

?>