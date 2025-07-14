<?php

// Modifying Comments Template

if(!function_exists('dtsl_modifying_comment_template')) {
	function dtsl_modifying_comment_template( $comment_template ) {

		$dtsl_modules = dtstorelocator_instance()->active_modules;
		$dtsl_modules = (is_array($dtsl_modules) && !empty($dtsl_modules)) ? $dtsl_modules : array ();

		if ( is_singular('dtsl_listings') ) {
			if ( !in_array('comments', $dtsl_modules) ) {
				return DTSL_PLUGIN_PATH . '/utils/comments.php';
			}
		}

		return $comment_template;

	}
	add_filter('comments_template', 'dtsl_modifying_comment_template');
}

?>