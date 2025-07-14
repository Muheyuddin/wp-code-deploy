<?php get_header('dtsl'); ?>

    <?php
    /**
    * dtsl_before_main_content hook.
    */
    do_action( 'dtsl_before_main_content' );
    ?>

        <?php
        /**
        * dtsl_before_content hook.
        */
        do_action( 'dtsl_before_content' );
        ?>


            <?php

            $posts_per_page    = get_option('posts_per_page');

            $archive_page_type                   = !empty( dtsl_option('archives','archive-page-type') ) ? dtsl_option('archives','archive-page-type')      : 'type1';
            $archive_page_gallery                = !empty( dtsl_option('archives','archive-page-gallery') ) ? dtsl_option('archives','archive-page-gallery'): 'featured_image';
            $archive_page_column                 = dtsl_option('archives','archive-page-column');
            $archive_page_apply_isotope          = dtsl_option('archives','archive-page-apply-isotope');
            $archive_page_excerpt_length         = dtsl_option('archives','archive-page-excerpt-length');
            $archive_page_features_image_or_icon = dtsl_option('archives','archive-page-features-image-or-icon');
            $archive_page_features_include       = dtsl_option('archives','archive-page-features-include');
            $archive_page_noofcat_to_display     = dtsl_option('archives','archive-page-noofcat-to-display');

            echo do_shortcode('[dtsl_listings_listing type="'.$archive_page_type.'" gallery="'.$archive_page_gallery.'" post_per_page="'.$posts_per_page.'" columns="'.$archive_page_column.'" apply_isotope="'.$archive_page_apply_isotope.'" excerpt_length="'.$archive_page_excerpt_length.'" features_image_or_icon="'.$archive_page_features_image_or_icon.'" features_include="'.$archive_page_features_include.'" no_of_cat_to_display="'.$archive_page_noofcat_to_display.'" enable_carousel="false"]');

            ?>

        <?php
        /**
        * dtsl_after_content hook.
        */
        do_action( 'dtsl_after_content' );
        ?>

    <?php
    /**
    * dtsl_after_main_content hook.
    */
    do_action( 'dtsl_after_main_content' );
    ?>

<?php get_footer('dtsl'); ?>