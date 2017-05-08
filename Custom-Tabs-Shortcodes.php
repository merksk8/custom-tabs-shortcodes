<?php 
/*
 Plugin Name: Custom Tabs Shortcodes
 Plugin URI: 
 Description: Instala dos shortcodes, uno fijo para un tab diario y otro para tabs a medida.
 Version: 1.0
 Author: Merksk8
 Author URI: https://profiles.wordpress.org/merksk8
 License: GPL2
 Copyright: Merksk8
 Text Domain: tdlang
 Domain Path: /includes/lang/
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
//MAIN LOADER
$plugin_desc = __('Instala dos shortcodes, uno fijo para un tab diario y otro para tabs a medida.', 'tdlang');
add_action( 'init', 'cts_main_loader' );
function cts_main_loader(){
	require( dirname( __FILE__ ) . '/includes/shortcode.php' );
	require( dirname( __FILE__ ) . '/includes/shortcode-variable.php' );
	require( dirname( __FILE__ ) . '/includes/class/tabManager.php' );
}
register_activation_hook( __FILE__, 'cts_install_main' );
function cts_install_main(){
	$colors = array(
		"td_background"		=> "#3a3a3a",
		"td_text"		=> "#ffffff",
		"td_active"		=> "#407f3f",
		"td_hover"		=> "#1252d1",
		"td_icon"		=> "#10f2c5"
	);
	add_option('cts_config', $colors);
	add_option('cts_color_defaults', $colors);
	add_option('cts_lunes', '0');
	add_option('cts_martes', '0');
	add_option('cts_miercoles', '0');
	add_option('cts_jueves', '0');
	add_option('cts_viernes', '0');
	add_option('cts_sabado', '0');
	add_option('cts_domingo', '0');
	add_option('cts_icons', array( " ", " ", " ", " ", " ", " ", " " ));
    register_uninstall_hook( __FILE__, 'cts_uninstall_main' );
} 
// UNINSTALL
function cts_uninstall_main(){
	if(get_option('cts_delete') == 1){
	    delete_option('cts_config');
		delete_option('cts_color_defaults');
		delete_option('cts_lunes');
		delete_option('cts_martes');
		delete_option('cts_miercoles');
		delete_option('cts_jueves');
		delete_option('cts_viernes');
		delete_option('cts_sabado');
		delete_option('cts_domingo');
		delete_option('cts_delete');
		delete_option('cts_icons');
	}
}
//CPT LOADER
add_action('setup_theme', 'cts_post_loader');
function cts_post_loader(){
	require( dirname( __FILE__ ) . '/includes/cpt-tabs.php' );
}
//FUNCTION TO CREATE THE ADMIN PAGE
add_action('admin_menu', 'cts_admin_page_loader');
function cts_admin_page_loader() { 
	add_submenu_page( 'edit.php?post_type=customtabshortcode', __('Configuración', 'tdlang'),  __('Configuración', 'tdlang'), 'manage_options',  __('Configuración', 'tdlang'), 'cts_admin_page_day', 'dashicons-editor-kitchensink');
}
//FUNCTION TO PRINT THE ADMIN PAGE
function cts_admin_page_day(){
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	require( dirname( __FILE__ ) . '/includes/admin-day.php');
}
add_action('plugins_loaded', 'cts_load_languages');
function cts_load_languages() {
	load_plugin_textdomain( 'tdlang', false, dirname( plugin_basename(__FILE__) ) . '/includes/lang/' );
}
 ?>