<?php

// Dashboard Attachments Field
if(!function_exists('dtsl_listing_attachments_field')) {
    function dtsl_listing_attachments_field($item_id) {

        $output = '';

        $output .= '<div class="dtsl-attachments-box-container">';

            $output .= '<div class="dtsl-attachments-box-item-holder">';

                $dtsl_media_attachments_titles = $dtsl_media_attachments_items = '';
                if($item_id > 0) {
                    $dtsl_media_attachments_titles = get_post_meta($item_id, 'dtsl_media_attachments_titles', true);
                    $dtsl_media_attachments_items  = get_post_meta($item_id, 'dtsl_media_attachments_items', true);
                }

                $j = 0;
                if(is_array($dtsl_media_attachments_titles) && !empty($dtsl_media_attachments_titles)) {
                    foreach($dtsl_media_attachments_titles as $dtsl_media_attachments_title) {

                        $attachment_url = wp_get_attachment_url($dtsl_media_attachments_items[$j]);

                        $output .= '<div class="dtsl-attachments-box-item">
                                        <div class="dtsl-column dtsl-one-column first">
                                            <input name="dtsl_media_attachments_titles[]" class="dtsl_media_attachments_titles" type="text" value="'.esc_attr($dtsl_media_attachments_title).'" placeholder="'.esc_html__('Title', 'dtsl').'" />
                                        </div>
                                        <div class="dtsl-column dtsl-one-column first dtsl-upload-media-items-container">
                                            <input name="dtsl_media_attachments_items_url" type="text" value="'.esc_url($attachment_url).'" placeholder="'.esc_html__('Item', 'dtsl').'" class="uploadfieldurl" readonly />
                                            <input name="dtsl_media_attachments_items[]" type="hidden" value="'.esc_attr($dtsl_media_attachments_items[$j]).'" placeholder="'.esc_html__('Item', 'dtsl').'" class="uploadfieldid" readonly />
                                            <input type="button" value="'.esc_html__('Upload', 'dtsl').'" class="dtsl-upload-media-item-button show-preview" />
                                            <input type="button" value="'.esc_html__('Remove', 'dtsl').'" class="dtsl-upload-media-item-reset" />
                                        </div>
                                        <div class="dtsl-attachments-box-options">
                                            <span class="dtsl-remove-attachments"><span class="fas fa-times"></span></span>
                                            <span class="dtsl-sort-attachments"><span class="fas fa-arrows-alt"></span></span>
                                        </div>
                                    </div>';
                        $j++;
                    }
                }

            $output .= '</div>';

            $output .= '<a href="#" class="dtsl-add-attachments-box custom-button-style">'.esc_html__('Add Attachment', 'dtsl').'</a>';

            $output .= '<div class="dtsl-attachments-box-item-toclone hidden">
                            <div class="dtsl-column dtsl-one-column first">
                                <input id="dtsl_media_attachments_titles" type="text" placeholder="'.esc_html__('Title', 'dtsl').'" />
                            </div>
                            <div class="dtsl-column dtsl-one-column first dtsl-upload-media-items-container">
                                <input name="dtsl_media_attachments_items_url" type="text" placeholder="'.esc_html__('Item', 'dtsl').'" class="uploadfieldurl" readonly />
                                <input id="dtsl_media_attachments_items" type="hidden" placeholder="'.esc_html__('Item', 'dtsl').'" class="uploadfieldid" readonly />
                                <input type="button" value="'.esc_html__('Upload', 'dtsl').'" class="dtsl-upload-media-item-button show-preview" />
                                <input type="button" value="'.esc_html__('Remove', 'dtsl').'" class="dtsl-upload-media-item-reset" />
                            </div>
                            <div class="dtsl-attachments-box-options">
                                <span class="dtsl-remove-attachments"><span class="fas fa-times"></span></span>
                                <span class="dtsl-sort-attachments"><span class="fas fa-arrows-alt"></span></span>
                            </div>
                        </div>';

        $output .= '</div>';

        return $output;

    }
}

?>