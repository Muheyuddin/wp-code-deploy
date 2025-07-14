<?php

// Update Store Locator Menu
if(!function_exists('dtsl_configure_admin_menu_from_location_module')) {
    function dtsl_configure_admin_menu_from_location_module() {

        $dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

        $city_title = sprintf( esc_html__('%1$s City', 'dtsl'), $dt_sl_listing_singular_label );
        $neighborhood_title = sprintf( esc_html__('%1$s Neighborhood', 'dtsl'), $dt_sl_listing_singular_label );
        $countystate_title = sprintf( esc_html__('%1$s County / State', 'dtsl'), $dt_sl_listing_singular_label );

        add_submenu_page( 'dtsl', $city_title, $city_title, 'edit_posts', 'edit-tags.php?taxonomy=dtsl_listings_city&post_type=dtsl_listings' );
        add_submenu_page( 'dtsl', $neighborhood_title, $neighborhood_title, 'edit_posts', 'edit-tags.php?taxonomy=dtsl_listings_neighborhood&post_type=dtsl_listings' );
        add_submenu_page( 'dtsl', $countystate_title, $countystate_title, 'edit_posts', 'edit-tags.php?taxonomy=dtsl_listings_countystate&post_type=dtsl_listings' );

    }
    add_action ( 'admin_menu', 'dtsl_configure_admin_menu_from_location_module', 20 );
}

// Update active menu
if(!function_exists('dtsl_change_active_menu_from_location_module')) {
    function dtsl_change_active_menu_from_location_module($parent_file) {

        global $submenu_file, $current_screen;
        $taxonomy = $current_screen->taxonomy;

        if ($taxonomy == 'dtsl_listings_city') {
            $submenu_file = 'edit-tags.php?taxonomy=dtsl_listings_city&post_type=dtsl_listings';
            $parent_file = 'dtsl';
        } else if ($taxonomy == 'dtsl_listings_neighborhood') {
            $submenu_file = 'edit-tags.php?taxonomy=dtsl_listings_neighborhood&post_type=dtsl_listings';
            $parent_file = 'dtsl';
        } else if ($taxonomy == 'dtsl_listings_countystate') {
            $submenu_file = 'edit-tags.php?taxonomy=dtsl_listings_countystate&post_type=dtsl_listings';
            $parent_file = 'dtsl';
        }

        return $parent_file;

    }
    add_action ( 'parent_file', 'dtsl_change_active_menu_from_location_module' );
}


