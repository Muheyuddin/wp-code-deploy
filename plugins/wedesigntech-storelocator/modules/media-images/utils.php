<?php

// Dashboard Media Field
if(!function_exists('dtsl_listing_upload_media_field')) {
    function dtsl_listing_upload_media_field($item_id) {

        $output = '';

        $dtsl_media_images_ids = $dtsl_media_images_titles = array ();
        $dtsl_featured_image_id = -1;
        if($item_id > 0) {
            $dtsl_media_images_ids    = get_post_meta($item_id, 'dtsl_media_images_ids', true);
            $dtsl_media_images_titles = get_post_meta($item_id, 'dtsl_media_images_titles', true);
            $dtsl_featured_image_id   = get_post_thumbnail_id($item_id);
        }

        $output .= '<div class="dtsl-upload-media-items-container">';

            if(is_array($dtsl_media_images_ids) && !empty($dtsl_media_images_ids)) {

                $output .= '<div class="dtsl-upload-media-items-holder">';
                    $output .= '<ul class="dtsl-upload-media-items">';

                        $i = 0;
                        foreach($dtsl_media_images_ids as $dtsl_media_attachments_id) {
                            if($dtsl_media_attachments_id != '') {
                                $dtsl_media_title = '';
                                if(isset($dtsl_media_images_titles[$i])) {
                                    $dtsl_media_title = $dtsl_media_images_titles[$i];
                                }
                                $thumbnail_url = wp_get_attachment_image_src($dtsl_media_attachments_id, 'thumbnail');
                                $featured_item_class = 'far fa-user';
                                if($dtsl_featured_image_id == $dtsl_media_attachments_id) {
                                    $featured_item_class = 'fa fa-user';
                                }
                                $output .= '<li>
                                                <img src="'.esc_url($thumbnail_url[0]).'" title="'.esc_html__('Media Title', 'dtsl').'" all="'.esc_html__('Media Title', 'dtsl').'" />
                                                <input name="dtsl_media_attachment_ids[]" type="hidden" class="uploadfieldid hidden" readonly value="'.$dtsl_media_attachments_id.'"/>
                                                <input name="dtsl_media_attachment_titles[]" type="text" class="media-attachment-titles" value="'.$dtsl_media_title.'"/>
                                                <span class="dtsl-remove-media-item"><span class="fas fa-times"></span></span>
                                                <span class="dtsl-featured-media-item"><span class="'.$featured_item_class.'"></span></span>
                                            </li>';
                                $i++;
                            }
                        }

                    $output .= '</ul>';
                $output .= '</div>';

            }

            $output .= '<input type="hidden" value="'.esc_attr($dtsl_featured_image_id).'" name="dtsl_featured_image_id" id="dtsl_featured_image_id" />';

            $output .= '<input type="button" value="'.esc_html__('Upload Media', 'dtsl').'" class="dtsl-upload-media-item-button multiple" />';
            $output .= '<input type="button" value="'.esc_html__('Remove Media', 'dtsl').'" class="dtsl-upload-media-item-reset" />';

        $output .= '</div>';

        return $output;

    }
}

?>