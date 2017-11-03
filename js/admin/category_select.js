var $=jQuery;

$(function(){
	
	$(".eap_categories_widget_menu").each(function(index, element) {
        
		$(this).dropdown({
			searchable : true
		});
		
    });
	
});