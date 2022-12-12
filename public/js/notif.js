function pop(text, type="text-success"){
	
	var b = $("#notif");
	b.attr("className", type);
	b.text(text);
	b.show(0, function(){
		b.hide(2000);
	});
	
}
