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
				 pageobj.actionedit(this, function(){
					   if(classid!=undefined){
					     pageobj.getlist(classid);
					   }else{
						 pageobj.getlist();
					   }
			     })
		   });
   }
   
   class app{
	   
	   constructor(){
		   
		   this.page = $(".item .title")[0].innerText.trim();
		   console.log("page: ", this.page);
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
		   
		   this.active($(`.item:contains(${tmp})`)[0]);
		   
		   $(".item").click(function(e){
			   
			   th.active($(this)[0]);
		   });
		   		   
	   }
	   
	   active(item){
		   
		   $(".item").map(function(i){ 
			   ($(".item")[i]).className = "item";
		   });
		   item.className ="item active";
		   document.title=item.innerText.trim();
		   this.page = item.innerText.trim().toLowerCase();
		   var page = this.page;
		   
		   var th = this;
		   this.gethtml(function(){
			   
			   
			   var pageobj = eval(`new ${page};`);
			   
			   if(page=="professor" || page=="students" ){
						
						var header={ url:"classe/getlist", type:"post", dataType:"json", async:false,success:function(data){
					
						if(data.status=="success"){
								
									var total = [data.totalst, data.totalprf];
									var data = data.data;
									$("#classe").html("");
									$("#editclasse").html("");
									data.map(function(element){
										$(`<option value="${element.id}"></option>`).text(element.libelle).appendTo($("#classe"));
										$(`<option value="${element.id}"></option>`).text(element.libelle).appendTo($("#editclasse"));
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
								   $("#matiere").html("");
								   $("#editmatiere").html("");
								   res.data.map(function(item){
									   	
									   	$(`<option value="${item.id}"></option>`).text(item.nommatiere).appendTo($("#matiere"));	   
									   	$(`<option value="${item.id}"></option>`).text(item.nommatiere).appendTo($("#editmatiere"));
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
					   
					   th.update(this, th.page).then(function(){
					       
					       if(th.page.trim()=="professor" || th.page.trim()=="students"){
						      pageobj.getlist($("#classe").val());
						   }else{
						      pageobj.getlist();
						   }
						   
						   $("#id").attr("value", "");
					       $("#description").text("");
						   $("#form")[0].reset();

					   });
					   
		       });
		       
		       
		       $("#edit").submit(function(e){
				       
					   e.preventDefault();
					   
					   th.update(this, th.page).then(function(){
					       
					       if(th.page.trim()=="professor" || th.page.trim()=="students"){
						      pageobj.getlist($("#classe").val());
						   }else{
						      pageobj.getlist();
						   }
						   
						   
						   $("#myModal").modal('hide');
						   $("#edit")[0].reset();
						   
					   });
					   
		       });
		       
		       
		       
		       
		       
		       
			   
		   });
		   
	   }
	   
	   update(form, page){
		   return new Promise(function(resolve, reject){
			     
			     var data = $(form).serialize();
					   
				 var header = { url:`${page}/update`,type:"post",dataType:"json",data:data, success:function(res){
						       
					       if(res.status=="success"){
							   resolve();
						   }else{ 
							   var message = "";
							   if(res.message!=undefined){
								   message = res.message;
							   }
							   new swal({
								  title: "Failed",
								  text: message,
								  icon: "error",
							   }).then(function(){
								    reject(); 
							   });
						   }
						   
						   
					   }
				 }
				 
				 $.ajax(header);
			   
			   
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
				   res.data = res.data.reverse();
				   res.data.map(function(item){
					   var row = $(`<tr></tr>`);
					   $("<td></td>").text(item.id).appendTo(row);
					   $("<td></td>").text(item.libelle).appendTo(row);
					   $("<td></td>").text(item.capacite).appendTo(row);
					   $(`<td><button class="btn btn-danger delete" classid="${item.id}">Delete</button> <button class="btn btn-success edit" data-toggle="modal" data-target="#myModal" classid="${item.id}">edit</button></td>`).appendTo(row);
					   
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
						   $("#editlibelle").val(res.libelle);
						   $("#editcapacity").val(res.capacite);
						   
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
						var data = data.data.reverse();
						
						data.map(function(element){
							student = $(`<tr></tr>`);
							$("<td></td>").text(element.name).appendTo(student);
							$(`<td>${element.students}/${element.capacite}</td>`).appendTo(student);
							
							prof = $(`<tr></tr>`);
							$("<td></td>").text(element.name).appendTo(prof);
							$(`<td>${element.profs}</td>`).appendTo(prof);
							
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
		   var header = { url:"course/getlist", type:"post", dataType:"json", async:false, success:function(res){
			       if(res.status=="success"){
					   var title = $(`<th>ID</th> <th>Matière</th> <th>Coefficient</th> <th>Descrisption</th>  <th>Action</th>`);
					   $("#list").html("");
					   title.appendTo($("#list"));
					   res.data = res.data.reverse();
					   res.data.map(function(item){
						   console.log(item.id);
						   var row = $(`<tr> <td>${item.id}</td></tr>`);
						   
						   $(`<td></td>`).text(item.nommatiere).appendTo(row);
						   $(`<td></td>`).text(item.coefficient).appendTo(row);
						   $(`<td></td>`).text(item.description).appendTo(row);
						   $(`<td><button class="delete btn btn-danger delete" courseid="${item.id}">Delete</button> <button class="edit btn btn-success edit" data-toggle="modal" data-target="#myModal" courseid="${item.id}">edit</button></td>`).appendTo(row);
 
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
				   $("#editnom").val(res.nommatiere);
				   $("#editcoef").val(res.coefficient);
				   $("#editdescription").text(res.description);

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
						   
						   var n = (item.naissance).split("_");
						   n = n.join(" ");
						   var p = (item.parents).split("_");
						   p = p.join(", ");
						   var row = $(`<tr class="${item.id}"></tr>`);
						   row.appendTo($("#list"));
						   $(`<td></td>`).text(item.id).appendTo(row);
						   $(`<td ></td>`).text(item.nom).appendTo(row);
							 $(`<td ></td>`).text(item.gender).appendTo(row);
							 $(`<td ></td>`).text(n).appendTo(row);
							 $(`<td ></td>`).text(item.adresse).appendTo(row);
							 $(`<td ></td>`).text(p).appendTo(row);
							 $(`<td ></td>`).text(item.libelle).appendTo(row);
							 $(`<td ></td>`).text(item.description).appendTo(row);
							 $(`<td><button class="btn btn-danger delete" id="${item.id}">Delete</button> <button class="btn btn-success edit" data-toggle="modal" data-target="#myModal" id="${item.id}" classid="${classid}">edit</button></td>`).appendTo(row);
							 
						     
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
						   var date = (res.naissance).split("_");
						   $("#editdate").val(date[0]);
						   $("#editlieu").val(date[1]);
						   $("#id").val(res.id);
						   $("#editgender").val(res.gender);
						   $("#editnom").val(res.nom);
						   $("#editaddr").val(res.adresse);
						   $("#editdescription").text(res.description);
						   var p = (res.parents).split("_");
						   $("#editpnom").val(p[0]);
						   $("#editmnom").val(p[1]);

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
					   var n = item.naissance.replaceAll("_", " ");
					   
					   var row = $(`<tr></tr>`);
					   $(`<td ></td>`).text(item.id).appendTo(row);;
					   $(`<td ></td>`).text(item.nom).appendTo(row); 
					   $(`<td ></td>`).text(item.gender).appendTo(row);
					   $(`<td ></td>`).text(n).appendTo(row);
					   $(`<td ></td>`).text(item.adresse).appendTo(row);
					   $(`<td ></td>`).text(item.nomMatiere).appendTo(row);
					   $(`<td ></td>`).text(item.libelle).appendTo(row);
					   $(`<td><button class="btn btn-danger delete" id="${item.id}">Delete</button> <button class="btn btn-success edit" data-toggle="modal" data-target="#myModal" id="${item.id}" classid="${classid}">edit</button></td>`).appendTo(row); 
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
						   var date = (res.naissance).split("_");
						   $("#editdate").val(date[0]);
						   $("#editlieu").val(date[1]);
						   $("#id").val(res.id);
						   $("#editnom").val(res.nom);
						   $("#editgender").val(res.gender);
						   $("#editmatiere").val(res.idmatiere);
						   $("#editclasse").val(res.idclasse);
						   $("#editaddr").val(res.adresse);
						   $("#editdescription").text(res.description);

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
