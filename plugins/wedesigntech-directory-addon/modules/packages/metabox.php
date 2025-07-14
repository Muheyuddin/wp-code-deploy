<?php
global $post;
$post_id = $post->ID;
echo '<input type="hidden" name="dtdr_packages_meta_nonce" value="'.wp_create_nonce('dtdr_packages_nonce').'" />';
echo '<input type="hidden" name="dtdr_woocommerce_meta_nonce" value="'.wp_create_nonce('dtdr_woocommerce_nonce').'" />';

$listing_plural_label = apply_filters( 'listing_label', 'plural' );
$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );
?>

<div class="dtdr-custom-box">

    <div class="dtdr-column dtdr-one-half first">
        <div class="dtdr-column dtdr-one-third first">
            <label><?php echo esc_html__('Validity', 'dtdr'); ?></label>
        </div>
        <div class="dtdr-column dtdr-two-third">
            <div class="dtdr-column dtdr-one-sixth first">
                <?php $dtdr_period= get_post_meta($post_id, 'dtdr_period', true); ?>
                <input type="text" name="dtdr_period" value="<?php echo esc_attr($dtdr_period); ?>" />
            </div>
            <div class="dtdr-column dtdr-five-sixth">
                <?php
                $dtdr_term = get_post_meta($post_id, 'dtdr_term', true);

                $terms_list = array('D' => 'Day(s)', 'W' => 'Week(s)', 'M' => 'Month(s)', 'Y' => 'Year(s)', 'L' => 'Lifetime');
                echo '<select style="width:20%;" data-placeholder="'.esc_html__('Select...', 'dtdr').'" class="dtdr-chosen-select dtdr-chosen-term" name="dtdr_term" >';
                    foreach ( $terms_list as $term_list_key => $term_list ){
                        echo '<option value="'.$term_list_key.'" '.selected( $term_list_key, $dtdr_term, false ).'>' . $term_list . '</option>';
                    }
                echo '</select>';
                ?>
            </div>
            <div class="dtdr-note"><?php echo esc_html__('Add time period for you package.','dtdr'); ?></div>
        </div>
    </div>

    <div class="dtdr-column dtdr-one-half">
        <div class="dtdr-column dtdr-one-third first">
            <label><?php echo esc_html__('Package Type', 'dtdr'); ?></label>
        </div>
        <div class="dtdr-column dtdr-two-third">
            <?php
            $dtdr_package_type = get_post_meta($post_id, 'dtdr_package_type', true);
            $dtdr_package_type = ($dtdr_package_type != '') ? $dtdr_package_type : 'buyer';

            if($dtdr_package_type == 'seller') {
                $seller_hide_cls = '';
            } else {
                $seller_hide_cls = 'style="display:none;"';
            }


            $dtdr_packagetypes = array ('buyer' => esc_html__('Buyer', 'dtdr'), 'seller' => esc_html__('Seller', 'dtdr'));
            ?>
            <select name="dtdr_package_type" class="dtdr-package-type dtdr-chosen-select">
                <?php
                foreach($dtdr_packagetypes as $dtdr_packagetype_key => $dtdr_packagetype) {
                    echo '<option value="'.$dtdr_packagetype_key.'" '.selected($dtdr_packagetype_key, $dtdr_package_type, false ).'>';
                        echo esc_html($dtdr_packagetype);
                    echo '</option>';
                }
                ?>
            </select>
            <div class="dtdr-note"><?php echo esc_html__('Choose type of package you like to use.', 'dtdr'); ?> </div>
        </div>
    </div>

</div>

<div class="dtdr-custom-box">

    <div class="dtdr-column dtdr-one-half first">
        <div class="dtdr-column dtdr-one-third first">
            <label><?php echo esc_html__('Regular Price', 'dtdr'); ?></label>
        </div>
        <div class="dtdr-column dtdr-two-third">
            <?php $_regular_price = get_post_meta($post_id, '_regular_price', true); ?>
            <input name="_regular_price" id="_regular_price" type="text" value="<?php echo esc_attr($_regular_price); ?>" />
            <div class="dtdr-note"><?php echo esc_html__('Add regular price for your package here. Avoid comma while adding price.', 'dtdr'); ?> </div>
        </div>
    </div>

    <div class="dtdr-column dtdr-one-half">
        <div class="dtdr-column dtdr-one-third first">
            <label><?php echo esc_html__('Sale Price', 'dtdr'); ?></label>
        </div>
        <div class="dtdr-column dtdr-two-third">
            <?php $_sale_price = get_post_meta($post_id, '_sale_price', true); ?>
            <input name="_sale_price" id="_sale_price" type="text" value="<?php echo esc_attr($_sale_price); ?>" />
            <div class="dtdr-note"><?php echo esc_html__('Add sale price for your package here. Avoid comma while adding price.', 'dtdr'); ?> </div>
        </div>
    </div>

</div>

