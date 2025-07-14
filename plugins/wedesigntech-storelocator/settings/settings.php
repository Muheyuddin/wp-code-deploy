<?php

require_once DTSL_PLUGIN_PATH . 'settings/settings-utils.php';


function dtsl_settings_options() {

	$tabs = array (
		'general'   => array (
			'label' => esc_html__('General', 'dtsl'),
			'path' => DTSL_PLUGIN_PATH . 'settings/settings-general-utils.php'
		),
		'label'     =>  array (
			'label' => esc_html__('Labels', 'dtsl'),
			'path' => DTSL_PLUGIN_PATH . 'settings/settings-label-utils.php'
		),
		'permalink' =>  array (
			'label' => esc_html__('Permalink', 'dtsl'),
			'path' => DTSL_PLUGIN_PATH . 'settings/settings-permalink-utils.php'
		),
		'archives' =>  array (
			'label' => esc_html__('Archives', 'dtsl'),
			'path' => DTSL_PLUGIN_PATH . 'settings/settings-archives-utils.php'
		),
		'skin'      =>  array (
			'label' => esc_html__('Skin', 'dtsl'),
			'path' => DTSL_PLUGIN_PATH . 'settings/settings-skin-utils.php'
		),
		'import'    =>  array (
			'label' => esc_html__('Import', 'dtsl'),
			'path' => DTSL_PLUGIN_PATH . 'settings/settings-import-utils.php'
		)
	);

	$tabs = apply_filters( 'dtsl_settings', $tabs );

	$current = isset( $_GET['parenttab'] ) ? dtsl_recursive_sanitize_text_field($_GET['parenttab']) : 'general';

	dtsl_get_settings_submenus($current, $tabs);
	dtsl_get_settings_tab($current, $tabs);

}

function dtsl_get_settings_submenus($current, $tabs) {

    echo '<h2 class="dtsl-custom-nav nav-tab-wrapper">';
		foreach( $tabs as $key => $tab ) {
			$class = ( $key == $current ) ? 'nav-tab-active' : '';
			echo '<a class="nav-tab '.$class.'" href="?page=dtsl-settings-options&parenttab='.$key.'">'.$tab['label'].'</a>';
		}
    echo '</h2>';

}

function dtsl_get_settings_tab($current, $tabs) {
	require_once $tabs[$current]['path'];
}

?>