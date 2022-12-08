$(document).ready(function(){
    
    
    function gethtml(page){
		console.log("getting "+page);
		page = page.trim();
		$.ajax({
			url:"index.php",
			type:"post",
			data:{"page":page},
			success:function(data){
				$("#css").attr("href", `public/${page}.css`);
			    $("#content").html(data);
			}
		});
		
	 }
	
    
    $(".item").click(function(){
		
		$(".item").map(function(i){ 
			($(".item")[i]).className = "item";
	    });
		this.className ="item active";
		gethtml((this.text).toLowerCase());
	});
    
});
