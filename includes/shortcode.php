<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
add_shortcode('TD_DAILY', 'cts_shortcode_daily');
function cts_shortcode_daily($args){
	if(!wp_style_is('tabs_css_style','enqueued')){wp_enqueue_style('tabs_css_style', plugins_url( '/css/tab-variable-style.css', __FILE__ ));}
	if(!wp_script_is('cambiar_tab_dia','enqueued')){wp_enqueue_script('cambiar_tab_dia', plugins_url( '/js/tab-manager.js', __FILE__ ));}
	$returnMain = new tabManager("day");
	return $returnMain->print;
}
?>
