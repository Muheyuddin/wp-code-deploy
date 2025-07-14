<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Map Image', 'dtsl'); ?></label>
    <?php echo dtsl_upload_promoflash_image($list_id); ?>
    <div class="dtsl-note"><?php echo esc_html__('This image will be used for map icon.', 'dtsl'); ?> </div>

</div>

<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Address', 'dtsl'); ?></label>
    <?php $dtsl_address = get_post_meta($list_id, 'dtsl_address', true); ?>
    <input name="dtsl_address" id="dtsl_address" type="text" value="<?php echo esc_attr($dtsl_address);?>" />
    <div class="dtsl-note"><?php echo sprintf( esc_html__('Add address for your %1$s here.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ); ?> </div>

</div>

<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Zip', 'dtsl'); ?></label>
    <?php $dtsl_zip = get_post_meta($list_id, 'dtsl_zip', true); ?>
    <input name="dtsl_zip" type="text" value="<?php echo esc_attr($dtsl_zip);?>" />
    <div class="dtsl-note"><?php echo sprintf( esc_html__('Add zip code for your %1$s here.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ); ?> </div>

</div>

<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Country', 'dtsl'); ?></label>
    <?php $dtsl_country = get_post_meta($list_id, 'dtsl_country', true); ?>
    <select name="dtsl_country" class="dtsl-chosen-select">
        <?php
        $countries_list = dtsl_countries_list(true);
        foreach( $countries_list as $key => $country ):
            echo '<option value="'.$key.'" '.selected($dtsl_country, $key, false).'>'.$country.'</option>';
        endforeach;
        ?>
    </select>
    <div class="dtsl-note"><?php echo sprintf( esc_html__('Choose country for your %1$s here.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ); ?> </div>

</div>

<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Latitude', 'dtsl'); ?></label>
    <input name="dtsl_latitude" type="text" value="<?php echo esc_attr($dtsl_latitude);?>" id="dtsl_latitude" />
    <div class="dtsl-note"><?php echo sprintf( esc_html__('Add latitude value of your %1$s location here.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ); ?> </div>

</div>

<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Longitude', 'dtsl'); ?></label>
    <input name="dtsl_longitude" type="text" value="<?php echo esc_attr($dtsl_longitude);?>" id="dtsl_longitude" />
    <div class="dtsl-note"><?php echo sprintf( esc_html__('Add longitude value of your %1$s location here.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ); ?> </div>

</div>

<div class="dtsl-custom-box">

    <div id="dtsl-addlist-map-holder"></div>
    <div class="dtsl-note"><?php echo esc_html__('You can also drag and place marker to identify your location.', 'dtsl'); ?></div>

</div>