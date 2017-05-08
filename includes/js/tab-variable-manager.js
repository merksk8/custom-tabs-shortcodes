jQuery(document).ready(function ($) {
	$('#td_background.color_picker').wpColorPicker({
		defaultColor: colors_default_admin.td_background,
		change: function(event, ui){
			$("#css-background").html('.tab-menu-ul, .tab-menu-li a{ background-color: ' + ui.color.toString() + " !important; }" );
		},
		clear: function() {
			$("#css-background").html('.tab-menu-ul, .tab-menu-li a{ background-color: ' + colors_default_admin.td_background + ' !important; }' );
		},
		hide: true,
		palettes: true
	});
	$('#td_icon.color_picker').wpColorPicker({
		defaultColor: colors_default_admin.td_icon,
		change: function(event, ui){
			$("#css-icons").html('.tab-menu-dias .dashicons, .tab-menu-dias.dashicons-before:before{color:' + ui.color.toString() + " !important; }" );
		},
		clear: function() {
			$("#css-icons").html('.tab-menu-dias .dashicons, .tab-menu-dias.dashicons-before:before{color: ' + colors_default_admin.td_icon + ' !important; }' );
		},
		hide: true,
		palettes: true
	});
	$('#td_text.color_picker').wpColorPicker({
		defaultColor: colors_default_admin.td_text,
		change: function(event, ui){
			$("#css-text").html('.tab-menu-li a:hover, .tab-menu-li a:focus, .tab-menu-ul, .tab-menu-li a{	color: ' + ui.color.toString() + " !important; }" );
		},
		clear: function() {
			$("#css-text").html('.tab-menu-li a:hover, .tab-menu-li a:focus, .tab-menu-ul, .tab-menu-li a{	color: ' + colors_default_admin.td_text + ' !important; }' );
		},
		hide: true,
		palettes: true
	});
	$('#td_hover.color_picker').wpColorPicker({
		defaultColor: colors_default_admin.td_hover,
		change: function(event, ui){
			$("#css-hover").html('.tab-menu-li a:hover, .tab-menu-li a:focus { background-color: ' + ui.color.toString() + " !important; }" );
		},
		clear: function() {
			$("#css-hover").html('.tab-menu-li a:hover, .tab-menu-li a:focus { background-color: ' + colors_default_admin.td_hover + ' !important; }' );
		},
		hide: true,
		palettes: true
	});
	$('#td_active.color_picker').wpColorPicker({
		defaultColor: colors_default_admin.td_active,
		change: function(event, ui){
			var idsa = $(".tab-menu-li.active").attr("id").toString();
			$("a#" + idsa + ".tab-menu-dias").first().attr('style', "background-color: " + ui.color.toString() + " !important");
			color_active = ui.color.toString();
			$("#css-active").html(".tab-menu-container > .tab-menu-ul{ border-bottom-color:" + ui.color.toString() + " !important; } .tab-content{border-color:" + ui.color.toString() + "!important; } ");
		},
		clear: function() {
		},
		hide: true,
		palettes: true
	});
	//ICON PICKER
	$(document).on("iconSelected", function(var1,var2){
		var var1;
		var var2;
		$(".icon-input").each( function(){
			if( $(this).val() !== "" ){
				//cambiar icono lista
				var icon_id = $(this).attr("name");
				$("span[name=" + icon_id + "]").removeClass();
				$("span[name=" + icon_id + "]").addClass("dashicons-before");
				$("span[name=" + icon_id + "]").addClass($(this).val());
				//cambiar icono tabs
				var menu_id = $(this).attr("data-id");
				$("#" + menu_id + ".tab-menu-dias").removeClass().addClass("tab-menu-dias");
				var to_change = $("#" + menu_id + ".tab-menu-dias");
				to_change.addClass("dashicons-before");
				to_change.addClass("tab-menu-dias");
				to_change.addClass($(this).val() );
			}else{
				//cambiar icono lista
				var icon_id = $(this).attr("name");
				$("span[name=" + icon_id + "]").removeClass();
				$("span[name=" + icon_id + "]").addClass("dashicons-before");
				//cambiar icono tabs
				var menu_id = $(this).attr("data-id");
				$("#" + menu_id + ".tab-menu-dias").removeClass().addClass("tab-menu-dias");
				var to_change = $("#" + menu_id + ".tab-menu-dias");
				to_change.addClass("dashicons-before");
				to_change.addClass("tab-menu-dias");
			}
		});	
	});	
	$(".icon-manager").on("click", ".dashicons-before", function(){				
		var element_main = $("input[name=" + $(this).attr("name") + "]");		
		element_main.val("");		
		var icon_id = $(element_main).attr("name");	
		$(this).removeClass();
		$(this).addClass("dashicons-before");
		//cambiar icono tabs
		var menu_id = $(element_main).attr("data-id");
		$("#" + menu_id + ".tab-menu-dias").removeClass().addClass("tab-menu-dias");
		var to_change = $("#" + menu_id + ".tab-menu-dias");
		to_change.addClass("dashicons-before");
		to_change.addClass("tab-menu-dias");
	});
	$("#table-tabs").on("keyup", ".tab-name", function(event){		
		var input_name = $(this).val();		
		var id = $(this).parent().parent().attr("id").replace( /^\D+/g, '');		
		if( $('#' + id + '.tab-menu-dias') !== null ){			
			$('#' + id + '.tab-menu-dias').html(input_name);			
		}else{
			return;			
		}			
	});	
	$("#button-more").click(function(){
		if( $('#tab_count').val() <= 9){				
			var qty = Number($('#tab_count').val()) + 1;			
			$('#tab_count').val( qty );	
			qty = qty -1;	
			$('#table-tabs').append('<tr id="tab_' + qty.toString() + '">  </tr>');	
			$('#tab_' + qty.toString() ).append('<td></td>');			
			$('#tab_' + qty.toString() ).children().first().append('<span class="dashicons-before" name="tab_' + qty.toString() + '_icon"></span>');
			$('#tab_' + qty.toString() ).children().first().append('<input class="icon-input" id="dashicons_picker_example_icon' + qty.toString() + '" data-id="' + qty.toString() + '"name="tab_' + qty.toString() + '_icon" type="text" value="" />');
			$('#tab_' + qty.toString() ).children().first().append(' <input data-checked="false" class="button dashicons-selector" type="button" value="' + td_data.choose.toString() + '" data-target="#dashicons_picker_example_icon' + qty.toString() + '" />');
			$('#tab_' + qty.toString() ).append('<td></td>');
			$('#tab_' + qty.toString() ).children().eq(1).append('<input type="text" class="tab-name" name="tab_' + qty.toString() + '_name" value="" required />');			
			$("#tab-menu-ul").append('<li class="tab-menu-li" id="' + qty.toString() + '"><a href="#" class="tab-menu-dias dashicons-before" id="' + qty.toString() + '"></a></li>');
			var dropdown = $('#tab_1_id').clone();
			dropdown.attr("id", "tab_" + qty.toString() + "_id").attr("name", "tab_" + qty.toString() + "_id");
			$('#tab_' + qty.toString() ).append('<td></td>');
			$('#tab_' + qty.toString() ).children().eq(2).append(dropdown);
			var newContent = $("#0.tab-content").clone();
			newContent.html("");
			newContent.attr("id", qty.toString());
			newContent.attr("data-postid", "");
			newContent.attr("style", "display:none;");
			newContent.appendTo($("#0.tab-content").parent());
			//fix dashicon picker loading 
			$(".dashicons-selector").each( function(){
				if( $(this).attr("data-checked") == "false" ){
					$(this).dashiconsPicker();
					$(this).attr("data-checked", "true");
				}
			} );
		}
	});
	$("#button-less").click(function(){
		if( $('#tab_count').val() > 2){
			var qty = Number($('#tab_count').val()) - 1;
			console.log(qty);			
			$('#tab_count').val( qty );					
			$('.tab-menu-ul').children().last().remove();		
			$('#table-tabs').children().children().last().remove();		
			$('.tab-content').last().remove();		
		}	
	});	
});