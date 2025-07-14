<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Page Template', 'dtsl'); ?></label>
    <?php echo dtsl_listing_page_template_field($list_id, true); ?>

</div>

<div class="dtsl-custom-box">

    <label><?php echo esc_html__('MLS Number', 'dtsl'); ?></label>
    <?php $dtsl_mls_number = get_post_meta($list_id, 'dtsl_mls_number', true); ?>
    <input name="dtsl_mls_number" type="text" value="<?php echo esc_attr($dtsl_mls_number); ?>" class="dtsl-mls-number" style="text-transform:uppercase" />
    <input type="button" value="<?php echo esc_attr__('Generate', 'dtsl'); ?>" class="dtsl-generate-mls-number" />
    <div class="dtsl-note"><?php echo sprintf( esc_html__('Add MLS number for your %1$s here.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ); ?> </div>

</div>

<?php if(defined('DTSL_USERS_PLUGIN_PATH')) { ?>
    <div class="dtsl-custom-box">

        <label><?php echo sprintf( esc_html__( '%1$s', 'dtsl' ), $incharge_singular_label ); ?></label>
        <?php echo dtsl_listing_incharge_field($list_id, 'admin'); ?>
        <div class="dtsl-note"><?php echo sprintf( esc_html__('If you like to add %1$s for this %2$s, you can choose here.', 'dtsl'), strtolower($incharge_singular_label), strtolower($dt_sl_listing_singular_label) ); ?> </div>

    </div>
<?php } ?>

<?php
if((int)$author_id == (int)$user_id) {
    ?>
    <div class="dtsl-custom-box">
        <label><?php echo esc_html__('Featured Item', 'dtsl'); ?></label>
        <?php
        $dtsl_featured_item = get_post_meta($list_id, 'dtsl_featured_item', true);
        $switchclass = ($dtsl_featured_item == 'true') ? 'checkbox-switch-on' : 'checkbox-switch-off';
        $checked = ($dtsl_featured_item == 'true') ? ' checked="checked"' : '';
        ?>
        <div data-for="dtsl_featured_item" class="dtsl-checkbox-switch <?php echo esc_attr($switchclass); ?>"></div>
        <input id="dtsl_featured_item" class="hidden" type="checkbox" name="dtsl_featured_item" value="true" <?php echo dtsl_html_output($checked); ?> />
        <div class="dtsl-note"> <?php echo esc_html__('If you like to set this item as featured, choose "Yes"', 'dtsl'); ?> </div>
    </div>
    <?php
}
?>

<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Excerpt Title', 'dtsl'); ?></label>
    <?php $dtsl_excerpt_title = get_post_meta($list_id, 'dtsl_excerpt_title', true); ?>
    <input name="dtsl_excerpt_title" type="text" value="<?php echo esc_attr($dtsl_excerpt_title); ?>" class="dtsl-except-title" />
    <div class="dtsl-note"><?php echo sprintf( esc_html__('Add Excerpt title for your %1$s here.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ); ?> </div>

</div>