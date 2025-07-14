<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Email', 'dtsl'); ?></label>
    <?php $dtsl_email = get_post_meta($list_id, 'dtsl_email', true); ?>
    <input name="dtsl_email" type="text" value="<?php echo esc_attr($dtsl_email); ?>" />
    <div class="dtsl-note"><?php echo sprintf( esc_html__('Add contact email for your %1$s here.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ); ?> </div>

</div>

<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Phone', 'dtsl'); ?></label>
    <?php $dtsl_phone = get_post_meta($list_id, 'dtsl_phone', true); ?>
    <input name="dtsl_phone" type="text" value="<?php echo esc_attr($dtsl_phone); ?>" />
    <div class="dtsl-note"><?php echo sprintf( esc_html__('Add contact phone number for your %1$s here.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ); ?> </div>

</div>

<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Mobile', 'dtsl'); ?></label>
    <?php $dtsl_mobile = get_post_meta($list_id, 'dtsl_mobile', true); ?>
    <input name="dtsl_mobile" type="text" value="<?php echo esc_attr($dtsl_mobile); ?>" />
    <div class="dtsl-note"><?php echo sprintf( esc_html__('Add contact mobile number for your %1$s here.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ); ?> </div>

</div>

<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Skype', 'dtsl'); ?></label>
    <?php $dtsl_skype = get_post_meta($list_id, 'dtsl_skype', true); ?>
    <input name="dtsl_skype" type="text" value="<?php echo esc_attr($dtsl_skype); ?>" />
    <div class="dtsl-note"><?php echo sprintf( esc_html__('Add contact skype id for your %1$s here.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ); ?> </div>

</div>

<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Website', 'dtsl'); ?></label>
    <?php $dtsl_website = get_post_meta($list_id, 'dtsl_website', true); ?>
    <input name="dtsl_website" type="text" value="<?php echo esc_attr($dtsl_website); ?>" />
    <div class="dtsl-note"><?php echo sprintf( esc_html__('Add website address for your %1$s here.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ); ?> </div>

</div>

<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Social Details', 'dtsl'); ?></label>
    <?php echo dtsl_social_details_field($list_id, 'list'); ?>

</div>