// Create Taxonomies
if(!function_exists('dtsl_init_taxonomies_from_location_module')) {
    function dtsl_init_taxonomies_from_location_module() {

        $dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

        $listing_city_slug = trim(dtsl_option('map','listing-city-slug'));
        $listing_neighborhood_slug = trim(dtsl_option('map','listing-neighborhood-slug'));
        $listing_countystate_slug = trim(dtsl_option('map','listing-countystate-slug'));


        register_taxonomy ( 'dtsl_listings_city', array (
                    'dtsl_listings'
            ), array (
                    'hierarchical' => true,
                    'labels' => array(
                        'name' 					=> sprintf( esc_html__('%1$s Cities', 'dtsl'), $dt_sl_listing_singular_label ),
                        'singular_name' 		=> sprintf( esc_html__('%1$s City', 'dtsl'), $dt_sl_listing_singular_label ),
                        'search_items'			=> sprintf( esc_html__('Search %1$s Cities', 'dtsl'), $dt_sl_listing_singular_label ),
                        'popular_items'			=> sprintf( esc_html__('Popular %1$s Cities', 'dtsl'), $dt_sl_listing_singular_label ),
                        'all_items'				=> sprintf( esc_html__('All %1$s Cities', 'dtsl'), $dt_sl_listing_singular_label ),
                        'parent_item'			=> sprintf( esc_html__('Parent %1$s City', 'dtsl'), $dt_sl_listing_singular_label ),
                        'parent_item_colon'		=> sprintf( esc_html__('Parent %1$s City', 'dtsl'), $dt_sl_listing_singular_label ),
                        'edit_item'				=> sprintf( esc_html__('Edit %1$s City', 'dtsl'), $dt_sl_listing_singular_label ),
                        'update_item'			=> sprintf( esc_html__('Update %1$s City', 'dtsl'), $dt_sl_listing_singular_label ),
                        'add_new_item'			=> sprintf( esc_html__('Add New %1$s City', 'dtsl'), $dt_sl_listing_singular_label ),
                        'new_item_name'			=> sprintf( esc_html__('New %1$s City', 'dtsl'), $dt_sl_listing_singular_label ),
                        'add_or_remove_items'	=> sprintf( esc_html__('Add or remove', 'dtsl'), $dt_sl_listing_singular_label ),
                        'choose_from_most_used'	=> sprintf( esc_html__('Choose from most used', 'dtsl'), $dt_sl_listing_singular_label ),
                        'menu_name'				=> sprintf( esc_html__('%1$s Cities', 'dtsl'), $dt_sl_listing_singular_label ),
                    ),
                    'show_admin_column' => true,
                    'rewrite' => array( 'slug' => $listing_city_slug, 'hierarchical' => true, 'with_front' => false ),
                    'query_var' => true
            )
        );

        register_taxonomy ( 'dtsl_listings_neighborhood', array (
                    'dtsl_listings'
            ), array (
                    'hierarchical' => true,
                    'labels' => array(
                        'name' 					=> sprintf( esc_html__('%1$s Neighborhoods', 'dtsl'), $dt_sl_listing_singular_label ),
                        'singular_name' 		=> sprintf( esc_html__('%1$s Neighborhood', 'dtsl'), $dt_sl_listing_singular_label ),
                        'search_items'			=> sprintf( esc_html__('Search %1$s Neighborhoods', 'dtsl'), $dt_sl_listing_singular_label ),
                        'popular_items'			=> sprintf( esc_html__('Popular %1$s Neighborhoods', 'dtsl'), $dt_sl_listing_singular_label ),
                        'all_items'				=> sprintf( esc_html__('All %1$s Neighborhoods', 'dtsl'), $dt_sl_listing_singular_label ),
                        'parent_item'			=> sprintf( esc_html__('Parent %1$s Neighborhood', 'dtsl'), $dt_sl_listing_singular_label ),
                        'parent_item_colon'		=> sprintf( esc_html__('Parent %1$s Neighborhood', 'dtsl'), $dt_sl_listing_singular_label ),
                        'edit_item'				=> sprintf( esc_html__('Edit %1$s Neighborhood', 'dtsl'), $dt_sl_listing_singular_label ),
                        'update_item'			=> sprintf( esc_html__('Update %1$s Neighborhood', 'dtsl'), $dt_sl_listing_singular_label ),
                        'add_new_item'			=> sprintf( esc_html__('Add New %1$s Neighborhood', 'dtsl'), $dt_sl_listing_singular_label ),
                        'new_item_name'			=> sprintf( esc_html__('New %1$s Neighborhood', 'dtsl'), $dt_sl_listing_singular_label ),
                        'add_or_remove_items'	=> sprintf( esc_html__('Add or remove', 'dtsl'), $dt_sl_listing_singular_label ),
                        'choose_from_most_used'	=> sprintf( esc_html__('Choose from most used', 'dtsl'), $dt_sl_listing_singular_label ),
                        'menu_name'				=> sprintf( esc_html__('%1$s Neighborhoods', 'dtsl'), $dt_sl_listing_singular_label ),
                    ),
                    'show_admin_column' => true,
                    'rewrite' => array( 'slug' => $listing_neighborhood_slug, 'hierarchical' => true, 'with_front' => false ),
                    'query_var' => true
            )
        );

        register_taxonomy ( 'dtsl_listings_countystate', array (
                    'dtsl_listings'
            ), array (
                    'hierarchical' => true,
                    'labels' => array(
                        'name' 					=> sprintf( esc_html__('%1$s Counties / States', 'dtsl'), $dt_sl_listing_singular_label ),
                        'singular_name' 		=> sprintf( esc_html__('%1$s County / State', 'dtsl'), $dt_sl_listing_singular_label ),
                        'search_items'			=> sprintf( esc_html__('Search %1$s Counties /  States', 'dtsl'), $dt_sl_listing_singular_label ),
                        'popular_items'			=> sprintf( esc_html__('Popular %1$s Counties /  States', 'dtsl'), $dt_sl_listing_singular_label ),
                        'all_items'				=> sprintf( esc_html__('All %1$s Counties /  States', 'dtsl'), $dt_sl_listing_singular_label ),
                        'parent_item'			=> sprintf( esc_html__('Parent %1$s County / State', 'dtsl'), $dt_sl_listing_singular_label ),
                        'parent_item_colon'		=> sprintf( esc_html__('Parent %1$s County / State', 'dtsl'), $dt_sl_listing_singular_label ),
                        'edit_item'				=> sprintf( esc_html__('Edit %1$s County / State', 'dtsl'), $dt_sl_listing_singular_label ),
                        'update_item'			=> sprintf( esc_html__('Update %1$s County / State', 'dtsl'), $dt_sl_listing_singular_label ),
                        'add_new_item'			=> sprintf( esc_html__('Add New %1$s County / State', 'dtsl'), $dt_sl_listing_singular_label ),
                        'new_item_name'			=> sprintf( esc_html__('New %1$s County / State', 'dtsl'), $dt_sl_listing_singular_label ),
                        'add_or_remove_items'	=> sprintf( esc_html__('Add or remove', 'dtsl'), $dt_sl_listing_singular_label ),
                        'choose_from_most_used'	=> sprintf( esc_html__('Choose from most used', 'dtsl'), $dt_sl_listing_singular_label ),
                        'menu_name'				=> sprintf( esc_html__('%1$s Counties /  States', 'dtsl'), $dt_sl_listing_singular_label ),
                    ),
                    'show_admin_column' => true,
                    'rewrite' => array( 'slug' => $listing_countystate_slug, 'hierarchical' => true, 'with_front' => false ),
                    'query_var' => true
            )
        );


        /* Taxomony custom fields */
        require_once DTSL_LOCATION_PLUGIN_PATH . 'taxonomy-custom-fields.php';

    }
    add_action ( 'init', 'dtsl_init_taxonomies_from_location_module' );
}

