$(document).ready(function(){
    
   function bind(pageobj, classid=undefined){
		   
		   $(".delete").click(function(){
				   
				   pageobj.actiondelete(this, function(){
					   
					   if(classid!=undefined){
					     pageobj.getlist(classid);
					   }else{
						 pageobj.getlist();
					   }
					   
				   });   
		   });
		   
		   $(".edit").click(function(){
				   
				   if(classid!=undefined){
				     pageobj.getlist(classid);
				   }else{
					 pageobj.getlist();
				   }
		   });
   }
   
   class app{
	   
	   constructor(){
		   
		   this.page = $(".item")[0].text.trim();
		   var th = this;
		   
		   var baseuri = document.baseURI;
		   baseuri = baseuri.split("?");
		   
		   var routes = ["school", "classe", "course", "professor", "student", "admin","logout"];
		   
		   if(baseuri.length==2){
			   baseuri = (baseuri[1]).split("&");
			   baseuri.map(function(param){
				   param = param.split("=");
				   if(param[0]=="page"){
					   if(routes.includes((param[1]).trim())){
						   th.page = (param[1]).trim();
					   }
				   }
			   });
		   }
		   
		   
		   
		   
		   
		   var tmp = this.page.charAt(0).toUpperCase() + this.page.slice(1);
		   console.log("tmp: ", tmp);
		   this.active($(`.item:contains(${tmp})`)[0]);
		   
		   $(".item").click(function(e){
			   th.active(e.target);
		   });
		   		   
	   }
	   
	   active(item){
		   
		   $(".item").map(function(i){ 
			   ($(".item")[i]).className = "item";
		   });
		   item.className ="item active";
		   document.title=(item.text).trim();
		   this.page = (item.text).trim().toLowerCase()
		   var page = this.page;
		   var th = this;
		   this.gethtml(function(){
			   
			   var pageobj = eval(`new ${page};`);
			   
			   if(page=="professor" || page=="students" ){
						
						var header={ url:"classe/getlist", type:"post", dataType:"json", async:false,success:function(data){
					
						if(data.status=="success"){
								
									var total = [data.totalst, data.totalprf];
									var data = data.data;
									
									data.map(function(element){
										$(`<option value="${element.id}">${element.libelle}</option>`).appendTo($("#classe"));
									});
									
									pageobj.getlist((data[0]).id);
									$("#classe").change(function(){
										pageobj.getlist($(this).val());
										
									});
									
								}else{ 
									new swal({
										  title: "Failed",
										  text: "",
										  icon: "error",
										});
								}
							 }
						}
				        
				        $.ajax(header);
				        
				        if(page=="professor"){
							   
							   header ={ url:"course/getlist", type:"post", dataType:"json", async:false, success:function(res){
						       if(res.status=="success"){
								   
								   res.data.map(function(item){
									   	$(`<option value="${item.id}">${item.nommatiere}</option>`).appendTo($("#matiere"));			   
								   });
								   
								     
							   }else{ 
								   
								   new swal({
									  title: "Failed",
									  text: "",
									  icon: "error",
									});
								   
								   }
					           } };
						   
						   $.ajax(header);
						}
			   }else{
			      pageobj.getlist();
			      
			   }
			   
			   
			   
			   $("#form").submit(function(e){
					   e.preventDefault();
					   
					   var data = $(this).serialize();
					   
					   var header ={ url:`${th.page}/update`,type:"post",dataType:"json",data:data, success:function(res){
						       
						       if(res.status=="success"){
								   console.log("success");
							   }else{ 
								   
								   new swal({
									  title: "Failed",
									  text: "",
									  icon: "error",
									});
								   
								   }
							   if(th.page.trim()=="professor" || th.page.trim()=="students"){
							      pageobj.getlist($("#classe").val());
							   }else{
							      pageobj.getlist();
							   }
							   
							   $("#id").attr("value", "");
						       $("#description").text("");
							   $("#form")[0].reset();
							   
					   } };
					   
					   $.ajax(header);
		       });
			   
		   });
		   
	   }
	   
	   gethtml(callback=undefined){
		    var page = this.page.trim();
			$.ajax({
				url:`${page}`,
				type:"get",
				success:function(data){
					$("#css").attr("href", `Publics/css/${page}.css`);
				    $("#content").html(data);
				    if(callback!=undefined){
						callback();
					}
				}
			});
		
	  }
	  
   }
    
    
    
    
   class classe{
	      
	   getlist(){
	      var th = this;
	      var header ={ url:"classe/getlist",type:"post",dataType:"json", async:false, success:function(res){
		       if(res.status=="success"){
				   var title = $(`<th>ID</th><th>Libelle</th><th>Capacité</th> <th>Action</th>`);
				   $("#list").html("");
				   title.appendTo($("#list"));
				   res.data.map(function(item){
					   
					   var row = $(`<tr> <td>${item.id}</td> <td>${item.libelle}</td> <td>${item.capacite}</td> <td><button class="btn btn-danger delete" classid="${item.id}">Delete</button> <button class="btn btn-success edit" classid="${item.id}">edit</button></td> </tr>`);
					   row.appendTo($("#list"));
					   
				   });
				   
				   bind(th);
				   
			   }else{ 
				   new swal({
						  title: "Failed",
						  text: "unkown error",
						  icon: "error",
				   });
			   }
	     }};
	   
	      $.ajax(header);
	   
       }
       
       actiondelete(btn, callback=undefined){
		   var classid = $(btn).attr("classid");
		   var th = this;		   
		   var header ={ url:`classe/delete/${classid}`,type:"post",dataType:"json", success:function(res){
			       if(res.status=="success"){
					   th.getlist();
				   }else{ 
					   new swal({
						  title: "Failed",
						  text: "delete all students and professors in this classe before.",
						  icon: "error",
						});
				   }
				   
				   if(callback!=undefined){
						   callback();
				   }
		   } };
		   $.ajax(header);
	   }
	   
       actionedit(btn, callback=undefined){
			   
			   var classid = $(btn).attr("classid");
			   var header ={ url:`classe/get/${classid}`,type:"post",dataType:"json", success:function(res){
				       if(res.status=="success"){
						   
						   var res = res.data[0];
						   
						   $("#id").val(res.id);
						   $("#libelle").val(res.libelle);
						   $("#capacity").val(res.capacite);
						   
					   }else{ 
						   
						   new swal({
							  title: "Failed",
							  text: "",
							  icon: "error",
							});
						   
						   
						   }
					   
					   if(callback!=undefined){
						   callback();
					   }
			   } };
			   
			   $.ajax(header);
	   }
	   
		   
   }   
   
   class school{
	   getlist(){
			   var header={ url:"school/getlist", type:"post", dataType:"json",success:function(data){
			
				if(data.status=="success"){
						
						var total = [data.totalst, data.totalprf];
						var data = data.data;
						
						data.map(function(element){
							student = $(`<tr> <td>${element.name}</td> <td>${element.students}/${element.capacite}</td> </tr>`);
							prof = $(`<tr> <td>${element.name}</td> <td>${element.profs}</td> </tr>`);
							student.appendTo($("#stutab"));
							prof.appendTo($("#proftab"));
							
						});
						
						$("#Totalstudent").text(`${total[0]} Students`);
						$("#Totalprof").text(`${total[1]} Prof`);
						
				}else{
					new swal({
						  title: "Failed",
						  text: "",
						  icon: "error",
						});
				}
				
			}};
			
			$.ajax(header);
	   }
   }
   
   class course{
	   
	   getlist(){
	       var th=this;
		   var header ={ url:"course/getlist", type:"post", dataType:"json", async:false, success:function(res){
			       if(res.status=="success"){
					   var title = $(`<th>ID</th> <th>Matière</th> <th>Coefficient</th> <th>Descrisption</th>  <th>Action</th>`);
					   $("#list").html("");
					   title.appendTo($("#list"));
					   console.log(res.data);
					   res.data.map(function(item){
						   console.log(item.id);
						   var row = $(`<tr> <td>${item.id}</td> <td>${item.nommatiere}</td> <td>${item.coefficient}</td> <td>${item.description}</td> <td><button class="delete btn btn-danger delete" courseid="${item.id}">Delete</button> <button class="edit btn btn-success edit" courseid="${item.id}">edit</button></td> </tr>`);
						   row.appendTo($("#list"));
						   
					   });
					   bind(th);
					     
				   }else{ 
					   
					   new swal({
						  title: "Failed",
						  text: "unknown error.",
						  icon: "error",
						});
					   
					   
				   }
		   } };
		   
		   $.ajax(header);
		   
		   
	   }
       
       actiondelete(btn, callback=undefined){
		   
		   var courseid = $(btn).attr("courseid").trim();
		   var th = this;	   
		   var header ={ url:`course/delete/${courseid}`,type:"post",dataType:"json", success:function(res){
			       if(res.status=="success"){
					   th.getlist();
				   }else{ 
					   new swal({
						  title: "Failed",
						  text: "delete all professors teach this course before.",
						  icon: "error",
						});
				   }
				   if(callback!=undefined){
						   callback();
				   }
		   } };
		   
		   $.ajax(header);
		   
	   }
	   
	   actionedit(btn, callback=undefined){
		   var courseid = $(btn).attr("courseid");
								   
		   var header ={ url:`course/get/${courseid}`,type:"post",dataType:"json", success:function(res){
		       if(res.status=="success"){
				   var res = res.data[0];
				   $("#id").val(res.id);
				   $("#nom").val(res.nommatiere);
				   $("#coef").val(res.coefficient);
				   $("#description").text(res.description);

			   }else{ 
				   new swal({
						  title: "Failed",
						  text: "",
						  icon: "error",
				  });
			   }
		   } };
		   
		   $.ajax(header);
	   }
       
       
   }
   
   class students{
	    
	    constructor(){
		   this.classid = "";
	    }
	    
	    getlist(classid){
			   this.classid = classid;
		       var th = this;
			   var header = { url:`students/getlist/${classid}`, type:"post", dataType:"json", success:function(res){
			       if(res.status=="success"){
					   var title = $(`<th>ID</th> <th>Nom</th> <th>Genre</th> <th>Naissance</th> <th>Adresse</th> <th>Parents</th>  <th>Classe</th> <th>Description</th> <th>Action</th>`);
					   $("#list").html("");
					   title.appendTo($("#list"));
					   res.data.map(function(item){
						   var n = (item.naissance).split("#");
						   n = n.join(" ");
						   var p = (item.parents).split("#");
						   p = p.join(", ");
						   var row = $(`<tr> <td>${item.id}</td> <td>${item.nom}</td> <td>${item.gender}</td> <td>${n}</td> <td>${item.adresse}</td> <td>${p}</td> <td>${item.libelle}</td> <td>${item.description}</td> <td><button class="btn btn-danger delete" id="${item.id}">Delete</button> <button class="btn btn-success edit" id="${item.id}" classid="${classid}">edit</button></td> </tr>`);
						   row.appendTo($("#list"));
						     
					   });
					   
					   $("#classe").val(classid);
					   bind(th, classid);
					   
					     
				   }else{ 
					   new swal({
						  title: "Failed",
						  text: "",
						  icon: "error",
						});
				  }
		      }};
		   
		   $.ajax(header);
	   }
       
        actiondelete(btn, callback=undefined){
			   var id = $(btn).attr("id");
			   var th = this;				   
			   var header ={ url:`students/delete/${id}`,type:"post",dataType:"json", success:function(res){
				       if(res.status=="success"){
						   th.getlist(th.classid);
					   }else{ 
						   new swal({
								  title: "Failed",
								  text: "",
								  icon: "error",
						  });
						   
					  }
			   } };
			   
			   $.ajax(header);
		}
	   
	    actionedit(btn, callback=undefined){
			   
			   var classid = $(btn).attr("classid");
			   var id = $(btn).attr("id");
			   
			   var header ={ url:`students/get/${classid}/${id}`,type:"post",dataType:"json", success:function(res){
				       if(res.status=="success"){
						   var res = res.data[0];
						   var date = (res.naissance).split("#");
						   $("#date").val(date[0]);
						   $("#lieu").val(date[1]);
						   $("#id").val(res.id);
						   $("#gender").val(res.gender);
						   $("#nom").val(res.nom);
						   $("#addr").val(res.adresse);
						   $("#description").text(res.description);
						   var p = (res.parents).split("#");
						   $("#pnom").val(p[0]);
						   $("#mnom").val(p[1]);

					   }else{ 
						   new swal({
							  title: "Failed",
							  text: "",
							  icon: "error",
							});
					  }
			   } };
			   
			   $.ajax(header);
			   
		}
   }
   
   class professor{
	   constructor(){
		   this.classid = "";
	   }
	   getlist(classid){
		   $("#classe").val(classid);
		   this.classid = classid;
		   var th = this;
		   var header ={ url:`professor/getlist/${classid}`,type:"post",dataType:"json", async:false,success:function(res){
		       if(res.status=="success"){
				   var title = $(`<th>ID</th> <th>Nom</th> <th>Genre</th> <th>Naissance</th> <th>Adresse</th> <th>Competence</th> <th>Classe</th> <th>Action</th>`);
				   $("#list").html("");
				   title.appendTo($("#list"));
				   res.data.map(function(item){
					   var n = (item.naissance).split("#");
					   n = n.join(" ");
					   
					   var row = $(`<tr> <td>${item.id}</td> <td>${item.nom}</td> <td>${item.gender}</td> <td>${n}</td> <td>${item.adresse}</td> <td>${item.nomMatiere}</td> <td>${item.libelle}</td> <td><button class="btn btn-danger delete" id="${item.id}">Delete</button> <button class="btn btn-success edit" id="${item.id}" classid="${classid}">edit</button></td> </tr>`);
					   row.appendTo($("#list"));
					   
				   });
				   bind(th, classid);
				   
			   }else{ 
				   new swal({
					  title: "Failed",
					  text: "",
					  icon: "error",
					});
			   }
		   }};
		   $.ajax(header);
		   
	   }
	   
	   actionedit(btn, callback=undefined){
		       var id = $(btn).attr("id");
			   var classid = $(btn).attr("classid");
			   
			   var header ={ url:`professor/get/${classid}/${id}`,type:"post",dataType:"json", success:function(res){
				       
				       if(res.status=="success"){
						   var res = res.data[0];
						   var date = (res.naissance).split("#");
						   $("#date").val(date[0]);
						   $("#lieu").val(date[1]);
						   $("#id").val(res.id);
						   $("#nom").val(res.nom);
						   $("#gender").val(res.gender);
						   $("#matiere").val(res.idmatiere);
						   $("#classe").val(res.idclasse);
						   $("#addr").val(res.adresse);
						   $("#description").text(res.description);

					   }else{ 
						   
						  new swal({
							  title: "Failed",
							  text: "",
							  icon: "error",
							});
						   
						   
						   }
					   
					   if(callback!=undefined){
						   callback();
					   }
			   } };
			   
			   $.ajax(header);
	   }
	   
	   actiondelete(btn, callback=undefined){
		   
		   var id = $(btn).attr("id");
		   var th = this;		   
		   var header ={ url:`professor/delete/${id}`,type:"post",dataType:"json", success:function(res){
			       if(res.status=="success"){
					   th.getlist(th.classid);
				   }else{ 
					   
					   new swal({
						  title: "Failed",
						  text: "",
						  icon: "error",
						});
					   
					   }
		   } };
		   
		   $.ajax(header);
		   
		   
		   
		   
	   }
	   
   }
   
   class admin{
	   
	   getlist(){
		   var header ={ url:`admin/get`,type:"post",dataType:"json", async:false,success:function(res){
		       if(res.status=="success"){
				   $("#name").val(res.name);
				   $("#username").text(res.username);
			   }else{
				   new swal({
						  title: "Failed",
						  text: "",
						  icon: "error",
				   });
			   }
		     }
		   }
		   $.ajax(header);
	   }
   }
   
   class logout{
       getlist(){
		   document.location = "./logout";
	   }
   }
   
   var main = new app();
});
