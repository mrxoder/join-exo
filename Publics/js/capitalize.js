$(document).ready(function(){
	
	$(".content").on("DOMSubtreeModified", function(){
		
		$('input[type="text"]').change(function(){
			
			var value = $(this).val();
			value = value.charAt(0).toUpperCase() + value.slice(1);
			$(this).val(value);
			
		});
    });
	
	
});
