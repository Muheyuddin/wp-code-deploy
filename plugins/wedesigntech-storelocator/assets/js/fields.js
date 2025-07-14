var dtStoreLocatorFields = {

	dtInit : function() {

		// Chosen JS - Social Links

			dtStoreLocatorCommonUtils.dtStoreLocatorChosenSelect('.dtsl-social-chosen-select');


		// Generate MLS number

			jQuery( 'body' ).delegate( '.dtsl-generate-mls-number', 'click', function(){

				jQuery.ajax({
					type: "POST",
					url: dtslcommonobject.ajaxurl,
					data:
					{
						action: 'dtsl_generate_mls_number'
					},
					success: function (response) {

						jQuery('.dtsl-mls-number').val(response);

					}
				});

			});


		// Features

			jQuery('body').delegate('.dtsl-add-features-box', 'click', function(e) {

				var clone = jQuery('.dtsl-features-box-item-toclone').clone();
				clone.attr('class', 'dtsl-features-box-item').removeClass('hidden');
				clone.find('#dtsl_tab_id').attr('class', 'dtsl_tab_id').removeAttr('id');
				clone.find('#dtsl_features_title').attr('name', 'dtsl_features_title[]').removeAttr('id');
				clone.find('#dtsl_features_subtitle').attr('name', 'dtsl_features_subtitle[]').removeAttr('id');
				clone.find('#dtsl_features_value').attr('name', 'dtsl_features_value[]').removeAttr('id');
				clone.find('#dtsl_features_valueunit').attr('name', 'dtsl_features_valueunit[]').removeAttr('id');
				clone.find('#dtsl_features_icon').attr('name', 'dtsl_features_icon[]').removeAttr('id');
				clone.find('#dtsl_features_image').attr('name', 'dtsl_features_image[]').removeAttr('id');

				clone.appendTo('.dtsl-features-box-item-holder');

				$i = 0;
				jQuery('.dtsl_tab_id').each(function() {
					jQuery(this).val($i);
					$i++;
				})

				e.preventDefault();

			});

			jQuery('body').delegate('.dtsl-remove-features','click', function(e){

				jQuery(this).parents('.dtsl-features-box-item').remove();
				$i = 0;
				jQuery('.dtsl_tab_id').each(function() {
					jQuery(this).val($i);
					$i++;
				})
				e.preventDefault();

			});

			if (jQuery().sortable) {
				jQuery('.dtsl-features-box-item-holder').sortable({
					placeholder: 'sortable-placeholder',
					update: function( event, ui ) {
						$i = 0;
						jQuery('.dtsl_tab_id').each(function() {
							jQuery(this).val($i);
							$i++;
						})
					}
				});
			}


		// Social Details

			jQuery('a.dtsl-add-social-details').on('click', function(e){

				var clone = jQuery('#dtsl-social-details-section-to-clone').clone();

				clone.attr('class', 'dtsl-social-item-section').removeClass('hidden').removeAttr('id');
				clone.find('select').attr('name', 'dtsl_social_items[]').addClass('dtsl-social-chosen-select');
				clone.find('input').attr('name', 'dtsl_social_items_value[]');
				clone.appendTo('.dtsl-social-item-details-container');

				dtStoreLocatorCommonUtils.dtStoreLocatorChosenSelect('.dtsl-social-chosen-select');

				e.preventDefault();

			});

			jQuery('body').delegate('span.dtsl-remove-social-item','click', function(e){

				jQuery(this).parents('.dtsl-social-item-section').remove();
				e.preventDefault();

			});

			if (jQuery().sortable) {
				jQuery('.dtsl-social-item-details-container').sortable({ placeholder: 'sortable-placeholder' });
			}

	}

};

jQuery(document).ready(function() {

	"use strict";

	dtStoreLocatorFields.dtInit();

});