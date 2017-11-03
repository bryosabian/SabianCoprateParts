$(function(){ 

var navbar=$("#sabian_nav");

var mobile_navbar=$("#sabian_nav_collapse");

var middle_bar=$("#navbar_middle");

/*Scroll*/
var $window=$(window);

var logoc=$(".logo");

var logoText=logoc.find('#logo_text');

$window.scroll(function(e) {
	
	var active=true;
	
	if(!active)
	return;
	
	var top=$(window).scrollTop();
	
	var tHeight=middle_bar.height()+navbar.height();
	
	if(top>tHeight && middle_bar.length){
		middle_bar.addClass("sticky");
		
		if($window.width()<=991)
		logoText.show();
		
	}else{
		if(middle_bar.hasClass("sticky"))
		  middle_bar.removeClass("sticky");
		  logoText.hide();
	}
});

/*Bootstrap select*/
	$(".selectPicker").each(function(index, element) {
        
		var _this=$(this);
		
		_this.selectpicker({
			style: 'btn-info',
			size: 4
		});
	});

});

/*Product image slider*/
	
	var galItems=[];
	
	$(".gallery").each(function(index, element) {
        
		var src=$(this).attr("href");
		
		galItems[index]={src : src};	
		
    });
	
	$('body').magnificPopup({
			
			delegate : 'a.gallery',
			
			gallery : { enabled : true},
			
			type : 'image',
			
			/*zoom : { enabled : true , duration : 300, easing : 'ease-in-out' , opener : function(e) {  } }*/
			
			callbacks : {	
				
				open : function(){
					
					//page_header.backstretch('pause');	
				},
				
				close : function(){
					
					//page_header.backstretch('resume');
				}
			}

});

/*Woocommerce nad WP*/

var _sel=$('#order_items');


var _orderForm=$(".sb-wc-items");

_sel.change(function(e) {
    _orderForm.trigger('submit');
});