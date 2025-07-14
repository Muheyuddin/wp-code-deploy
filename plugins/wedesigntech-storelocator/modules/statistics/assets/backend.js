var dtStoreLocatorBackendStatisticsUtils = {

	dtStoreLocatorStatisticsSellers : function() {

		jQuery.ajax({
			type: "POST",
			url: dtslbackendobject.ajaxurl,
			data:
			{
				action: 'dtsl_statistics_sellers',
			},
			beforeSend: function(){
				dtStoreLocatorBackendUtils.dtStoreLocatorAjaxBeforeSend(jQuery('.dtsl-statistics-sellers-container'));
			},
			success: function (response) {
				jQuery('.dtsl-statistics-sellers-container').find('.dtsl-statistics-sellers-data-container').html(response);
			},
			complete: function(){
				dtStoreLocatorBackendUtils.dtStoreLocatorAjaxAfterSend(jQuery('.dtsl-statistics-sellers-container'));
			}
		});

	}

};


var dtDirectorBackendStatistics = {

	dtInit : function() {

		// Listing - Statistics

			jQuery( 'body' ).delegate( '.dtsl-statistics-listings-seller', 'change', function(e) {

				var this_item = jQuery(this),
					seller_id = this_item.val();

				jQuery.ajax({
					type: "POST",
					url: dtslbackendobject.ajaxurl,
					data:
					{
						action: 'dtsl_statistics_sellerwise_listings',
						seller_id: seller_id,
					},
					beforeSend: function(){
						dtStoreLocatorBackendUtils.dtStoreLocatorAjaxBeforeSend(this_item.parents('.dtsl-statistics-container'));
					},
					success: function (response) {
						this_item.parents('.dtsl-statistics-container').find('.dtsl-statistics-listings-data-container').html(response);
					},
					complete: function(){
						dtStoreLocatorBackendUtils.dtStoreLocatorAjaxAfterSend(this_item.parents('.dtsl-statistics-container'));
					}
				});

				e.preventDefault();

			});

			jQuery('.dtsl-statistics-listings-seller').trigger('change');


		// Listings Seller - Statistics

			if(jQuery('.dtsl-statistics-sellers-container').length) {
				dtStoreLocatorBackendStatisticsUtils.dtStoreLocatorStatisticsSellers();
			}


		// Seller Incharge - Statistics

			jQuery( 'body' ).delegate( '.dtsl-statistics-seller-incharges', 'click', function(e) {

				var this_item = jQuery(this),
					seller_id = this_item.attr('data-sellerid');

				jQuery.ajax({
					type: "POST",
					url: dtslbackendobject.ajaxurl,
					data:
					{
						action: 'dtsl_statistics_seller_incharges',
						seller_id: seller_id,
					},
					beforeSend: function(){
						dtStoreLocatorBackendUtils.dtStoreLocatorAjaxBeforeSend(this_item.parents('.dtsl-statistics-container'));
					},
					success: function (response) {
						this_item.parents('.dtsl-statistics-container').find('.dtsl-statistics-sellers-inner-data-container').html(response);
					},
					complete: function(){
						dtStoreLocatorBackendUtils.dtStoreLocatorAjaxAfterSend(this_item.parents('.dtsl-statistics-container'));
					}
				});

				e.preventDefault();

			});


		// Seller Listings - Statistics

			jQuery( 'body' ).delegate( '.dtsl-statistics-seller-listings', 'click', function(e) {

				var this_item = jQuery(this),
					seller_id = this_item.attr('data-sellerid');

				jQuery.ajax({
					type: "POST",
					url: dtslbackendobject.ajaxurl,
					data:
					{
						action: 'dtsl_statistics_seller_listings',
						seller_id: seller_id,
					},
					beforeSend: function(){
						dtStoreLocatorBackendUtils.dtStoreLocatorAjaxBeforeSend(this_item.parents('.dtsl-statistics-container'));
					},
					success: function (response) {
						this_item.parents('.dtsl-statistics-container').find('.dtsl-statistics-sellers-inner-data-container').html(response);
					},
					complete: function(){
						dtStoreLocatorBackendUtils.dtStoreLocatorAjaxAfterSend(this_item.parents('.dtsl-statistics-container'));
					}
				});

				e.preventDefault();

			});

	}

};

jQuery(document).ready(function() {

	"use strict";

	dtDirectorBackendStatistics.dtInit();

});