var dtStoreLocatorDashboard = {

	dtInit : function() {

		// Add incharge

			jQuery( 'body' ).delegate( '.dtsl-add-incharge-button', 'click', function(){

				var this_item          = jQuery(this),
					dashboard_page_url = jQuery('.dtsl_dashboard_page_url').val(),
					seller_id          = this_item.attr('data-seller-id'),
					incharge_id           = this_item.attr('data-incharge-edit-item-id'),
					incharge_mode         = this_item.attr('data-incharge-mode');

				var form = jQuery('.dtsl-dashboard-addincharge-form')[0];
				var data = new FormData(form);
				data.append('action', 'dtsl_dashboard_addincharge_profile');
				data.append('seller_id', seller_id);
				data.append('incharge_id', incharge_id);
				data.append('incharge_mode', incharge_mode);


				jQuery.ajax({
					type: "POST",
					url: dtslfrontendobject.ajaxurl,
					data: data,
					processData: false,
					contentType: false,
					cache: false,
					beforeSend: function(){
						this_item.prepend( '<span><i class="fa fa-spinner fa-spin"></i></span>' );
					},
					success: function (response) {

						jQuery('.dtsl-dashboard-notices').removeClass('dtsl-success-notice').removeClass('dtsl-warning-notice');

						if(response == 'success') {

							jQuery('.dtsl-dashboard-notices').addClass('dtsl-success-notice');
							jQuery('.dtsl-dashboard-notices').html(dtslfrontendobject.updateInchargeSuccess);

							window.setTimeout(function(){
								window.location.replace(dashboard_page_url + '?type=myincharges');
							}, 1200);

						} else {

							var jsonParsed = JSON.parse(response);

							var data = '<ul>';
							jQuery.each( jsonParsed, function( i, val ) {
								data += '<li>' + val + '</li>';
							});
							data += '</ul>';

							jQuery('.dtsl-dashboard-notices').addClass('dtsl-warning-notice');
							jQuery('.dtsl-dashboard-notices').html(data);

						}

					},
					complete: function(){
						this_item.find('span').remove();
					}
				});

			});


		// Remove incharge

			jQuery( 'body' ).delegate( '.dtsl-remove-incharge', 'click', function(){


				if(!confirm(dtslfrontendobject.confirmRemoveIncharge)) {
					return false;
				}

				var this_item          = jQuery(this),
					dashboard_page_url = this_item.attr('data-dashboard-page-url'),
					seller_id          = this_item.attr('data-seller-id'),
					incharge_id           = this_item.attr('data-incharge-id'),
					nonce              = this_item.attr('data-nonce');

				jQuery.ajax({
					type: "POST",
					url: dtslfrontendobject.ajaxurl,
					data:
					{
						action: 'dtsl_remove_seller_incharge',
						seller_id: seller_id,
						incharge_id: incharge_id,
						nonce: nonce,
					},
					success: function (response) {

						if(response == 'success') {

							window.setTimeout(function(){
								window.location.replace(dashboard_page_url + '?type=myincharges');
							}, 1200);

						} else {

							var jsonParsed = JSON.parse(response);

							var data = '<ul>';
							jQuery.each( jsonParsed, function( i, val ) {
								data += '<li>' + val + '</li>';
							});
							data += '</ul>';

							jQuery('.dtsl-dashboard-notices').addClass('dtsl-info-notice');
							jQuery('.dtsl-dashboard-notices').html(data);

						}


					}
				});

			});


		// Activate incharge

			jQuery( 'body' ).delegate( '.dtsl-dashboard-activate-disabled-incharge', 'click', function(e) {

				var this_item               = jQuery(this);
				var incharge_id                = this_item.attr('data-incharge-id');
				var seller_id               = this_item.attr('data-seller-id');
				var requires_admin_approval = this_item.attr('data-requires-admin-approval');
				var nonce                   = this_item.attr('data-nonce');

				jQuery.ajax({
					type: "POST",
					url: dtslfrontendobject.ajaxurl,
					data:
					{
						action: 'dtsl_dashboard_activate_disabled_incharge',
						incharge_id: incharge_id,
						seller_id: seller_id,
						requires_admin_approval: requires_admin_approval,
						nonce: nonce
					},
					success: function (response) {

						var responseSplited = response.split('|');
						var response = responseSplited[0];
						var responseCount = responseSplited[1];

						if(response == 'success') {

							if(requires_admin_approval == 'true') {
								this_item.parents('tr').find('.dtsl-incharge-status').html(dtslfrontendobject.inchargeStatusWaitingForApproval);
							} else {
								this_item.parents('tr').find('.dtsl-incharge-status').html(dtslfrontendobject.inchargeStatusActive);
							}

							this_item.remove();

						} else if(response == 'fail') {

							this_item.html('<i class="far fa-share-square"></i>');
							setTimeout( function() {
								this_item.html('<i class="fas fa-share-square"></i>');
							}, 200);

						}

						jQuery('.dtsl-dashboard-package-detail-value.dtsl-incharges-remaining-data').html(responseCount);

					},
				});

				e.preventDefault();

			});


		// Add listings

			jQuery( 'body' ).delegate( '.dtsl-add-listing-button', 'click', function(){

				var this_item = jQuery(this),
					dashboard_page_url = jQuery('.dtsl_dashboard_page_url').val(),
					listing_mode = this_item.attr('data-listing-mode'),
					listing_edit_item_id = this_item.attr('data-listing-edit-item-id'),
					user_id = this_item.attr('data-user-id'),
					seller_id = this_item.attr('data-seller-id');

				var form = jQuery('.dtsl-add-listing')[0];
				var data = new FormData(form);
				data.append('action', 'dtsl_add_frontend_listing');
				data.append('dtsl_listing_mode', listing_mode);
				data.append('dtsl_listing_edit_item_id', listing_edit_item_id);
				data.append('user_id', user_id);
				data.append('seller_id', seller_id);

				jQuery.ajax({
					type: "POST",
					url: dtslfrontendobject.ajaxurl,
					data: data,
					processData: false,
					contentType: false,
					cache: false,
					beforeSend: function(){
						this_item.prepend( '<span><i class="fa fa-spinner fa-spin"></i></span>' );
					},
					success: function (response) {

						jQuery('.dtsl-dashboard-notices').removeClass('dtsl-success-notice').removeClass('dtsl-warning-notice');

						if(response == 'success') {

							jQuery('.dtsl-dashboard-notices').addClass('dtsl-success-notice');
							jQuery('.dtsl-dashboard-notices').html(dtslfrontendobject.addListingSuccess);

							window.setTimeout(function(){
								window.location.replace(dashboard_page_url + '?type=mylistings');
							}, 1200);

						} else {

							var jsonParsed = JSON.parse(response);

							var data = '<ul>';
							jQuery.each( jsonParsed, function( i, val ) {
								data += '<li>' + val + '</li>';
							});
							data += '</ul>';

							jQuery('.dtsl-dashboard-notices').addClass('dtsl-warning-notice');
							jQuery('.dtsl-dashboard-notices').html(data);

						}

					},
					complete: function(){
						this_item.find('span').remove();
					}
				});

			});


		// Remove listing

			jQuery( 'body' ).delegate( '.dtsl-remove-listing', 'click', function(){


				if(!confirm(dtslfrontendobject.confirmRemoveListing)) {
					return false;
				}

				var this_item          = jQuery(this),
					dashboard_page_url = this_item.attr('data-dashboard-page-url'),
					listing_id        = this_item.attr('data-listing-id'),
					user_id            = this_item.attr('data-user-id'),
					seller_id          = this_item.attr('data-seller-id'),
					nonce              = this_item.attr('data-nonce');

				jQuery.ajax({
					type: "POST",
					url: dtslfrontendobject.ajaxurl,
					data:
					{
						action: 'dtsl_remove_seller_listing',
						listing_id: listing_id,
						user_id: user_id,
						seller_id: seller_id,
						nonce: nonce,
					},
					success: function (response) {

						if(response == 'success') {

							window.setTimeout(function(){
								window.location.replace(dashboard_page_url + '?type=mylistings');
							}, 1200);

						} else {

							var jsonParsed = JSON.parse(response);

							var data = '<ul>';
							jQuery.each( jsonParsed, function( i, val ) {
								data += '<li>' + val + '</li>';
							});
							data += '</ul>';

							jQuery('.dtsl-dashboard-notices').addClass('dtsl-info-notice');
							jQuery('.dtsl-dashboard-notices').html(data);

						}


					}
				});

			});


		// Submit listing for approval

			jQuery( 'body' ).delegate( '.dtsl-dashboard-submit-listing-for-approval', 'click', function(e) {

				var this_item               = jQuery(this);
				var listing_id             = this_item.attr('data-listing-id');
				var seller_id               = this_item.attr('data-seller-id');
				var requires_admin_approval = this_item.attr('data-requires-admin-approval');
				var nonce                   = this_item.attr('data-nonce');

				jQuery.ajax({
					type: "POST",
					url: dtslfrontendobject.ajaxurl,
					data:
					{
						action: 'dtsl_dashboard_submit_listing_for_approval',
						listing_id: listing_id,
						seller_id: seller_id,
						requires_admin_approval: requires_admin_approval,
						nonce: nonce
					},
					success: function (response) {

						var responseSplited = response.split('|');
						var response = responseSplited[0];
						var responseCount = responseSplited[1];

						if(response == 'success') {

							if(requires_admin_approval == 'true') {
								this_item.parents('.dtsl-listing-details').find('.dtsl-listing-dashboard-status').html(dtslfrontendobject.listingWaitingForApproval);
							} else {
								this_item.parents('.dtsl-listing-details').find('.dtsl-listing-dashboard-status').html(dtslfrontendobject.listingPublish);
							}

							this_item.remove();

						} else if(response == 'fail') {

							this_item.html('<i class="far fa-share-square"></i>');
							setTimeout( function() {
								this_item.html('<i class="fas fa-share-square"></i>');
							}, 200);

						}

						jQuery('.dtsl-dashboard-package-detail-value.dtsl-listings-remaining-data').html(responseCount);

					},
				});

				e.preventDefault();

			});


		// Update user profile

			jQuery( 'body' ).delegate( '.dtsl-update-profile-button', 'click', function(){

				var this_item = jQuery(this),
					dashboard_page_url = jQuery('.dtsl_dashboard_page_url').val();

				var form = jQuery('.dtsl-dashboard-profile-form')[0];
				var data = new FormData(form);
				data.append('action', 'dtsl_dashboard_update_user_profile');


				jQuery.ajax({
					type: "POST",
					url: dtslfrontendobject.ajaxurl,
					data: data,
					processData: false,
					contentType: false,
					cache: false,
					beforeSend: function(){
						this_item.prepend( '<span><i class="fa fa-spinner fa-spin"></i></span>' );
					},
					success: function (response) {

						this_item.parents('.dtsl-dashbord-section-holder').find('.dtsl-dashboard-notices').removeClass('dtsl-success-notice').removeClass('dtsl-warning-notice');

						if(response == 'success') {

							this_item.parents('.dtsl-dashbord-section-holder').find('.dtsl-dashboard-notices').addClass('dtsl-success-notice');
							this_item.parents('.dtsl-dashbord-section-holder').find('.dtsl-dashboard-notices').html(dtslfrontendobject.updateProfileSuccess);

							window.setTimeout(function(){
								window.location.replace(dashboard_page_url + '?type=myprofile');
							}, 1200);

						} else {

							var jsonParsed = JSON.parse(response);

							var data = '<ul>';
							jQuery.each( jsonParsed, function( i, val ) {
								data += '<li>' + val + '</li>';
							});
							data += '</ul>';

							this_item.parents('.dtsl-dashbord-section-holder').find('.dtsl-dashboard-notices').addClass('dtsl-warning-notice');
							this_item.parents('.dtsl-dashbord-section-holder').find('.dtsl-dashboard-notices').html(data);

						}

					},
					complete: function(){
						this_item.find('span').remove();
					}
				});

			});


		// Update user password

			jQuery( 'body' ).delegate( '.dtsl-update-userpwd-button', 'click', function(){

				var this_item = jQuery(this),
					dashboard_page_url = jQuery('.dtsl_dashboard_page_url').val();

				var form = jQuery('.dtsl-dashboard-profile-changepwd-form')[0];
				var data = new FormData(form);
				data.append('action', 'dtsl_dashboard_update_user_password');


				jQuery.ajax({
					type: "POST",
					url: dtslfrontendobject.ajaxurl,
					data: data,
					processData: false,
					contentType: false,
					cache: false,
					beforeSend: function(){
						this_item.prepend( '<span><i class="fa fa-spinner fa-spin"></i></span>' );
					},
					success: function (response) {

						this_item.parents('.dtsl-dashbord-section-holder').find('.dtsl-dashboard-notices').removeClass('dtsl-success-notice').removeClass('dtsl-warning-notice');

						if(response == 'success') {

							this_item.parents('.dtsl-dashbord-section-holder').find('.dtsl-dashboard-notices').addClass('dtsl-success-notice');
							this_item.parents('.dtsl-dashbord-section-holder').find('.dtsl-dashboard-notices').html(dtslfrontendobject.updateProfilePwdSuccess);

							window.setTimeout(function(){
								window.location.replace(dashboard_page_url + '?type=mylistings');
							}, 1200);

						} else {

							var jsonParsed = JSON.parse(response);

							var data = '<ul>';
							jQuery.each( jsonParsed, function( i, val ) {
								data += '<li>' + val + '</li>';
							});
							data += '</ul>';

							this_item.parents('.dtsl-dashbord-section-holder').find('.dtsl-dashboard-notices').addClass('dtsl-warning-notice');
							this_item.parents('.dtsl-dashbord-section-holder').find('.dtsl-dashboard-notices').html(data);

						}

					},
					complete: function(){
						this_item.find('span').remove();
					}
				});

			});


		// Mark item as featured

			jQuery( 'body' ).delegate( '.dtsl-dashboard-markitem-featured', 'click', function(e) {

				var this_item = jQuery(this);
				var listing_id = this_item.attr('data-listing-id');
				var seller_id = this_item.attr('data-seller-id');
				var admin_id = this_item.attr('data-admin-id');

				if(this_item.find('i').hasClass('fas fa-star')) {
					var action_type = 'remove';
				} else {
					var action_type = 'add';
				}


				jQuery.ajax({
					type: "POST",
					url: dtslfrontendobject.ajaxurl,
					data:
					{
						action: 'dtsl_dashboard_markitem_featured',
						listing_id: listing_id,
						seller_id: seller_id,
						admin_id: admin_id,
						action_type: action_type,
					},
					success: function (response) {

						var responseSplited = response.split('|');
						var response = responseSplited[0];
						var responseCount = responseSplited[1];

						if(response == 'success-add') {
							this_item.html('<i class="fas fa-star"></i>');
						} else if(response == 'success-remove') {
							this_item.html('<i class="far fa-star"></i>');
						} else if(response == 'fail') {
							this_item.html('<i class="fas fa-star"></i>');
							setTimeout( function() {
								this_item.html('<i class="far fa-star"></i>');
							}, 200);
						}

						jQuery('.dtsl-dashboard-package-detail-value.dtsl-featured-remaining-data').html(responseCount);

					},
				});

				e.preventDefault();

			});


		// Contact admin form submit

			jQuery( 'body' ).delegate( '.dtsl-dashboard-contactadmin-submit-button', 'click', function(e) {

				var this_item = jQuery(this);
				var notification_box = this_item.parents('.dtsl-dashboard-contactadmin-form').find('.dtsl-dashboard-contactadmin-notification-box');

				var form = jQuery('.dtsl-dashboard-contactadmin-form')[0];
				var data = new FormData(form);
				data.append('action', 'dtsl_process_dashboard_contactadmin');

				jQuery.ajax({
					type: "POST",
					url: dtslfrontendobject.ajaxurl,
					data: data,
					processData: false,
					contentType: false,
					cache: false,
					dataType: "JSON",
					beforeSend: function() {
						this_item.prepend( '<span><i class="fa fa-spinner fa-spin"></i></span>' );
					},
					success: function (response) {
						notification_box.removeClass('dtsl-success dtsl-failure');
						if(response.success) {
							notification_box.addClass('dtsl-success');
							notification_box.html(response.message);
						} else {
							notification_box.addClass('dtsl-failure');
							notification_box.html(response.message);
						}
					},
					complete: function() {
						this_item.find('span').remove();
					}
				});

				e.preventDefault();

			});


		// Remove favourite listing

			jQuery( 'body' ).delegate( '.dtsl-remove-favourite-listing', 'click', function() {


				if(!confirm(dtslfrontendobject.confirmRemoveFavouriteListing)) {
					return false;
				}

				var	this_item          = jQuery(this),
					dashboard_page_url = this_item.attr('data-dashboard-page-url'),
					listing_id         = this_item.attr('data-listing-id'),
					user_id            = this_item.attr('data-user-id'),
					nonce              = this_item.attr('data-nonce');

				jQuery.ajax({
					type: "POST",
					url: dtslfrontendobject.ajaxurl,
					data:
					{
						action: 'dtsl_remove_favourite_listing',
						listing_id: listing_id,
						user_id: user_id,
						nonce: nonce,
					},
					success: function (response) {

						if(response == 'success') {

							window.setTimeout(function(){
								window.location.replace(dashboard_page_url + '?type=favouritelisting');
							}, 1200);

						} else {

							var jsonParsed = JSON.parse(response);

							var data = '<ul>';
							jQuery.each( jsonParsed, function( i, val ) {
								data += '<li>' + val + '</li>';
							});
							data += '</ul>';

							jQuery('.dtsl-dashboard-notices').addClass('dtsl-info-notice');
							jQuery('.dtsl-dashboard-notices').html(data);

						}


					}
				});

			});


		// Inbox Load Conversation

			jQuery( 'body' ).delegate( '.dtsl-dashbord-inbox-conversation-loader', 'click', function() {

				var	this_item = jQuery(this),
					author_id    = this_item.attr('data-authorid'),
					listing_id   = this_item.attr('data-listingid'),
					user_email   = this_item.attr('data-useremail');

				jQuery.ajax({
					type: "POST",
					url: dtslfrontendobject.ajaxurl,
					data:
					{
						action    : 'dtsl_inbox_conversation_loader',
						author_id : author_id,
						listing_id: listing_id,
						user_email: user_email
					},
					success: function (response) {

						jQuery( '.dtsl-dashbord-inbox-conversation-loader' ).removeClass('active');
						this_item.addClass('active');
						jQuery('.dtsl-dashbord-inbox-listing-conversation-wrapper').html(response);

					}
				});

			});


		// Inbox Reply Conversation

			jQuery( 'body' ).delegate( '.dtsl-dashbord-inbox-conversation-reply-loader', 'click', function() {

				jQuery('.dtsl-dashbord-inbox-conversation-reply-wrapper').addClass('hidden');
				jQuery(this).parent().find('.dtsl-dashbord-inbox-conversation-reply-wrapper').removeClass('hidden');

				jQuery(this).parents('li').find('.dtsl-inbox-conversation-reply-notification-box').html('');

			});


		// Inbox Reply Form

			jQuery( 'body' ).delegate( '.dtsl-inbox-conversation-reply-submit', 'click', function(e) {

				var this_item = jQuery(this);
				var notification_box = this_item.parents('.dtsl-inbox-conversation-reply-form').find('.dtsl-inbox-conversation-reply-notification-box');

				var form = this_item.parents('.dtsl-inbox-conversation-reply-form')[0];
				var data = new FormData(form);
				data.append('action', 'dtsl_process_inbox_conversation_reply_form');

				jQuery.ajax({
					type: 'POST',
					url: dtslfrontendobject.ajaxurl,
					data: data,
					processData: false,
					contentType: false,
					cache: false,
					dataType: "JSON",
					beforeSend: function() {
						this_item.prepend( '<span><i class="fa fa-spinner fa-spin"></i></span>' );
					},
					success: function (response) {

						notification_box.removeClass('dtsl-success dtsl-failure');
						if(response.success) {

							notification_box.addClass('dtsl-success');
							notification_box.html(response.message);

							window.setTimeout(function() {

								this_item.parents('.dtsl-inbox-conversation-reply-form').find('textarea').val('');
								jQuery('.dtsl-dashbord-inbox-conversation-reply-wrapper').addClass('hidden');

								this_item.parents('li').find('.dtsl-dashbord-inbox-conversation-reply-list-wrapper').replaceWith(response.replay_message);

							}, 800);

						} else {
							notification_box.addClass('dtsl-failure');
							notification_box.html(response.message);
						}

					},
					complete: function() {
						this_item.find('span').remove();
					}
				});

				e.preventDefault();

			});


		// Reviews Loader

			jQuery( 'body' ).delegate( '.dtsl-dashbord-reviews-loader', 'click', function() {

				var	this_item = jQuery(this),
					author_id    = this_item.attr('data-authorid');

				var review_type = '';
				if(this_item.hasClass('all')) {
					review_type = 'all';
				} else if(this_item.hasClass('received')) {
					review_type = 'received';
				} else if(this_item.hasClass('submitted')) {
					review_type = 'submitted';
				}

				jQuery( '.dtsl-dashbord-reviews-loader' ).removeClass('dtsl-active');
				this_item.addClass('dtsl-active');


				jQuery.ajax({
					type: "POST",
					url: dtslfrontendobject.ajaxurl,
					data:
					{
						action     : 'dtsl_dashbord_reviews_loader',
						author_id  : author_id,
						review_type: review_type
					},
					success: function (response) {

						jQuery('.dtsl-dashbord-reviews-listing-wrapper').html(response);

						jQuery('.dtsl_comment_gallery_item').each(function() {
							var attr = jQuery(this).attr('rel');
							if (jQuery('a[rel^="'+attr+'"]').length) {
								jQuery('a[rel^="'+attr+'"]').prettyPhoto({
									hook: 'rel',
									show_title: false,
									deeplinking: false,
									social_tools: false,
							});
							}
						});

					}
				});

			});

			if(jQuery('.dtsl-dashbord-reviews-loader.all').length) {
				jQuery('.dtsl-dashbord-reviews-loader.all').trigger('click');
			}


	}

};

jQuery(document).ready(function() {

	"use strict";

	dtStoreLocatorDashboard.dtInit();

});