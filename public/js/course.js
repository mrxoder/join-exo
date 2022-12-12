$(document).ready(function(){
   
   function getList(){
	   
	   header ={ url:"index.php",type:"post",dataType:"json",data:{"action":"getlist", "page":"course"}, async:false, success:function(res){
		       if(res.status=="success"){
				   title = $(`<th>ID</th> <th>Matière</th> <th>Coefficient</th> <th>Descrisption</th>  <th>Action</th>`);
				   $("#list").html("");
				   title.appendTo($("#list"));
				   res.data.map(function(item){
					   
					   row = $(`<tr> <td>${item.id}</td> <td>${item.nommatiere}</td> <td>${item.coefficient}</td> <td>${item.description}</td> <td><button class="btn btn-danger delete" classid="${item.id}">Delete</button> <button class="btn btn-success edit" courseid="${item.id}">edit</button></td> </tr>`);
					   row.appendTo($("#list"));
					   
				   });
				   
				   $(".delete").click(function(){
	   
							   data ="page=course&action=delete&id="+$(this).attr("courseid");
							   
							   header ={ url:"index.php",type:"post",dataType:"json",data:data, success:function(res){
								       if(res.status=="success"){
										   pop("Success");
									   }else{ pop("Failed.", "text-danger");}
							   } };
							   
							   $.ajax(header);
							   
				  });
				   $(".edit").click(function(){
	   
							   data ="page=course&action=edit&id="+$(this).attr("courseid");
							   
							   header ={ url:"index.php",type:"post",dataType:"json",data:data, success:function(res){
								       if(res.status=="success"){
										   res = res.data;
										   $("#id").val(res.id);
										   $("#nom").val(res.nommatiere);
										   $("#coef").val(res.coefficient);
										   $("#description").text(res.description);

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
	   data +="&page=course&action=update";
	   
	   header ={ url:"index.php",type:"post",dataType:"json",data:data, success:function(res){
		       if(res.status=="success"){
				   getList();
				   $("#form").trigger("reset");
			   }else{ pop("Failed.", "text-danger");}
	   } };
	   
	   $.ajax(header);
   });
   
   
   
   getList();
   
   
   
});
