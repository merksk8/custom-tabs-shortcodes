jQuery(document).ready(function ($) {
	$('.tab-menu-container').each(function(){
		var color = $(this).attr("data-color");
		var type = $(this).attr("data-type");
		var mainId = $(this).attr("id");
		var dotw = new Date().getDay();
		if(type == "days"){
			var newItem = $(this).children().find("#" + dotw).children();
		}else{
			var newItem = $(this).children().children().children().first();
		}
		var newContent = $("#" + newItem.attr("id") + ".tab-content[data-id=" + mainId + "]");
		newItem.attr('style', 'background-color: ' + color + ' !important;');
		newItem.parent().addClass("active");
		setTimeout(function(){
			newContent.fadeIn(250);
		}, 151);
	});
	$(".tab-menu-ul").on("click", ".tab-menu-dias", function(event){
		var container = $(this).parent().parent().parent();
		var mainId = container.attr("id");
		var color = container.attr("data-color");
		var tabId = $(this).attr("id");
		var pastId = $("#" + mainId + " .active a").parent().parent().parent().attr("id");
		var newItem = $(this);
		var newContent = $("#" + tabId + ".tab-content[data-id=" + mainId + "]");
		var currentItem = $("#" + mainId + " .active a");
		var currentTab = $("#" + currentItem.attr("id") + ".tab-content[data-id=" + pastId + "]");
		currentItem.attr('style', 'background-color: transparent;');
		currentItem.parent().removeClass("active");
		currentTab.fadeOut(150);
		newItem.attr('style', 'background-color: ' + color + ' !important;');
		newItem.parent().addClass("active");
		setTimeout(function(){
			newContent.fadeIn(300);
		}, 160);		
	});
});