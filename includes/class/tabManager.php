<?php 
if(!class_exists('tabManager')){

	class tabManager {
	 
		public $id;
		public $colors = array();
		public $IDarray = array();
		public $data = array();
		public $options = array();
		public $defaults = array();
		public $icons = array();
		public $custom = false;
		public $isNew = false;
		public $isEdit = false;
		public $isDay = false;
		public $loadPosts = false;
		public $print = '';

		public function __construct($type = "", $customTabId = ""){
			switch($type){
				case "day":
					$this->id = random_int(99, 999);
					$this->isDay = true;
					break;
				case "custom":
					$this->id = $customTabId;
					$this->custom = true;
					break;
				case "new":
					$this->id = $customTabId;
					$this->isNew = true;
					break;
				case "edit":
					$this->id = $customTabId;
					$this->isEdit = true;
					break;
				default:
					$this->id = $customTabId;
					$this->isNew = true;
					break;
			}
			$this->getData();
			$this->getStyles();
			$this->getMenu();
			$this->getContents();
		}

		function getData(){
			$this->defaults = get_option('cts_color_defaults');
			if($this->custom || $this->isEdit){
				$this->colors = get_post_meta( $this->id, 'td_colors', true);
				$this->colors = maybe_unserialize($this->colors);
				$this->data = get_post_meta( $this->id, 'td_data', true);
				$this->data = maybe_unserialize($this->data);
				$this->options = get_post_meta( $this->id, 'td_options', true);
			}else if($this->isDay){
				$this->colors = get_option('cts_config');
				$this->icons = get_option('cts_icons');
				$this->titles = array(
					__('Lunes', 'tdlang'),
					__('Martes', 'tdlang'),
					__('Miercoles', 'tdlang'),
					__('Jueves', 'tdlang'),
					__('Viernes', 'tdlang'),
					__('Sabado', 'tdlang'),
					__('Domingo', 'tdlang'),
				);
				$this->IDarray = array(
					get_option('cts_lunes'),
					get_option('cts_martes'),
					get_option('cts_miercoles'),
					get_option('cts_jueves'),
					get_option('cts_viernes'),
					get_option('cts_sabado'),
					get_option('cts_domingo'),
				);
			}else if($this->isNew){
				$this->colors = $this->defaults;
			}
		}

		function getMenu(){
			
			if($this->custom || $this->isEdit){

				$this->print .= '<div id="' . $this->id . '" class="tab-menu-container" data-color="' . esc_attr($this->colors["td_active"]). '"><ul class="tab-menu-ul" id="tab-menu-ul">';
				$i=0;
				foreach($this->data as $d){
					$this->print .= '<li class="tab-menu-li" id="' . $i . '"><a class="tab-menu-dias dashicons-before ' . esc_attr($this->data[$i]["ICON"]) . '" id="' . $i . '" >' . esc_attr($d["NAME"]) . '</a></li>' ;
					$i++;
				}

			}else if($this->isDay){

				$this->print .= '<div id="' . $this->id . '" class="tab-menu-container" data-type="days" data-color="' . esc_attr($this->colors["td_active"]). '"><ul class="tab-menu-ul" id="tab-menu-ul">';
				$i=1;
				$z=0;
				$icons = array_values($this->icons);
				foreach($this->titles as $title){
					if($i == 7){ $i = 0;}
					$this->print .= '<li class="tab-menu-li" id="' . $i . '"><a class="tab-menu-dias dashicons-before ' . esc_attr($icons[$z]) . '" id="' . $i . '" >' . esc_attr($title) . '</a></li>' ;
					$i++;
					$z++;
				}

			}else if($this->isNew){

				$this->print .= '<div id="' . $this->id . '" class="tab-menu-container" data-color="' . esc_attr($this->colors["td_active"]). '"><ul class="tab-menu-ul" id="tab-menu-ul">';
				if(!empty($this->data)){
					$i=0;
					foreach($this->data as $d){
						$i++;
						if($i == 7){ $i = 0;}
						$this->print .= '<li class="tab-menu-li" id="' . $i . '"><a class="tab-menu-dias dashicons-before ' . esc_attr($d["ICON"]) . '" id="' . $i . '" >' . esc_attr($d["NAME"]) . '</a></li>' ;
					}
					$i = 0;
				}else{
					$this->print .= '<li class="tab-menu-li" id="0"><a class="tab-menu-dias dashicons-before" id="0" >Example 1</a></li>' ;
					$this->print .= '<li class="tab-menu-li" id="1"><a class="tab-menu-dias dashicons-before" id="1" >Example 2</a></li>' ;
				}
			}
			$this->print .= '</ul></div>';
		}

		function getContents(){
			if($this->custom || ($this->isEdit && $this->loadPosts) ){
				$i=0;
				foreach($this->data as $d){
					$this->print .= '<div class="tab-content '. $this->id. '" id="' . $i . '" data-id="' . $this->id . '" data-postId="' . $d["ID"] .'"style="display:none;"> ';
					$this->print .= apply_filters( 'the_content', get_post_field('post_content', $d["ID"]) );
					$this->print .= ' </div>';
					$i++;
				}
			}else if($this->isDay){
				$i=0;
				foreach($this->IDarray as $id){
					$i++;
					if($i == 7){ $i = 0;}
					$this->print .= '<div class="tab-content '. $this->id. '" id="' . $i . '" data-id="' . $this->id . '" style="display:none;"> ';
					$this->print .= apply_filters( 'the_content', get_post_field('post_content', $id) );
					$this->print .= ' </div>';
				}
			}else if($this->isNew || ($this->isEdit && !$this->loadPosts) ) {
				//DEFAULT TABS
				for($z=0;$z<=9;$z++){
					$this->print .= '<div class="tab-content" id="' . $z . '" data-id="'. $this->id. '" style="display:none;">';
					$this->print .= '<h3>Example window number ' . ($z+1). '</h3>';
					$this->print .= "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc. ";
					$this->print .= '</div>';
				}
			}
		}

		/* STYLES */
		function getStyles(){
			$this->print .= '<style id="css-icons">';

			$this->print .= ' [id="' . $this->id . '"] .tab-menu-dias.dashicons,[id="' . $this->id . '"] .tab-menu-dias.dashicons-before:before{ color: ' . esc_attr($this->colors["td_icon"]). ' !important; }';

			$this->print .= '</style>';
			$this->print .= '<style id="css-active">';

			$this->print .= ' [id="' . $this->id . '"].tab-menu-container > .tab-menu-ul{ border-bottom-color:' . esc_attr($this->colors["td_active"]). ' !important; }';
			$this->print .= '[data-id="' . $this->id . '"].tab-content{ border-color: ' . esc_attr($this->colors["td_active"]). ' !important; }';

			$this->print .= '</style>';
			$this->print .= '<style id="css-background">';

			$this->print .= '[id="' . $this->id . '"].tab-menu-container .tab-menu-ul{ background-color: ' . esc_attr($this->colors["td_background"]). ' !important; }';

			$this->print .= '</style>';
			$this->print .= '<style id="css-hover">';

			$this->print .= ' [id="' . $this->id . '"] .tab-menu-li a:hover{ background-color: ' . esc_attr($this->colors["td_hover"]). ' !important; }';

			$this->print .= '</style>';
			$this->print .= '<style id="css-text">';

			$this->print .= ' [id="' . $this->id . '"] .tab-menu-li a:hover, [id="' . $this->id . '"] .tab-menu-li a:focus, [id="' . $this->id . '"] .tab-menu-ul,[id="' . $this->id . '"].tab-menu-container .tab-menu-li a{ color: ' . esc_attr($this->colors["td_text"]). ' !important; }';

			$this->print .= '</style>';
			return $this->colors;
		}
	}
}else{
	echo "Error with class name";
}
?>