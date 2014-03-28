(function( $ ){
var scrollforward=function(w,wc,speed,el,scd){
			$(el).find('nobr').delay(scd).animate({left:-(w-wc)},speed,function(){scrollbackward(w,wc,speed,el,scd);});
}
var scrollbackward=function(w,wc,speed,el,scd){
			$(el).find('nobr').delay(scd).animate({left:0},speed,function(){
			scrollforward(w,wc,speed,el,scd);
			});
}
jQuery.fn.marquee = function(options) {

	var settings={
		speed_coef:1500,
		roll_delay: 500
	}
	
	if(options){
		$.extend(settings,options);
	}
	
	return this.each(function(){
		$(this).html('<nobr>'+$(this).html()+'</nobr>');
		$(this).find('nobr').css({position:'absolute',left:0,top:0});
		var width=$(this).find('nobr').width();
		var widthContainer=$(this).width();		
		var speed=settings.speed_coef*(width/widthContainer);
		if(width>widthContainer){
			scrollforward(width,widthContainer,speed,this,settings.roll_delay);
		}		
	});
	
};
})( jQuery );