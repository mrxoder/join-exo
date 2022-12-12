$(document).ready(function(){
   
   
   function getList(classid){
	   
	   header ={ url:"index.php",type:"post",dataType:"json",data:{"action":"getlist", "page":"professor", "classid":classid}, success:function(res){
		       if(res.status=="success"){
				   title = $(`<th>ID</th> <th>Nom</th> <th>Naissance</th> <th>Adresse</th> <th>Competence</th> <th>Classe</th> <th>Action</th>`);
				   $("#list").html("");
				   title.appendTo($("#list"));
				   res.data.map(function(item){
					   n = (item.naissance).split("#");
					   n = n.join(" ");
					   
					   row = $(`<tr> <td>${item.id}</td> <td>${item.nom}</td> <td>${n}</td> <td>${item.adresse}</td> <td>${item.nomMatiere}</td> <td>${item.libelle}</td> <td><button class="btn btn-danger delete" id="${item.id}">Delete</button> <button class="btn btn-success edit" id="${item.id}" classid="${classid}">edit</button></td> </tr>`);
					   row.appendTo($("#list"));
					     
				   });
				   
				   $(".delete").click(function(){
	   
							   data ="page=professor&action=delete&id="+$(this).attr("courseid");
							   
							   header ={ url:"index.php",type:"post",dataType:"json",data:data, success:function(res){
								       if(res.status=="success"){
										   pop("Success");
										   getList(classid);
									   }else{ pop("Failed.", "text-danger");}
							   } };
							   
							   $.ajax(header);
							   
				  });
				   $(".edit").click(function(){
							   data ="page=professor&action=edit&id="+$(this).attr("id")+"&classid="+$(this).attr("classid");
							   
							   header ={ url:"index.php",type:"post",dataType:"json",data:data, success:function(res){
								       if(res.status=="success"){
										   res = res.data;
										   date = (res.naissance).split("#");
										   $("#date").val(date[0]);
										   $("#lieu").val(date[1]);
										   $("#id").val(res.id);
										   $("#nom").val(res.nom);
										   $("#matiere").val(res.nomMatiere);
										   $("#addr").val(res.adresse);
										   $("#description").text(res.description);

									   }else{ pop("Failed.", "text-danger");}
							   } };
							   
							   $.ajax(header);
							   
				  });
				     
			   }else{ pop("Failed.", "text-danger");}
	   }};
	   
	   $.ajax(header);
	   
	   
   }
   
   function getClasse(){
	   
	   return new Promise(function(resolve, reject){
			   header={ url:"index.php",type:"post",dataType:"json",async:false, data:{"action":"getlist", "page":"classe"}, success:function(res){
				       if(res.status=="success"){
						   
						   if(res.data.length>0){
							  ids = [];
						      $("#classe").html("");
						      res.data.map(function(item){
								  $(`<option value=${item.id}>${item.libelle}</option>`).appendTo($("#classe"));
								  ids.push(item.id);
						      });
						      resolve(ids);
						   }
					   }
				   }
			   }
			   
			   $.ajax(header);
       });
   }
   
   function getCourse(){
	   
	   header ={ url:"index.php",type:"post",dataType:"json",data:{"action":"getlist", "page":"course"}, success:function(res){
		       if(res.status=="success"){
				   
				   if(res.data.length>0){
					  
				      $("#matiere").html("");
				      res.data.map(function(item){
						  $(`<option value=${item.id}>${item.nommatiere}</option>`).appendTo($("#matiere"));
				      });
				   }
			   }
		   }
	   }
	   
	   $.ajax(header);
   }
   
   
   $("#form").submit(function(e){
	   
	   e.preventDefault();
	   
	   data = $(this).serialize();
	   data +="&page=professor&action=update&date="+$("#date").val();
	   
	   header ={ url:"index.php",type:"post",dataType:"json",data:data, success:function(res){
		       if(res.status=="success"){
				   $("#form").trigger("reset");
				   getList($("#classe").val());
				   
			   }else{ pop("Failed.", "text-danger");}
	   } };
	   
	   $.ajax(header);
   });
   
   
   getCourse();
   getClasse().then(function(ids){
	   getList(ids[0]);
	   
	   $("#classe").change(function(){
	      getList($(this).val());
       });
   });
   
   
   
});