<div class="dtdr-custom-box">

    <div class="dtdr-column dtdr-one-half first">

        <div class="dtdr-column dtdr-one-third first">
           <label><?php echo sprintf( esc_html__('Number of %1$s allowed', 'dtdr'), strtolower($listing_plural_label) ); ?></label>
        </div>
        <div class="dtdr-column dtdr-two-third">
            <?php $dtdr_numberof_listings= get_post_meta($post_id, 'dtdr_numberof_listings', true); ?>
            <input type="number" name="dtdr_numberof_listings" value="<?php echo esc_attr($dtdr_numberof_listings); ?>" min="-1" max="100" />
            <div class="dtdr-note">
                <?php
                echo sprintf( esc_html__('Buyer => Number of %1$s contact details allowed to view.', 'dtdr'), strtolower($listing_plural_label) );
                echo "<br>";
                echo sprintf( esc_html__('Seller => Number of %1$s allowed to post.', 'dtdr'), strtolower($listing_plural_label) );
                echo "<br>";
                echo sprintf( esc_html__('-1 for Unlimited %1$s.', 'dtdr'), strtolower($listing_plural_label) );
                ?>
            </div>
        </div>

    </div>

    <div class="dtdr-column dtdr-one-half dtdr-package-type-seller" <?php echo dtdr_html_output($seller_hide_cls); ?>>

        <div class="dtdr-column dtdr-one-third first">
           <label><?php echo sprintf( esc_html__('Number of featured %1$s allowed', 'dtdr'), strtolower($listing_plural_label) ); ?></label>
        </div>
        <div class="dtdr-column dtdr-two-third">
            <?php $dtdr_numberof_featured_listings= get_post_meta($post_id, 'dtdr_numberof_featured_listings', true); ?>
            <input type="number" name="dtdr_numberof_featured_listings" value="<?php echo esc_attr($dtdr_numberof_featured_listings); ?>" min="-1" max="100" />
            <div class="dtdr-note">
                <?php
                echo sprintf( esc_html__('Number of featured %1$s allowed in this package.', 'dtdr'), strtolower($listing_plural_label) );
                echo "<br>";
                echo sprintf( esc_html__('-1 for Unlimited featured %1$s.', 'dtdr'), strtolower($listing_plural_label) );
                ?>
            </div>
        </div>

    </div>

</div>

<div class="dtdr-custom-box dtdr-package-type-seller" <?php echo dtdr_html_output($seller_hide_cls); ?>>

    <div class="dtdr-column dtdr-one-half first">

        <div class="dtdr-column dtdr-one-third first">
           <label><?php echo sprintf( esc_html__('Number of %1$s allowed', 'dtdr'), strtolower($incharge_plural_label) ); ?></label>
        </div>
        <div class="dtdr-column dtdr-two-third">
            <?php $dtdr_numberof_incharges= get_post_meta($post_id, 'dtdr_numberof_incharges', true); ?>
            <input type="number" name="dtdr_numberof_incharges" value="<?php echo esc_attr($dtdr_numberof_incharges); ?>" min="-1" max="100" />
            <div class="dtdr-note">
                <?php
                echo sprintf( esc_html__('Number of %1$s allowed to add', 'dtdr'), strtolower($incharge_plural_label) );
                echo "<br>";
                echo sprintf( esc_html__('-1 for Unlimited %1$s', 'dtdr'), strtolower($incharge_plural_label) );
                ?>
            </div>
        </div>

    </div>

    <div class="dtdr-column dtdr-one-half">

        <div class="dtdr-column dtdr-one-third first">
           <label><?php echo esc_html__('Number of Images allowed', 'dtdr'); ?></label>
        </div>
        <div class="dtdr-column dtdr-two-third">
            <?php $dtdr_numberof_images= get_post_meta($post_id, 'dtdr_numberof_images', true); ?>
            <input type="number" name="dtdr_numberof_images" value="<?php echo esc_attr($dtdr_numberof_images); ?>" min="-1" />
            <div class="dtdr-note">
                <?php
                echo esc_html__('Number of Images allowed to add.', 'dtdr');
                echo "<br>";
                echo esc_html__('-1 for Unlimited images.', 'dtdr');
                ?>
            </div>
        </div>

    </div>

</div>

<div class="dtdr-custom-box">

    <div class="dtdr-column dtdr-one-half first">

        <div class="dtdr-column dtdr-one-third first">
           <label><?php echo esc_html__('Additional Features', 'dtdr'); ?></label>
        </div>
        <div class="dtdr-column dtdr-two-third">
            <?php $dtdr_additional_features= get_post_meta($post_id, 'dtdr_additional_features', true); ?>
            <textarea name="dtdr_additional_features" rows="8"><?php echo dtdr_html_output($dtdr_additional_features); ?></textarea>
            <div class="dtdr-note">
                <?php echo esc_html__('Additional features you like to add for your package. Just add it in simple <ul><li> list.', 'dtdr'); ?>
            </div>
        </div>

    </div>

    <div class="dtdr-column dtdr-one-half">

    </div>

</div>