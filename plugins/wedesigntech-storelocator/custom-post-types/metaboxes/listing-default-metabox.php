<?php
global $post;
$list_id = $post->ID;

$author_id = get_post_field( 'post_author', $list_id );
$user_id = get_current_user_id();


echo '<input type="hidden" name="dtsl_listings_meta_nonce" value="'.wp_create_nonce('dtsl_listings_nonce').'" />';

$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );
$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );


$dtsl_latitude = get_post_meta($list_id, 'dtsl_latitude', true);
$dtsl_longitude = get_post_meta($list_id, 'dtsl_longitude', true);



$tabs = array (
    'general'   => array (
        'label' => esc_html__('General', 'dtsl'),
        'icon' => 'far fa-eye',
        'path' => DTSL_PLUGIN_PATH . 'custom-post-types/metaboxes/tabs/general.php'
    ),
    'features'   => array (
        'label' => esc_html__('Features', 'dtsl'),
        'icon' => 'fas fa-puzzle-piece',
        'path' => DTSL_PLUGIN_PATH . 'custom-post-types/metaboxes/tabs/features.php'
    ),
    'contact-info'   => array (
        'label' => esc_html__('Contact Information', 'dtsl'),
        'icon' => 'fas fa-info-circle',
        'path' => DTSL_PLUGIN_PATH . 'custom-post-types/metaboxes/tabs/contact-info.php'
    )
);

$tabs = apply_filters( 'dtsl_metabox_tabs', $tabs );

?>

<div class="dtsl-tabs-vertical-container" data-effect="fade">

    <ul class="dtsl-tabs-vertical">
        <?php
        $i = 0;
        foreach($tabs as $tab) {

            $class = '';
            if($i == 0) { $class = 'class="current"'; }

            echo '<li '.$class.'><a href="javascript:void(0);" '.$class.'><span class="'.$tab['icon'].'"></span>'.$tab['label'].'</a></li>';

            $i++;
        }
        ?>
    </ul>

    <?php
    $i = 0;
    foreach($tabs as $tab) {

        $style_attr = '';
        if($i == 0) { $style_attr = 'style="display: block;"'; }

        echo '<div class="dtsl-tabs-vertical-content" '.$style_attr.'>';
            echo '<h3 class="dtsl-tab-title">'.$tab['label'].'</h3>';

            ob_start();
            require $tab['path'];
            $tab_content = ob_get_contents();
            ob_end_clean();

            echo dtsl_html_output($tab_content);

        echo '</div>';

        $i++;

    }
    ?>

</div>