// Include Templates
if(!function_exists('dtsl_template_include_from_location_module')) {
    function dtsl_template_include_from_location_module($template) {

        if (is_tax ( 'dtsl_listings_city' )) {
            $template = DTSL_LOCATION_PLUGIN_PATH . 'templates/taxonomy-dtsl_listings_city.php';
        } elseif (is_tax ( 'dtsl_listings_neighborhood' )) {
            $template = DTSL_LOCATION_PLUGIN_PATH . 'templates/taxonomy-dtsl_listings_neighborhood.php';
        } elseif (is_tax ( 'dtsl_listings_countystate' )) {
            $template = DTSL_LOCATION_PLUGIN_PATH . 'templates/taxonomy-dtsl_listings_countystate.php';
        }

        return $template;

    }
    add_filter ( 'template_include', 'dtsl_template_include_from_location_module' );
}

// Update taxonomy array for custom options
if(!function_exists('dtsl_update_taxonomies_from_location_module')) {
    function dtsl_update_taxonomies_from_location_module($taxonomies) {

        $taxonomies['dtsl_listings_city']         = esc_html__('City', 'dtsl');
        $taxonomies['dtsl_listings_neighborhood'] = esc_html__('Neighborhood', 'dtsl');
        $taxonomies['dtsl_listings_countystate']  = esc_html__('County / State', 'dtsl');

        return $taxonomies;

    }
    add_filter ( 'dtsl_taxonomies', 'dtsl_update_taxonomies_from_location_module', 20, 1 );
}

?>