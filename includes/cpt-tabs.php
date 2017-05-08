<?php  
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/* ===CPT=== */
add_action( 'init', 'cts_cpt_tabs_main' );
//=====================
//COLORES POR DEFECTO
//=====================
$colors = get_option('cts_color_defaults');
//=====================
//CUSTOM POST TYPE
//=====================
function cts_cpt_tabs_main(){
	$labels = array(
			'name' => __( 'Tab Shortcode', 'tdlang' ),
			'menu_name' => __( 'Tab Shortcodes', 'tdlang' ),
			'singular_name' => __( 'Tab Shortcode', 'tdlang' ),
			'all_items' => __( 'Lista de TS', 'tdlang' ),
			'name_admin_bar'     => __( 'Tab Shortcode', 'tdlang' ),
			'add_new'            => __( 'Nuevo TabShortcode', 'tdlang' ),
			'add_new_item'       => __( 'Crear Nuevo TabShortcode', 'tdlang' ),
			'new_item'           => __( 'Nuevo TabShortcode', 'tdlang' ),
			'edit_item'          => __( 'Editar TabShortcode', 'tdlang' ),
			'view_item'          => __( 'Ver TabShortcode', 'tdlang' ),
			'search_items'       => __( 'Buscar TabShortcode', 'tdlang' ),
			'not_found'          => __( 'No se han encontrado TabShortcodes.', 'tdlang' ),
			'not_found_in_trash' => __( 'No se han encontrado TabShortcodes en la Papelera.', 'tdlang' )
		);
	$arguments = array(
			'labels'             => $labels,
			'description'        => 'TabShortcodes',
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => false,
			'query_var'          => false,
			'rewrite'            => array( 'slug' => 'tabs' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 20,
			'menu_icon'			 => 'dashicons-editor-kitchensink',
			'supports'           => array( 'title', 'cts_metabox', 'cts_metabox_2', 'cts_metabox_3', 'cts_metabox_4')
		);
	register_post_type( 'customtabshortcode', $arguments );
}
//=====================
//METABOX: MAIN
//=====================
add_action( 'add_meta_boxes', 'cts_build_metaboxes');
function cts_build_metaboxes(){
	$screens = array( 'customtabshortcode' );
	foreach ($screens as $screen){
		//TEXTO
		//add_meta_box('texto_uno', 'Texto de ejemplo 1', 'callback_texto_uno', $screen);
		add_meta_box('cts_metabox', __("Tab Shortcode", "tdlang"), 'cts_callback_shortcode', $screen, 'normal', 'high');
		add_meta_box('cts_metabox_2', __("Opciones", "tdlang"), 'cts_callback_shortcode2', $screen, 'side', 'low');
		add_meta_box('cts_metabox_3', __("Shortcode", "tdlang"), 'cts_callback_shortcode3', $screen, 'side', 'high');
		add_meta_box('cts_metabox_4', __("Ejemplo", "tdlang"), 'cts_callback_shortcode4', $screen, 'normal', 'low');
	}
}
//=====================
//METABOX: RESULTADO
//=====================
function cts_callback_shortcode4($post){
	$td_data = get_post_meta( $post->ID, 'td_data', true);
	?>
	<h3> <?php _e('Resultado', 'tdlang'); ?> </h3>
	<?php 
	do_shortcode('[TD_CUSTOM id="' . $post->ID . '"]');
}
//=====================
//METABOX: COLORES
//=====================
function cts_callback_shortcode2($post){
	//defaults
	$td_color = get_post_meta( $post->ID, 'td_colors', true);
	$td_color = maybe_unserialize($td_color);
	$colors = get_option('cts_color_defaults');
	if( isset($td_color["td_background"]) && !empty($td_color["td_background"]) ){ $colors["td_background"] = $td_color["td_background"]; }
	if( isset($td_color["td_text"])  && !empty($td_color["td_text"]) ){ $colors["td_text"] = $td_color["td_text"]; }
	if( isset($td_color["td_active"])  && !empty($td_color["td_active"]) ){ $colors["td_active"] = $td_color["td_active"]; }
	if( isset($td_color["td_hover"])  && !empty($td_color["td_hover"]) ){ $colors["td_hover"] = $td_color["td_hover"]; }
	if( isset($td_color["td_icon"])  && !empty($td_color["td_icon"]) ){ $colors["td_icon"] = $td_color["td_icon"]; }
	?>
	<p> <?php _e('Color de fondo', 'tdlang'); ?>
	<p><input type="text" id="td_background" name="td_background" value="<?php echo $colors["td_background"]; ?>" class="color_picker" />
	<p> <?php _e('Color de texto', 'tdlang'); ?>
	<p><input type="text" id="td_text" name="td_text" value="<?php echo $colors["td_text"]; ?>" class="color_picker" />
	<p> <?php _e('Color de Activo', 'tdlang'); ?>
	<p><input type="text" id="td_active" name="td_active" value="<?php echo $colors["td_active"]; ?>" class="color_picker" />
	<p> <?php _e('Color de hover', 'tdlang'); ?>
	<p><input type="text" id="td_hover" name="td_hover" value="<?php echo $colors["td_hover"]; ?>" class="color_picker" />
	<p> <?php _e('Color de iconos', 'tdlang'); ?>
	<p><input type="text" id="td_icon" name="td_icon" value="<?php echo $colors["td_icon"]; ?>" class="color_picker" />
	<?php 
}
//=====================
//METABOX:SHORTCODE DATA
//=====================
function cts_callback_shortcode3($post){
	?>
	<center><code>[TD_CUSTOM id="<?php echo $post->ID; ?>"]</code></center>
	<?php 
}
//=====================
//METABOX: POST_ID, ICONOS, NOMBRE TAB
//=====================
function cts_callback_shortcode($post){
	//COLORES POR DEFECTO
	$colors = get_option('cts_color_defaults');
	//CARGAR META
	$td_data = get_post_meta( $post->ID, 'td_data', true);
	$td_data = maybe_unserialize($td_data);
	$td_options = get_post_meta( $post->ID, 'td_options', true);
	$td_options = maybe_unserialize($td_options);
	//SCRIPTS PARA COLOR PICKER
	if(!wp_style_is('wp-color-picker','enqueued')){wp_enqueue_style( 'wp-color-picker' );}
	if(!wp_script_is('wp-color-picker','enqueued')){wp_enqueue_script( 'wp-color-picker' );}
	//SCRIPTS PROPIOS
	if(!wp_style_is('tabs_css_style','enqueued')){wp_enqueue_style('tabs_css_style', plugins_url( '/css/tab-variable-style.css', __FILE__ )); }
	//LIBRERIA ICONOS
	$css = plugins_url( '/lib/icon-picker/css/dashicons-picker.css', __FILE__ );
    if(!wp_style_is('dashicons-picker','enqueued')){wp_enqueue_style( 'dashicons-picker', $css, array( 'dashicons' ), '1.0' );}
	$js = plugins_url( '/lib/icon-picker/js/dashicons-picker.js', __FILE__ );
	if(!wp_script_is('dashicons-picker','enqueued')){wp_enqueue_script( 'dashicons-picker', $js, array( 'jquery' ), '1.0', true );}
	//LIBRERIA ICONOS WORDPRESS
	if(!wp_style_is('dashicons','enqueued')){wp_enqueue_style( 'dashicons');}
	?>
	<?php _e('Minimo 2, máximo 10 (por ahora)', 'tdlang'); ?>
	<hr>
	<table id="table-tabs" class="icon-manager">
		<td>
		<tr>
		<th><?php _e('Icono', 'tdlang'); ?></th>
		<th><?php _e('Nombre tab', 'tdlang'); ?></th>
		<th><?php _e('Página a mostrar', 'tdlang'); ?></th>
		</tr>
		<?php 
		//FORMULARIO
		if( isset($td_options["tab_count"]) ){
			$i=0;
			foreach($td_data as $data){
				echo '<tr id="tab_' . $i . '">';
				//icons
				echo '<td><span class="dashicons-before  ' . esc_attr($data["ICON"]) . '" name="tab_' . $i . '_icon"></span>';
				echo '<input class="icon-input" id="dashicons_picker_example_icon' . $i .'" data-id="' . $i . '" name="tab_' . $i . '_icon" type="text" value="' . esc_attr($data["ICON"]) . '" />';
				echo '<input class="button dashicons-picker" type="button" value="' . __("Elegir", "tdlang") . '" data-checked="true" data-target="#dashicons_picker_example_icon' . $i .'" /></td>';
				//tab name
				echo '<td><input type="text" class="tab-name" name="tab_' . $i . '_name" value="' . esc_attr($data["NAME"]) . '" required /></td>';
				//dropdown
				echo '<td>';
				wp_dropdown_pages( $args = array( 'name' => 'tab_' . $i . '_id', 'show_option_none' => false, 'selected' => $data["ID"] ) );
				echo '</td></tr>';
				$i++;
			}
		}else{
			for($i=0;$i<=1;$i++){
				echo '<tr id="tab_' . $i . '">';
				//icon picker
				echo '<td><span class="dashicons-before" name="tab_' . $i . '_icon"></span>';
				echo '<input class="icon-input" id="dashicons_picker_example_icon' . $i .'" data-id="' . $i . '" name="tab_' . $i . '_icon" type="text" value="" />';
				echo '<input class="button dashicons-picker" type="button" value="' . __("Elegir", "tdlang") . '" data-checked="true" data-target="#dashicons_picker_example_icon' . $i .'" /></td>';
				//tab name
				echo '<td><input type="text" class="tab-name" name="tab_' . $i . '_name" value="" required /></td>';
				//dropdown
				echo '<td>';
				wp_dropdown_pages( $args = array( 'name' => 'tab_' . $i . '_id', 'show_option_none' => false));
				echo '</td></tr>';
			}
		}
		?>
	</table>
		<hr>
		<a class="button" href="#" id="button-more"  > + </a>
		<a class="button" href="#" id="button-less"  > - </a>
	<input type="hidden" id="tab_count" name="tab_count" value="<?php if( isset($td_options["tab_count"])){echo esc_attr($td_options["tab_count"]); }else{ echo "2"; } ?>" />
	<?php 
	wp_enqueue_script('tab_variabe_manager', plugins_url( '/js/tab-variable-manager.js', __FILE__ ));
	wp_localize_script('tab_variabe_manager', 'colors_default_admin', $colors);
	wp_localize_script('tab_variabe_manager', 'td_data' , array( "choose" => __("Elegir", "tdlang") ) );
}
//=====================
//METABOX: SAVE DATA
//=====================
add_action( 'save_post', 'cts_save_meta' );
function cts_save_meta($post_id){
	//guardar metabox data
	//COLORES POR DEFECTO
	$colors = get_option('cts_color_defaults');
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	$td_new_data = array();
	if(isset($_POST['tab_count'])){
		//DATA
		$opt_final = array ( "tab_count" => sanitize_text_field($_POST['tab_count']) );
		$opt_final = maybe_serialize($opt_final);
		update_post_meta( $post_id, 'td_options', $opt_final );
		for($i = 0; $i <= ($_POST['tab_count']); $i++){
			if(isset($_POST['tab_' . $i . '_name']) && !empty($_POST['tab_' . $i . '_name']) ){
				$new_array = array(
					"ID"		=>  sanitize_text_field($_POST['tab_' . $i . '_id']),
					"ICON"		=>  sanitize_text_field($_POST['tab_' . $i . '_icon']),
					"NAME"		=>  sanitize_text_field($_POST['tab_' . $i . '_name'])
				);
				array_push($td_new_data, $new_array);
			}
		}
		$td_new_data = maybe_serialize($td_new_data);
		update_post_meta( $post_id, 'td_data', $td_new_data );
		//COLORS
		$color_array = array();
		if( isset($_POST['td_background']) && !empty($_POST['td_background']) ){ $color_array["td_background"] =  sanitize_text_field($_POST['td_background']); }else{ $color_array["td_background"] = sanitize_text_field($colors["td_background"]); }
		if( isset($_POST['td_text']) && !empty($_POST['td_text']) ){ $color_array["td_text"] =  sanitize_text_field($_POST['td_text']); }else{ $color_array["td_text"] = sanitize_text_field($colors["td_text"]); }
		if( isset($_POST['td_hover']) && !empty($_POST['td_hover']) ){ $color_array["td_hover"] =  sanitize_text_field($_POST['td_hover']); }else{ $color_array["td_hover"] = sanitize_text_field($colors["td_hover"]); }
		if( isset($_POST['td_icon']) && !empty($_POST['td_icon']) ){ $color_array["td_icon"] =  sanitize_text_field($_POST['td_icon']); }else{ $color_array["td_icon"] = sanitize_text_field($colors["td_icon"]); }
		if( isset($_POST['td_active']) && !empty($_POST['td_active']) ){ $color_array["td_active"] =  sanitize_text_field($_POST['td_active']); }else{ $color_array["td_active"] = sanitize_text_field($colors["td_active"]); }
		$color_array = maybe_serialize($color_array);
		update_post_meta( $post_id, 'td_colors', $color_array );
	}
}
//=====================
//METABOX: SAVE DATA
//=====================
add_filter( 'manage_customtabshortcode_posts_columns', 'cts_set_custom_edit_customtabshortcode_columns' );
function cts_set_custom_edit_customtabshortcode_columns($columns) {
    $columns['customtabshortcode'] = 'Tabs Shortcodes';
    return $columns;
}
add_action( 'manage_customtabshortcode_posts_custom_column' , 'cts_custom_customtabshortcode_column', 10, 2 );
function cts_custom_customtabshortcode_column( $column, $post_id ) {
	switch ( $column ) {
		case 'customtabshortcode':
			echo esc_html('[TD_CUSTOM id="' . $post_id . '"]');
			break;
	}
}
 ?>