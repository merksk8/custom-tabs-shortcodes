<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
//=====================
//SHORTCODE TABS VARIABLES
//=====================
add_shortcode('TD_CUSTOM', 'cts_shortcode_variable');
function cts_shortcode_variable($atts){
	$args = shortcode_atts( array(
	'id' => '0',
	), $atts );
	$id = $args["id"];

	if(!wp_style_is('tabs_css_style','enqueued')){wp_enqueue_style('tabs_css_style', plugins_url( '/css/tab-variable-style.css', __FILE__ ));}
	if(!wp_script_is('cambiar_tab_dia','enqueued')){wp_enqueue_script('cambiar_tab_dia', plugins_url( '/js/tab-manager.js', __FILE__ ));}
	if(!wp_style_is('dashicons','enqueued')){wp_enqueue_style( 'dashicons' );}
	if("auto-draft" == get_post_status( $id )){
		if(is_admin()){
			$returnMain = new tabManager("new", $id);
			echo $returnMain->print;
		}
	}else{
		if(is_admin()){
			$returnMain = new tabManager("edit", $id);
			echo $returnMain->print;
		}else{
			$returnMain = new tabManager("custom", $id);
			return $returnMain->print;
		}	
	}

}
?>