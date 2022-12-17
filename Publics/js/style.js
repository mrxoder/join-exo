$(document).ready(function(){

    
    var half = function(){
		
		$(".half").css({
			"height":($(window).height()*0.30)+"px",
			"overflow":"scroll",
			"width":"100%"
	    });
	}
	
	half();
	
	$(window).resize(function(){ 
		half();
	});
	
	$("#content").on("DOMSubtreeModified",function(){ 
		half();
	});
	
});
