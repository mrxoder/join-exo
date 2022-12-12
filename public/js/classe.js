$(document).ready(function(){
   
   function getList(){
	   
	   header ={ url:"index.php",type:"post",dataType:"json",data:{"action":"getlist", "page":"classe"}, async:false, success:function(res){
		       if(res.status=="success"){
				   title = $(`<th>ID</th><th>Libelle</th><th>Capacité</th> <th>Action</th>`);
				   $("#list").html("");
				   title.appendTo($("#list"));
				   res.data.map(function(item){
					   
					   row = $(`<tr> <td>${item.id}</td> <td>${item.libelle}</td> <td>${item.capacite}</td> <td><button class="btn btn-danger delete" classid="${item.id}">Delete</button> <button class="btn btn-success edit" classid="${item.id}">edit</button></td> </tr>`);
					   row.appendTo($("#list"));
					   
				   });
				   
				   $(".delete").click(function(){
	   
							   data ="page=classe&action=delete&id="+$(this).attr("classid");
							   
							   header ={ url:"index.php",type:"post",dataType:"json",data:data, success:function(res){
								       if(res.status=="success"){
										   pop("Success");
									   }else{ pop("Failed.", "text-danger");}
							   } };
							   
							   $.ajax(header);
							   
				  });
				   $(".edit").click(function(){
	   
							   data ="page=classe&action=edit&id="+$(this).attr("classid");
							   console.log($(this).attr("classid"));
							   header ={ url:"index.php",type:"post",dataType:"json",data:data, success:function(res){
								       if(res.status=="success"){
										   
										   $("#id").val(res.id);
										   $("#libelle").val(res.libelle);
										   $("#capacity").val(res.capacite);

									   }else{ pop("Failed.", "text-danger");}
							   } };
							   
							   $.ajax(header);
							   
				  });
				     
			   }else{ pop("Failed.", "text-danger");}
	   } };
	   
	   $.ajax(header);
	   
	   
   }
   
    
   $("#form").submit(function(e){
	   e.preventDefault();
	   
	   data = $(this).serialize();
	   data +="&page=classe&action=update";
	   
	   header ={ url:"index.php",type:"post",dataType:"json",data:data, success:function(res){
		       if(res.status=="success"){
				   getList();
			   }else{ pop("Failed.", "text-danger");}
	   } };
	   
	   $.ajax(header);
   });
   
   
   
   getList();
   
   
   
});
