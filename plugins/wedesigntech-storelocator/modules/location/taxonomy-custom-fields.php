<?php

if( !class_exists('DTStoreLocatorLocationTaxonomyCustomFields') ) {

	class DTStoreLocatorLocationTaxonomyCustomFields {

		/**
		 * Instance variable
		 */
		private static $_instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 */
		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		function __construct() {

			$taxonomies = apply_filters( 'dtsl_taxonomies', array () );

			foreach($taxonomies as $taxonomy => $taxonomy_label) {
				add_action ( $taxonomy.'_add_form_fields', array ( $this, 'dtsl_add_taxonomy_form_fields' ), 10, 2 );
				add_action ( 'created_'.$taxonomy, array ( $this, 'dtsl_save_taxonomy_form_fields' ), 10, 2 );
				add_action ( $taxonomy.'_edit_form_fields', array ( $this, 'dtsl_update_taxonomy_form_fields' ), 10, 2 );
				add_action ( 'edited_'.$taxonomy, array ( $this, 'dtsl_updated_taxonomy_form_fields' ), 10, 2 );
			}

		}

		function dtsl_add_taxonomy_form_fields ( $taxonomy ) {

			echo '<div class="form-field term-group">
					<label for="taxonomy-map-image">'.esc_html__('Map Image', 'dtsl').'</label>
					<div class="dtsl-upload-media-items-container">
						<input name="dtsl-taxonomy-map-image-url" type="hidden" class="uploadfieldurl" readonly value=""/>
						<input name="dtsl-taxonomy-map-image-id" type="hidden" class="uploadfieldid" readonly value=""/>
						<input type="button" value="'.esc_html__( 'Add Image', 'dtsl' ).'" class="dtsl-upload-media-item-button show-preview with-image-holder" />
						'.dtsl_adminpanel_image_preview('').'
					</div>
					<p>'.esc_html__('This image will be used in Maps.', 'dtsl').'</p>
				</div>';

		}

		function dtsl_save_taxonomy_form_fields ( $term_id, $tt_id ) {

			if( isset( $_POST['dtsl-taxonomy-map-image-url'] ) ){
				$image_url = dtsl_recursive_sanitize_text_field ($_POST['dtsl-taxonomy-map-image-url']);
				add_term_meta( $term_id, 'dtsl-taxonomy-map-image-url', $image_url, true );
			}

			if( isset( $_POST['dtsl-taxonomy-map-image-id'] ) ){
				$image_id = dtsl_recursive_sanitize_text_field ($_POST['dtsl-taxonomy-map-image-id']);
				add_term_meta( $term_id, 'dtsl-taxonomy-map-image-id', $image_url, true );
			}

		}

		function dtsl_update_taxonomy_form_fields ( $term, $taxonomy ) {

			echo '<tr class="form-field term-group-wrap">
					<th scope="row">
						<label for="taxonomy-map-image">'.esc_html__('Map Image', 'dtsl').'</label>
					</th>
					<td>';
						$image_url = get_term_meta( $term->term_id, 'dtsl-taxonomy-map-image-url', true );
						$image_id = get_term_meta( $term->term_id, 'dtsl-taxonomy-map-image-id', true );
					echo '<div class="dtsl-upload-media-items-container">
							<input name="dtsl-taxonomy-map-image-url" type="hidden" class="uploadfieldurl" readonly value="'.$image_url.'"/>
							<input name="dtsl-taxonomy-map-image-id" type="hidden" class="uploadfieldid" readonly value="'.$image_id.'"/>
							<input type="button" value="'.esc_html__( 'Add Image', 'dtsl' ).'" class="dtsl-upload-media-item-button show-preview with-image-holder" />
							<input type="button" value="'.esc_html__('Remove Image', 'dtsl').'" class="dtsl-upload-media-item-reset" />
							'.dtsl_adminpanel_image_preview($image_url).'
						</div>
						<p>'.esc_html__('This image will be used in Maps.', 'dtsl').'</p>
					</td>
				</tr>';

		}

		function dtsl_updated_taxonomy_form_fields ( $term_id, $tt_id ) {

			//Don't update on Quick Edit
			if (defined('DOING_AJAX') ) {
				return $post_id;
			}

			if( isset( $_POST['dtsl-taxonomy-map-image-url'] ) && '' !== $_POST['dtsl-taxonomy-map-image-url'] ){
				$image_url = dtsl_recursive_sanitize_text_field ($_POST['dtsl-taxonomy-map-image-url']);
				update_term_meta ( $term_id, 'dtsl-taxonomy-map-image-url', $image_url );
			} else {
				update_term_meta ( $term_id, 'dtsl-taxonomy-map-image-url', '' );
			}

			if( isset( $_POST['dtsl-taxonomy-map-image-id'] ) && '' !== $_POST['dtsl-taxonomy-map-image-id'] ){
				$image_id = dtsl_recursive_sanitize_text_field ($_POST['dtsl-taxonomy-map-image-id']);
				update_term_meta ( $term_id, 'dtsl-taxonomy-map-image-id', $image_id );
			} else {
				update_term_meta ( $term_id, 'dtsl-taxonomy-map-image-id', '' );
			}

		}


	}

	DTStoreLocatorLocationTaxonomyCustomFields::instance();

}

?>