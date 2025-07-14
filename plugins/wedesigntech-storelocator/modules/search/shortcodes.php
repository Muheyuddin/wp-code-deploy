<?php
if( !class_exists('DTStoreLocatorSearchFormShortcodes') ) {

	class DTStoreLocatorSearchFormShortcodes {

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

			add_shortcode ( 'dtsl_sf_keyword_field', array ( $this, 'dtsl_sf_keyword_field' ) );
			add_shortcode ( 'dtsl_sf_categories_field', array ( $this, 'dtsl_sf_categories_field' ) );
			add_shortcode ( 'dtsl_sf_tags_field', array ( $this, 'dtsl_sf_tags_field' ) );
			add_shortcode ( 'dtsl_sf_ctype_field', array ( $this, 'dtsl_sf_ctype_field' ) );
			add_shortcode ( 'dtsl_sf_features_field', array ( $this, 'dtsl_sf_features_field' ) );
			add_shortcode ( 'dtsl_sf_orderby_field', array ( $this, 'dtsl_sf_orderby_field' ) );
			add_shortcode ( 'dtsl_sf_mls_number_field', array ( $this, 'dtsl_sf_mls_number_field' ) );

			add_shortcode ( 'dtsl_sf_submit_button', array ( $this, 'dtsl_sf_submit_button' ) );

			add_shortcode ( 'dtsl_sf_output_data_container', array ( $this, 'dtsl_sf_output_data_container' ) );

		}

		function dtsl_shortcodeHelper($content = null) {
			$content = do_shortcode ( shortcode_unautop ( $content ) );
			$content = preg_replace ( '#^<\/p>|^<br \/>|<p>$#', '', $content );
			$content = preg_replace ( '#<br \/>#', '', $content );
			return trim ( $content );
		}

		function dtsl_sf_keyword_field( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'placeholder_text' => '',
						'ajax_load' => '',
						'class' => '',

					), $attrs, 'dtsl_sf_keyword_field' );


			$output = '';

			$output .= '<div class="dtsl-sf-fields-holder dtsl-sf-keyword-field-holder '.$attrs['class'].'">';

				$additional_class = '';
				if($attrs['ajax_load'] == 'true') {
					$additional_class = 'dtsl-with-ajax-load';
				}

				$placeholder_text = esc_html__('Keyword', 'dtsl');
				if($attrs['placeholder_text'] != '') {
					$placeholder_text = esc_html($attrs['placeholder_text']);
				}

				$dtsl_sf_keyword = '';
				if(isset($_REQUEST['dtsl_sf_keyword']) && $_REQUEST['dtsl_sf_keyword'] != '') {
					$dtsl_sf_keyword = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_keyword']);
				}

				$output .= '<input name="dtsl_sf_keyword" class="dtsl-sf-field dtsl-sf-keyword '.esc_attr($additional_class).'" type="text" value="'.esc_attr($dtsl_sf_keyword).'" placeholder="'.esc_attr($placeholder_text).'" />';
				$output .= '<span></span>';

			$output .= '</div>';

			return $output;

		}

		function dtsl_sf_categories_field( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'field_type'              => '',
						'placeholder_text'        => '',
						'dropdown_type'           => '',
						'ajax_load'               => '',
						'default_item_id'         => '',
						'show_parent_items_alone' => 'false',
						'child_of'                => '',
						'class'                   => '',

					), $attrs, 'dtsl_sf_categories_field' );


			$output = '';

			$output .= '<div class="dtsl-sf-fields-holder dtsl-sf-categories-field-holder '.$attrs['class'].'">';

				$additional_class = '';
				if($attrs['ajax_load'] == 'true') {
					$additional_class = 'dtsl-with-ajax-load';
				}

				$dtsl_sf_categories = array ();
				if(isset($_REQUEST['dtsl_sf_categories'])) {
					if(is_array($_REQUEST['dtsl_sf_categories']) && !empty($_REQUEST['dtsl_sf_categories'])) {
						$dtsl_sf_categories = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_categories']);
					} else if($_REQUEST['dtsl_sf_categories'] != '') {
						$dtsl_sf_categories = explode(',', dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_categories']));
					}
				} elseif($attrs['default_item_id'] != '') {
					$dtsl_sf_categories = explode(',', dtsl_recursive_sanitize_text_field($attrs['default_item_id']));
				}

				$placeholder_text = esc_html__('Categories', 'dtsl');
				if($attrs['placeholder_text'] != '') {
					$placeholder_text = esc_html($attrs['placeholder_text']);
				}

				if($attrs['field_type'] == 'dropdown') {

					$mulitple_attr = '';
					if($attrs['dropdown_type'] == 'multiple') {
						$mulitple_attr = 'multiple';
					}

					$output .= '<select class="dtsl-sf-field dtsl-sf-categories '.esc_attr($additional_class).' dtsl-chosen-select" name="dtsl_sf_categories" data-placeholder="'.esc_attr($placeholder_text).'" '.esc_attr($mulitple_attr).'>';
						if($mulitple_attr == '') {
							$output .= '<option value="">'.esc_attr($placeholder_text).'</option>';
						}

						$categories_args = array (
							'taxonomy'   => 'dtsl_listings_category',
							'hide_empty' => 1,
						);

						if($attrs['child_of'] != '') {
							$categories_args['child_of'] = $attrs['child_of'];
						} else {
							$categories_args['parent'] = 0;
						}
						$listing_categories = get_categories($categories_args);

						if(is_array($listing_categories) && !empty($listing_categories)) {
							foreach($listing_categories as $listing_category) {
								$selected_attr = '';
								if(in_array($listing_category->term_id, $dtsl_sf_categories)) {
									$selected_attr = 'selected="selected"';
								}
								$output .= '<option value="'.esc_attr($listing_category->term_id).'" '.$selected_attr.'>'.esc_html($listing_category->name).'</option>';

								if($attrs['show_parent_items_alone'] != 'true') {

									// Child Items
									$listing_category_childs = get_categories('taxonomy=dtsl_listings_category&hide_empty=1&child_of='.$listing_category->term_id);
									if(is_array($listing_category_childs) && !empty($listing_category_childs)) {
										foreach($listing_category_childs as $listing_category_child) {
											$selected_attr = '';
											if(in_array($listing_category_child->term_id, $dtsl_sf_categories)) {
												$selected_attr = 'selected="selected"';
											}
											$output .= '<option value="'.esc_attr($listing_category_child->term_id).'" '.$selected_attr.'>'."&emsp;".esc_html($listing_category_child->name).'</option>';
										}
									}

								}

							}
						}
					$output .= '</select>';

				} else {

					$output .= '<ul>';
						$listing_categories = get_categories('taxonomy=dtsl_listings_category&hide_empty=1');
						if(isset($listing_categories)) {
							foreach($listing_categories as $listing_category) {
								$output .= '<li>
												<input type="checkbox" name="dtsl_sf_categories[]" class="dtsl-sf-field dtsl-sf-categories '.esc_attr($additional_class).'" value="'.esc_attr($listing_category->term_id).'" id="dtsl-sf-category-'.esc_attr($listing_category->term_id).'" '.checked(in_array($listing_category->term_id, $dtsl_sf_categories), true, false).' />
												<label for="dtsl-sf-category-'.esc_attr($listing_category->term_id).'">'.esc_html($listing_category->name).'</label>
											</li>';
							}
						}
					$output .= '</ul>';

				}

			$output .= '</div>';

			return $output;

		}

		function dtsl_sf_tags_field( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'field_type' => '',
						'placeholder_text' => '',
						'dropdown_type' => '',
						'ajax_load' => '',
						'class' => '',

					), $attrs, 'dtsl_sf_tags_field' );


			$output = '';

			$output .= '<div class="dtsl-sf-fields-holder dtsl-sf-tags-field-holder '.$attrs['class'].'">';

				$additional_class = '';
				if($attrs['ajax_load'] == 'true') {
					$additional_class = 'dtsl-with-ajax-load';
				}

				$dtsl_sf_tags = array ();
				if(isset($_REQUEST['dtsl_sf_tags'])) {
					if(is_array($_REQUEST['dtsl_sf_tags']) && !empty($_REQUEST['dtsl_sf_tags'])) {
						$dtsl_sf_tags = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_tags']);
					} else if($_REQUEST['dtsl_sf_tags'] != '') {
						$dtsl_sf_tags = explode(',', dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_tags']));
					}
				}

				$amenity_plural_label = apply_filters( 'dt_sl_amenity_label', 'plural' );

				$placeholder_text = $amenity_plural_label;
				if($attrs['placeholder_text'] != '') {
					$placeholder_text = esc_html($attrs['placeholder_text']);
				}

				if($attrs['field_type'] == 'dropdown') {

					$mulitple_attr = '';
					if($attrs['dropdown_type'] == 'multiple') {
						$mulitple_attr = 'multiple';
					}

					$output .= '<select class="dtsl-sf-field dtsl-sf-tags '.esc_attr($additional_class).' dtsl-chosen-select" name="dtsl_sf_tags" data-placeholder="'.esc_attr($placeholder_text).'" '.esc_attr($mulitple_attr).'>';
						if($mulitple_attr == '') {
							$output .= '<option value="">'.esc_attr($placeholder_text).'</option>';
						}
						$listing_tags = get_categories('taxonomy=dtsl_listings_amenity&hide_empty=1');
						if(isset($listing_tags)) {
							foreach($listing_tags as $listing_tag) {
								$selected_attr = '';
								if(in_array($listing_tag->term_id, $dtsl_sf_tags)) {
									$selected_attr = 'selected="selected"';
								}
								$output .= '<option value="'.esc_attr($listing_tag->term_id).'" '.$selected_attr.'>'.esc_html($listing_tag->name).'</option>';
							}
						}
					$output .= '</select>';

				} else {

					$output .= '<ul>';
						$listing_tags = get_categories('taxonomy=dtsl_listings_amenity&hide_empty=1');
						if(isset($listing_tags)) {
							foreach($listing_tags as $listing_tag) {
								$output .= '<li>
												<input type="checkbox" name="dtsl_sf_tags[]" class="dtsl-sf-field dtsl-sf-tags '.esc_attr($additional_class).'" value="'.esc_attr($listing_tag->term_id).'" id="dtsl-sf-tag-'.esc_attr($listing_tag->term_id).'" '.checked(in_array($listing_tag->term_id, $dtsl_sf_tags), true, false).' />
												<label for="dtsl-sf-tag-'.esc_attr($listing_tag->term_id).'">'.esc_html($listing_tag->name).'</label>
											</li>';
							}
						}
					$output .= '</ul>';

				}

			$output .= '</div>';

			return $output;

		}

		function dtsl_sf_ctype_field( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'field_type'              => '',
						'placeholder_text'        => '',
						'dropdown_type'           => '',
						'ajax_load'               => '',
						'default_item_id'         => '',
						'show_parent_items_alone' => 'false',
						'child_of'                => '',
						'class'                   => '',

					), $attrs, 'dtsl_sf_ctype_field' );


			$output = '';

			$output .= '<div class="dtsl-sf-fields-holder dtsl-sf-ctype-field-holder '.$attrs['class'].'">';

				$additional_class = '';
				if($attrs['ajax_load'] == 'true') {
					$additional_class = 'dtsl-with-ajax-load';
				}

				$dtsl_sf_ctype = array ();
				if(isset($_REQUEST['dtsl_sf_ctype'])) {
					if(is_array($_REQUEST['dtsl_sf_ctype']) && !empty($_REQUEST['dtsl_sf_ctype'])) {
						$dtsl_sf_ctype = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_ctype']);
					} else if($_REQUEST['dtsl_sf_ctype'] != '') {
						$dtsl_sf_ctype = explode(',', dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_ctype']));
					}
				} elseif($attrs['default_item_id'] != '') {
					$dtsl_sf_ctype = explode(',', dtsl_recursive_sanitize_text_field($attrs['default_item_id']));
				}

				$contracttype_plural_label = apply_filters( 'dt_sl_contracttype_label', 'plural' );

				$placeholder_text = $contracttype_plural_label;
				if($attrs['placeholder_text'] != '') {
					$placeholder_text = esc_html($attrs['placeholder_text']);
				}


				if($attrs['field_type'] == 'dropdown') {

					$mulitple_attr = '';
					if($attrs['dropdown_type'] == 'multiple') {
						$mulitple_attr = 'multiple';
					}

					$output .= '<select class="dtsl-sf-field dtsl-sf-ctype '.esc_attr($additional_class).' dtsl-chosen-select" name="dtsl_sf_ctype" data-placeholder="'.esc_attr($placeholder_text).'" '.esc_attr($mulitple_attr).'>';
						if($mulitple_attr == '') {
							$output .= '<option value="">'.esc_attr($placeholder_text).'</option>';
						}

						$ctypes_args = array (
							'taxonomy'   => 'dtsl_listings_ctype',
							'hide_empty' => 1,
						);

						if($attrs['child_of'] != '') {
							$ctypes_args['child_of'] = $attrs['child_of'];
						} else {
							$ctypes_args['parent'] = 0;
						}
						$listing_ctypes = get_categories($ctypes_args);

						if(isset($listing_ctypes)) {
							foreach($listing_ctypes as $listing_ctype) {
								$selected_attr = '';
								if(in_array($listing_ctype->term_id, $dtsl_sf_ctype)) {
									$selected_attr = 'selected="selected"';
								}
								$output .= '<option value="'.esc_attr($listing_ctype->term_id).'" '.$selected_attr.'>'.esc_html($listing_ctype->name).'</option>';

								if($attrs['show_parent_items_alone'] != 'true') {

									// Child Items
									$listing_ctype_childs = get_categories('taxonomy=dtsl_listings_ctype&hide_empty=1&child_of='.$listing_ctype->term_id);
									if(is_array($listing_ctype_childs) && !empty($listing_ctype_childs)) {
										foreach($listing_ctype_childs as $listing_ctype_child) {
											$selected_attr = '';
											if(in_array($listing_ctype_child->term_id, $dtsl_sf_ctype)) {
												$selected_attr = 'selected="selected"';
											}
											$output .= '<option value="'.esc_attr($listing_ctype_child->term_id).'" '.$selected_attr.'>'."&emsp;".esc_html($listing_ctype_child->name).'</option>';
										}
									}

								}

							}
						}
					$output .= '</select>';

				} else {

					$output .= '<ul>';
						$listing_ctypes = get_categories('taxonomy=dtsl_listings_ctype&hide_empty=1');
						if(isset($listing_ctypes)) {
							foreach($listing_ctypes as $listing_ctype) {
								$output .= '<li>
												<input type="checkbox" name="dtsl_sf_ctype[]" class="dtsl-sf-field dtsl-sf-ctype '.esc_attr($additional_class).'" value="'.esc_attr($listing_ctype->term_id).'" id="dtsl-sf-ctype-'.esc_attr($listing_ctype->term_id).'" '.checked(in_array($listing_ctype->term_id, $dtsl_sf_ctype), true, false).' />
												<label for="dtsl-sf-ctype-'.esc_attr($listing_ctype->term_id).'">'.esc_html($listing_ctype->name).'</label>
											</li>';
							}
						}
					$output .= '</ul>';

				}

			$output .= '</div>';

			return $output;

		}

		function dtsl_sf_features_field( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'tab_id'               => '',
						'field_type'           => 'range',
						'placeholder_text'     => '',
						'min_value'            => 1,
						'max_value'            => 100,
						'dropdownlist_options' => '',
						'dropdown_type'        => '',
						'item_unit'            => '',
						'ajax_load'            => '',
						'class'                => '',

					), $attrs, 'dtsl_sf_features_field' );


			$output = '';

			$output .= '<div class="dtsl-sf-fields-holder dtsl-sf-features-field-holder '.$attrs['class'].'">';

				if($attrs['tab_id'] != '') {

					$additional_class = '';
					if($attrs['ajax_load'] == 'true') {
						$additional_class = 'dtsl-with-ajax-load';
					}

					// Tab Id

					$dtsl_sf_features_tab_id = $attrs['tab_id'];
					$tab_id_name = '_tab'.$dtsl_sf_features_tab_id;

					$output .= '<input name="dtsl_sf_features_tab_id" class="dtsl-sf-field dtsl-sf-features-tab-id" type="hidden" value="'.esc_attr($dtsl_sf_features_tab_id).'" />';


					// Item Unit

					$item_unit = $attrs['item_unit'];

					$output .= '<input name="dtsl_sf_features_item_unit" class="dtsl-sf-field dtsl-sf-features-item-unit" type="hidden" value="'.esc_attr($item_unit).'" />';


					// Field Type

					$output .= '<input name="dtsl_sf_features_field_type" class="dtsl-sf-field dtsl-sf-features-field-type" type="hidden" value="'.esc_attr($attrs['field_type']).'" />';


					// Extract Values

					$dtsl_sf_features = array ();
					if(isset($_REQUEST['dtsl_sf_features'.$tab_id_name])) {
						if(is_array($_REQUEST['dtsl_sf_features'.$tab_id_name]) && !empty($_REQUEST['dtsl_sf_features'.$tab_id_name])) {
							$dtsl_sf_features = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_features'.$tab_id_name]);
						} else if($_REQUEST['dtsl_sf_features'.$tab_id_name] != '') {
							$dtsl_sf_features = explode(',', dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_features'.$tab_id_name]));
						}
					}

					// Dropdown / List Options

					$dropdownlist_options = $attrs['dropdownlist_options'];
					$dropdownlist_options = ($dropdownlist_options != '') ? explode(',', $dropdownlist_options) : array ();

					if($attrs['field_type'] == 'dropdown') {

						if(!empty($dropdownlist_options)) {

							$placeholder_text = '';
							if($attrs['placeholder_text'] != '') {
								$placeholder_text = esc_html($attrs['placeholder_text']);
							}

							$mulitple_attr = '';
							if($attrs['dropdown_type'] == 'multiple') {
								$mulitple_attr = 'multiple';
							}

							$output .= '<select class="dtsl-sf-field dtsl-sf-features '.esc_attr($additional_class).' dtsl-chosen-select" name="dtsl_sf_features'.$tab_id_name.'" data-placeholder="'.esc_attr($placeholder_text).'" '.esc_attr($mulitple_attr).'>';
								if($mulitple_attr == '') {
									$output .= '<option value="">'.esc_attr($placeholder_text).'</option>';
								}
								if(isset($dropdownlist_options)) {
									foreach($dropdownlist_options as $dropdownlist_option) {
										$selected_attr = '';
										if(in_array($dropdownlist_option, $dtsl_sf_features)) {
											$selected_attr = 'selected="selected"';
										}
										$output .= '<option value="'.esc_attr($dropdownlist_option).'" '.$selected_attr.'>'.esc_html($dropdownlist_option).'</option>';
									}
								}
							$output .= '</select>';

						}

					} else if($attrs['field_type'] == 'list') {

						if(!empty($dropdownlist_options)) {

							$output .= '<ul>';
								if(isset($dropdownlist_options)) {
									foreach($dropdownlist_options as $dropdownlist_option) {
										$output .= '<li>
														<input type="checkbox" name="dtsl_sf_features'.$tab_id_name.'[]" class="dtsl-sf-field dtsl-sf-features '.esc_attr($additional_class).'" value="'.esc_attr($dropdownlist_option).'" id="dtsl-sf-features-'.esc_attr($dropdownlist_option).'" '.checked(in_array($dropdownlist_option, $dtsl_sf_features), true, false).' />
														<label for="dtsl-sf-features-'.esc_attr($dropdownlist_option).'">'.esc_html($dropdownlist_option).'</label>
													</li>';
									}
								}
							$output .= '</ul>';

						}

					} else {

						$dtsl_sf_features_start = $attrs['min_value'];
						if(isset($_REQUEST['dtsl_sf_features'.$tab_id_name.'_start']) && $_REQUEST['dtsl_sf_features'.$tab_id_name.'_start'] != '') {
							$dtsl_sf_features_start = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_features'.$tab_id_name.'_start']);
						}

						$dtsl_sf_features_end = $attrs['max_value'];
						if(isset($_REQUEST['dtsl_sf_features'.$tab_id_name.'_end']) && $_REQUEST['dtsl_sf_features'.$tab_id_name.'_end'] != '') {
							$dtsl_sf_features_end = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_features'.$tab_id_name.'_end']);
						}

						$output .= '<div class="dtsl-sf-features-slider '.esc_attr($additional_class).'" data-min="'.esc_attr($attrs['min_value']).'" data-max="'.esc_attr($attrs['max_value']).'" data-updated-min="'.esc_attr($dtsl_sf_features_start).'" data-updated-max="'.esc_attr($dtsl_sf_features_end).'"  data-itemunit="'.esc_attr($item_unit).'">';
							$output .= '<div class="dtsl-sf-features-slider-start-handle">'.esc_attr($dtsl_sf_features_start).' '.esc_attr($item_unit).'</div>';
							$output .= '<div class="dtsl-sf-features-slider-end-handle">'.esc_attr($dtsl_sf_features_end).' '.esc_attr($item_unit).'</div>';
							$output .= '<div class="dtsl-sf-features-slider-ranges">';
								$output .= '<div class="dtsl-sf-features-slider-range-min-holder">';
									$output .= '<label>'.esc_html__('Min', 'dtsl').'</label>';
									$output .= '<div class="dtsl-sf-features-slider-range-min">'.esc_attr($attrs['min_value']).' '.esc_attr($item_unit).'</div>';
								$output .= '</div>';
								$output .= '<div class="dtsl-sf-features-slider-range-max-holder">';
									$output .= '<label>'.esc_html__('Max', 'dtsl').'</label>';
									$output .= '<div class="dtsl-sf-features-slider-range-max">'.esc_attr($attrs['max_value']).' '.esc_attr($item_unit).'</div>';
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';

						$output .= '<input name="dtsl_sf_features'.$tab_id_name.'_start" class="dtsl-sf-field dtsl-sf-features-start" type="hidden" value="'.esc_attr($dtsl_sf_features_start).'" />';
						$output .= '<input name="dtsl_sf_features'.$tab_id_name.'_end" class="dtsl-sf-field dtsl-sf-features-end" type="hidden" value="'.esc_attr($dtsl_sf_features_end).'" />';

					}

				} else {

					$output .= esc_html__('This features shortcode won\'t work without tab id. Please provide tab id.', 'dtsl');

				}

			$output .= '</div>';

			return $output;

		}

		function dtsl_sf_orderby_field( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'field_type' => '',
						'placeholder_text' => '',
						'alphabetical_order' => 'true',
						'highestrated_order' => 'true',
						'mostreviewed_order' => 'true',
						'mostviewed_order' => 'true',
						'ajax_load' => '',
						'class' => '',

					), $attrs, 'dtsl_sf_orderby_field' );


			$output = '';

			$output .= '<div class="dtsl-sf-fields-holder dtsl-sf-orderby-field-holder '.$attrs['class'].'">';

				$additional_class = '';
				if($attrs['ajax_load'] == 'true') {
					$additional_class = 'dtsl-with-ajax-load';
				}

				$dtsl_sf_orderby = array ();
				if(isset($_REQUEST['dtsl_sf_orderby'])) {
					if(is_array($_REQUEST['dtsl_sf_orderby']) && !empty($_REQUEST['dtsl_sf_orderby'])) {
						$dtsl_sf_orderby = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_orderby']);
					} else if($_REQUEST['dtsl_sf_orderby'] != '') {
						$dtsl_sf_orderby = explode(',', dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_orderby']));
					}
				}

				$placeholder_text = esc_html__('Order By', 'dtsl');
				if($attrs['placeholder_text'] != '') {
					$placeholder_text = esc_html($attrs['placeholder_text']);
				}

				$orderby_items = array ();
				if($attrs['alphabetical_order'] == 'true') {
					$orderby_items['alphabetical'] = esc_html__('Alphabetical', 'dtsl');
				}
				if($attrs['highestrated_order'] == 'true') {
					$orderby_items['highest-rated'] = esc_html__('Highest Rated', 'dtsl');
				}
				if($attrs['mostreviewed_order'] == 'true') {
					$orderby_items['most-reviewed'] = esc_html__('Most Reviewed', 'dtsl');
				}
				if($attrs['mostviewed_order'] == 'true') {
					$orderby_items['most-viewed'] = esc_html__('Most Viewed', 'dtsl');
				}

				if($attrs['field_type'] == 'dropdown') {

					$output .= '<select class="dtsl-sf-field dtsl-sf-orderby '.esc_attr($additional_class).' dtsl-chosen-select" name="dtsl_sf_orderby">';
						$output .= '<option value="">'.esc_html($placeholder_text).'</option>';
						if(!empty($orderby_items)) {
							foreach($orderby_items as $orderby_item_key => $orderby_item) {
								$selected_attr = '';
								if(in_array($orderby_item_key, $dtsl_sf_orderby)) {
									$selected_attr = 'selected="selected"';
								}
								$output .= '<option value="'.esc_attr($orderby_item_key).'" '.$selected_attr.'>'.esc_html($orderby_item).'</option>';
							}
						}
					$output .= '</select>';

				} else {

					$output .= '<ul class="dtsl-sf-orderby-list '.esc_attr($additional_class).'">';
						if(!empty($orderby_items)) {
							foreach($orderby_items as $orderby_item_key => $orderby_item) {
								$output .= '<li>
												<a data-itemvalue="'.esc_attr($orderby_item_key).'" href="#">'.esc_html($orderby_item).'</a>
											</li>';
							}
						}
					$output .= '</ul>';

				}

			$output .= '</div>';

			return $output;

		}

		function dtsl_sf_mls_number_field( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'placeholder_text' => '',
						'ajax_load' => '',
						'class' => '',

					), $attrs, 'dtsl_sf_mls_number_field' );


			$output = '';

			$output .= '<div class="dtsl-sf-fields-holder dtsl-sf-mls-number-field-holder '.$attrs['class'].'">';

				$additional_class = '';
				if($attrs['ajax_load'] == 'true') {
					$additional_class = 'dtsl-with-ajax-load';
				}

				$placeholder_text = esc_html__('MLS Number', 'dtsl');
				if($attrs['placeholder_text'] != '') {
					$placeholder_text = esc_html($attrs['placeholder_text']);
				}

				$dtsl_sf_mls_number = '';
				if(isset($_REQUEST['dtsl_sf_mls_number']) && $_REQUEST['dtsl_sf_mls_number'] != '') {
					$dtsl_sf_mls_number = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_mls_number']);
				}

				$output .= '<input name="dtsl_sf_mls_number" class="dtsl-sf-field dtsl-sf-mls-number '.esc_attr($additional_class).'" type="text" value="'.esc_attr($dtsl_sf_mls_number).'" placeholder="'.esc_attr($placeholder_text).'" />';
				$output .= '<span></span>';

			$output .= '</div>';

			return $output;

		}

		function dtsl_sf_submit_button( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'output_type' => '',
						'separate_page_url' => '',
						'class' => '',

					), $attrs, 'dtsl_sf_submit_button' );


			$output = '';

			$output .= '<div class="dtsl-sf-fields-holder dtsl-sf-submitbutton-field-holder '.$attrs['class'].'">';

				$additional_attr = $execution_class = 'dtsl-execute';
				if($attrs['output_type'] == 'separate-page') {
					$additional_attr = esc_url($attrs['separate_page_url']);
					$execution_class = '';
				}

				$output .= '<a href="#" class="custom-button-style dtsl-submit-searchform '.esc_attr($attrs['class']).' '.esc_attr($execution_class).'" data-outputtype="'.esc_attr($attrs['output_type']).'" data-separatepageurl="'.$additional_attr.'">'.esc_html__('Check Availability', 'dtsl').'</a>';

			$output .= '</div>';

			return $output;

		}

		function dtsl_sf_output_data_container( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'type'                   => 'type1',
						'gallery'                => 'featured_image',
						'post_per_page'          => '',
						'columns'                => 1,
						'apply_isotope'          => '',
						'excerpt_length'         => '',
						'features_image_or_icon' => '',
						'features_include'       => '',
						'no_of_cat_to_display'   => 2,
						'apply_category_toggle'  => 'false',
						'category_toggle_type'   => 'type1',
						'apply_equal_height'     => 'false',
						'apply_custom_height'    => 'false',
						'height'                 => '',
						'vc_height'              => '',
						'sidebar_widget'         => 'false',

						'category_ids'           => '',

						'class'                  => '',

					), $attrs, 'dtsl_sf_output_data_container' );


			$output = '';

			$data_attributes = array ();
			array_push($data_attributes, 'data-type="'.esc_attr($attrs['type']).'"');
			array_push($data_attributes, 'data-gallery="'.esc_attr($attrs['gallery']).'"');
			array_push($data_attributes, 'data-postperpage="'.esc_attr($attrs['post_per_page']).'"');
			array_push($data_attributes, 'data-columns="'.esc_attr($attrs['columns']).'"');
			array_push($data_attributes, 'data-applyisotope="'.esc_attr($attrs['apply_isotope']).'"');
			array_push($data_attributes, 'data-excerptlength="'.esc_attr($attrs['excerpt_length']).'"');
			array_push($data_attributes, 'data-featuresimageoricon="'.esc_attr($attrs['features_image_or_icon']).'"');
			array_push($data_attributes, 'data-featuresinclude="'.esc_attr($attrs['features_include']).'"');
			array_push($data_attributes, 'data-noofcattodisplay="'.esc_attr($attrs['no_of_cat_to_display']).'"');
			array_push($data_attributes, 'data-applyequalheight="'.esc_attr($attrs['apply_equal_height']).'"');
			array_push($data_attributes, 'data-categoryids="'.esc_attr($attrs['category_ids']).'"');
			array_push($data_attributes, 'data-applycategorytoggle="'.esc_attr($attrs['apply_category_toggle']).'"');
			array_push($data_attributes, 'data-categorytoggletype="'.esc_attr($attrs['category_toggle_type']).'"');

			// Custom attributes update from modules
			$dtsl_custom_options = apply_filters('dtsl_sf_output_data_container_data_attrs_from_modules', '', $attrs);
			array_push($data_attributes, 'data-customoptions="'.esc_attr($dtsl_custom_options).'"');


			if(!empty($data_attributes)) {
				$data_attributes_string = implode(' ', $data_attributes);
			}

			if($attrs['apply_custom_height'] == 'true') {
				$attrs['class'] .= " dtsl-content-scroll";
			}

			if($attrs['sidebar_widget'] == 'true') {
				$attrs['class'] .= " dtsl-listings-sidebar-widget";
			}

			$height_attr = '';
			if($attrs['vc_height'] != '') {
				$height_attr = 'style="height:'.$attrs['vc_height'].'px;"';
			}

			$output .= '<div class="dtsl-listing-output-data-container dtsl-search-list-items  '.$attrs['class'].'" '.$height_attr.'>';
				$output .= '<div class="dtsl-listing-output-data-holder" '.$data_attributes_string.'></div>';
				$output .= dtsl_generate_loader_html(false);
			$output .= '</div>';

			return $output;

		}

	}

	DTStoreLocatorSearchFormShortcodes::instance();

}

?>