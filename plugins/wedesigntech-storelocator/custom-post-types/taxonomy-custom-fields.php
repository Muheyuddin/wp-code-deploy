<?php

if( !class_exists('DTStoreLocatorTaxonomyCustomFields') ) {

	class DTStoreLocatorTaxonomyCustomFields {

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

			add_filter ( 'dtsl_taxonomies', array ( $this, 'dtsl_update_taxonomies' ), 10, 1 );

			$taxonomies = apply_filters( 'dtsl_taxonomies', array () );

			foreach($taxonomies as $taxonomy => $taxonomy_label) {
				add_action ( $taxonomy.'_add_form_fields', array ( $this, 'dtsl_add_taxonomy_form_fields' ), 10, 2 );
				add_action ( 'created_'.$taxonomy, array ( $this, 'dtsl_save_taxonomy_form_fields' ), 10, 2 );
				add_action ( $taxonomy.'_edit_form_fields', array ( $this, 'dtsl_update_taxonomy_form_fields' ), 10, 2 );
				add_action ( 'edited_'.$taxonomy, array ( $this, 'dtsl_updated_taxonomy_form_fields' ), 10, 2 );
			}

		}

		function dtsl_update_taxonomies($taxonomies) {

			$dt_sl_amenity_singular_label      = apply_filters( 'dt_sl_amenity_label', 'singular' );
			$dt_sl_contracttype_singular_label = apply_filters( 'dt_sl_contracttype_label', 'singular' );

			$taxonomies['dtsl_listings_category'] = esc_html__('Category', 'dtsl');
			$taxonomies['dtsl_listings_ctype']    = sprintf( esc_html__('%1$s', 'dtsl'), $dt_sl_contracttype_singular_label );
			$taxonomies['dtsl_listings_amenity']  = sprintf( esc_html__('%1$s', 'dtsl'), $dt_sl_amenity_singular_label );

			return $taxonomies;

		}

		function dtsl_add_taxonomy_form_fields ( $taxonomy ) {

			$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

			echo '<div class="form-field term-group">
					<label for="taxonomy-image">'.esc_html__('Image', 'dtsl').'</label>
					<div class="dtsl-upload-media-items-container">
						<input name="dtsl-taxonomy-image-url" type="hidden" class="uploadfieldurl" readonly value=""/>
						<input name="dtsl-taxonomy-image-id" type="hidden" class="uploadfieldid" readonly value=""/>
						<input type="button" value="'.esc_html__( 'Add Image', 'dtsl' ).'" class="dtsl-upload-media-item-button show-preview with-image-holder" />
						'.dtsl_adminpanel_image_preview('').'
					</div>
					<p>'.esc_html__('This image will be used for "Taxonomy" shortcodes.', 'dtsl').'</p>
				</div>';

			echo '<div class="form-field term-group">
					<label for="taxonomy-icon-image">'.esc_html__('Icon Image', 'dtsl').'</label>
					<div class="dtsl-upload-media-items-container">
						<input name="dtsl-taxonomy-icon-image-url" type="hidden" class="uploadfieldurl" readonly value=""/>
						<input name="dtsl-taxonomy-icon-image-id" type="hidden" class="uploadfieldid" readonly value=""/>
						<input type="button" value="'.esc_html__( 'Add Image', 'dtsl' ).'" class="dtsl-upload-media-item-button show-preview with-image-holder" />
						'.dtsl_adminpanel_image_preview('').'
					</div>
					<p>'.sprintf( esc_html__('This icon image will be used in "Taxonomy" shortcodes, %1$s listing & Maps.', 'dtsl'), $dt_sl_listing_singular_label ).'</p>
				</div>';

			echo '<div class="form-field term-group">
					<label for="taxonomy-icon">'.esc_html__('Icon', 'dtsl').'</label>
					<input type="text" name="dtsl-taxonomy-icon" value="">
					<p>'.esc_html__('This icon will be used for both "Taxonomy" shortcodes & Maps.', 'dtsl').'</p>
				</div>';

			echo '<div class="form-field term-group">
					<label for="taxonomy-icon-color">'.esc_html__( 'Icon Color', 'dtsl' ).'</label>
					<input name="dtsl-taxonomy-icon-color" class="dtsl-color-field color-picker" data-alpha="true" type="text" value="" />
					<p>'.esc_html__('This icon color will be used for both "Taxonomy" shortcodes & Maps.', 'dtsl').'</p>
				</div>';

			echo '<div class="form-field term-group">
					<label for="taxonomy-background-color">'.esc_html__( 'Background Color', 'dtsl' ).'</label>
					<input name="dtsl-taxonomy-background-color" class="dtsl-color-field color-picker" data-alpha="true" type="text" value="" />
					<p>'.sprintf( esc_html__('This background color will be used in "Taxonomy" shortcodes, %1$s listing & Maps.', 'dtsl'), $dt_sl_listing_singular_label ).'</p>
				</div>';

			echo '<div class="form-field term-group">
					<label for="taxonomy-text-color">'.esc_html__( 'Text Color', 'dtsl' ).'</label>
					<input name="dtsl-taxonomy-text-color" class="dtsl-color-field color-picker" data-alpha="true" type="text" value="" />
					<p>'.sprintf( esc_html__('This text color will be used in "Taxonomy" shortcodes & %1$s listing.', 'dtsl'), $dt_sl_listing_singular_label ).'</p>
				</div>';

		}

		function dtsl_save_taxonomy_form_fields ( $term_id, $tt_id ) {

			if( isset( $_POST['dtsl-taxonomy-image-url'] ) ){
				$image_url = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-image-url'] );
				add_term_meta( $term_id, 'dtsl-taxonomy-image-url', $image_url, true );
			}

			if( isset( $_POST['dtsl-taxonomy-image-id'] ) ){
				$image_id = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-image-id'] );
				add_term_meta( $term_id, 'dtsl-taxonomy-image-id', $image_id, true );
			}

			if( isset( $_POST['dtsl-taxonomy-icon-image-url'] ) ){
				$image_url = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-icon-image-url'] );
				add_term_meta( $term_id, 'dtsl-taxonomy-icon-image-url', $image_url, true );
			}

			if( isset( $_POST['dtsl-taxonomy-icon-image-id'] ) ){
				$image_id = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-icon-image-id'] );
				add_term_meta( $term_id, 'dtsl-taxonomy-icon-image-id', $image_url, true );
			}

			if( isset( $_POST['dtsl-taxonomy-icon'] ) ){
				$icon = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-icon'] );
				add_term_meta( $term_id, 'dtsl-taxonomy-icon', $icon, true );
			}

			if( isset( $_POST['dtsl-taxonomy-icon-color'] ) ){
				$icon_color = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-icon-color'] );
				add_term_meta( $term_id, 'dtsl-taxonomy-icon-color', $icon_color, true );
			}

			if( isset( $_POST['dtsl-taxonomy-background-color'] ) ){
				$background_color = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-background-color'] );
				add_term_meta( $term_id, 'dtsl-taxonomy-background-color', $background_color, true );
			}

			if( isset( $_POST['dtsl-taxonomy-text-color'] ) ){
				$text_color = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-text-color'] );
				add_term_meta( $term_id, 'dtsl-taxonomy-text-color', $text_color, true );
			}

		}

		function dtsl_update_taxonomy_form_fields ( $term, $taxonomy ) {

			$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

			echo '<tr class="form-field term-group-wrap">
					<th scope="row">
						<label for="taxonomy-image">'.esc_html__('Image', 'dtsl').'</label>
					</th>
					<td>';
						$image_url = get_term_meta( $term->term_id, 'dtsl-taxonomy-image-url', true );
						$image_id = get_term_meta( $term->term_id, 'dtsl-taxonomy-image-id', true );
					echo '<div class="dtsl-upload-media-items-container">
							<input name="dtsl-taxonomy-image-url" type="hidden" class="uploadfieldurl" readonly value="'.$image_url.'"/>
							<input name="dtsl-taxonomy-image-id" type="hidden" class="uploadfieldid" readonly value="'.$image_id.'"/>
							<input type="button" value="'.esc_html__( 'Add Image', 'dtsl' ).'" class="dtsl-upload-media-item-button show-preview with-image-holder" />
							<input type="button" value="'.esc_html__('Remove Image', 'dtsl').'" class="dtsl-upload-media-item-reset" />
							'.dtsl_adminpanel_image_preview($image_url).'
						</div>
						<p>'.esc_html__('This image will be used for "Taxonomy" shortcodes.', 'dtsl').'</p>
					</td>
				</tr>';

			echo '<tr class="form-field term-group-wrap">
					<th scope="row">
						<label for="taxonomy-icon-image">'.esc_html__('Icon Image', 'dtsl').'</label>
					</th>
					<td>';
						$image_url = get_term_meta( $term->term_id, 'dtsl-taxonomy-icon-image-url', true );
						$image_id = get_term_meta( $term->term_id, 'dtsl-taxonomy-icon-image-id', true );
					echo '<div class="dtsl-upload-media-items-container">
							<input name="dtsl-taxonomy-icon-image-url" type="hidden" class="uploadfieldurl" readonly value="'.$image_url.'"/>
							<input name="dtsl-taxonomy-icon-image-id" type="hidden" class="uploadfieldid" readonly value="'.$image_id.'"/>
							<input type="button" value="'.esc_html__( 'Add Image', 'dtsl' ).'" class="dtsl-upload-media-item-button show-preview with-image-holder" />
							<input type="button" value="'.esc_html__('Remove Image', 'dtsl').'" class="dtsl-upload-media-item-reset" />
							'.dtsl_adminpanel_image_preview($image_url).'
						</div>
						<p>'.sprintf( esc_html__('This icon image will be used in "Taxonomy" shortcodes, %1$s listing & Maps.', 'dtsl'), $dt_sl_listing_singular_label ).'</p>
					</td>
				</tr>';

			echo '<tr class="form-field term-group-wrap">
					<th scope="row">
						<label for="taxonomy-icon">'.esc_html__('Icon', 'dtsl').'</label>
					</th>
					<td>';
						$icon = get_term_meta ( $term->term_id, 'dtsl-taxonomy-icon', true );
						echo '<input type="text" name="dtsl-taxonomy-icon" value="'.$icon.'">
						<p>'.esc_html__('This icon will be used for both "Taxonomy" shortcodes & Maps.', 'dtsl').'</p>
					</td>
				</tr>';

			echo '<tr class="form-field term-group-wrap">
					<th scope="row">
						<label for="taxonomy-icon-color">'.esc_html__('Icon Color', 'dtsl').'</label>
					</th>
					<td>';
						$icon_color = get_term_meta ( $term->term_id, 'dtsl-taxonomy-icon-color', true );
						echo '<input name="dtsl-taxonomy-icon-color" class="dtsl-color-field color-picker" data-alpha="true" type="text" value="'.$icon_color.'" />
						<p>'.esc_html__('This icon color will be used for both "Taxonomy" shortcodes & Maps.', 'dtsl').'</p>
					</td>
				</tr>';

			echo '<tr class="form-field term-group-wrap">
					<th scope="row">
						<label for="background-color">'.esc_html__('Background Color', 'dtsl').'</label>
					</th>
					<td>';
						$background_color = get_term_meta ( $term->term_id, 'dtsl-taxonomy-background-color', true );
						echo '<input name="dtsl-taxonomy-background-color" class="dtsl-color-field color-picker" data-alpha="true" type="text" value="'.$background_color.'" />
						<p>'.sprintf( esc_html__('This background color will be used in "Taxonomy" shortcodes, %1$s listing & Maps.', 'dtsl'), $dt_sl_listing_singular_label ).'</p>
					</td>
				</tr>';

			echo '<tr class="form-field term-group-wrap">
					<th scope="row">
						<label for="taxonomy-text-color">'.esc_html__('Text Color', 'dtsl').'</label>
					</th>
					<td>';
						$text_color = get_term_meta ( $term->term_id, 'dtsl-taxonomy-text-color', true );
						echo '<input name="dtsl-taxonomy-text-color" class="dtsl-color-field color-picker" data-alpha="true" type="text" value="'.$text_color.'" />
						<p>'.sprintf( esc_html__('This text color will be used in "Taxonomy" shortcodes & %1$s listing.', 'dtsl'), $dt_sl_listing_singular_label ).'</p>
					</td>
				</tr>';

		}

		function dtsl_updated_taxonomy_form_fields ( $term_id, $tt_id ) {

			//Don't update on Quick Edit
			if (defined('DOING_AJAX') ) {
				return $post_id;
			}

			if( isset( $_POST['dtsl-taxonomy-image-url'] ) && '' !== $_POST['dtsl-taxonomy-image-url'] ){
				$image_url = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-image-url'] );
				update_term_meta ( $term_id, 'dtsl-taxonomy-image-url', $image_url );
			} else {
				update_term_meta ( $term_id, 'dtsl-taxonomy-image-url', '' );
			}

			if( isset( $_POST['dtsl-taxonomy-image-id'] ) && '' !== $_POST['dtsl-taxonomy-image-id'] ){
				$image_id = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-image-id'] );
				update_term_meta ( $term_id, 'dtsl-taxonomy-image-id', $image_id );
			} else {
				update_term_meta ( $term_id, 'dtsl-taxonomy-image-id', '' );
			}

			if( isset( $_POST['dtsl-taxonomy-icon-image-url'] ) && '' !== $_POST['dtsl-taxonomy-icon-image-url'] ){
				$image_url = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-icon-image-url'] );
				update_term_meta ( $term_id, 'dtsl-taxonomy-icon-image-url', $image_url );
			} else {
				update_term_meta ( $term_id, 'dtsl-taxonomy-icon-image-url', '' );
			}

			if( isset( $_POST['dtsl-taxonomy-icon-image-id'] ) && '' !== $_POST['dtsl-taxonomy-icon-image-id'] ){
				$image_id = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-icon-image-id'] );
				update_term_meta ( $term_id, 'dtsl-taxonomy-icon-image-id', $image_id );
			} else {
				update_term_meta ( $term_id, 'dtsl-taxonomy-icon-image-id', '' );
			}

			if( isset( $_POST['dtsl-taxonomy-icon'] ) && '' !== $_POST['dtsl-taxonomy-icon'] ){
				$icon = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-icon'] );
				update_term_meta ( $term_id, 'dtsl-taxonomy-icon', $icon );
			} else {
				update_term_meta ( $term_id, 'dtsl-taxonomy-icon', '' );
			}

			if( isset( $_POST['dtsl-taxonomy-icon-color'] ) && '' !== $_POST['dtsl-taxonomy-icon-color'] ){
				$icon_color = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-icon-color'] );
				update_term_meta ( $term_id, 'dtsl-taxonomy-icon-color', $icon_color );
			} else {
				update_term_meta ( $term_id, 'dtsl-taxonomy-icon-color', '' );
			}

			if( isset( $_POST['dtsl-taxonomy-background-color'] ) && '' !== $_POST['dtsl-taxonomy-background-color'] ){
				$background_color = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-background-color'] );
				update_term_meta ( $term_id, 'dtsl-taxonomy-background-color', $background_color );
			} else {
				update_term_meta ( $term_id, 'dtsl-taxonomy-background-color', '' );
			}

			if( isset( $_POST['dtsl-taxonomy-text-color'] ) && '' !== $_POST['dtsl-taxonomy-text-color'] ){
				$text_color = dtsl_recursive_sanitize_text_field ( $_POST['dtsl-taxonomy-text-color'] );
				update_term_meta ( $term_id, 'dtsl-taxonomy-text-color', $text_color );
			} else {
				update_term_meta ( $term_id, 'dtsl-taxonomy-text-color', '' );
			}

		}


	}

	DTStoreLocatorTaxonomyCustomFields::instance();

}

?>