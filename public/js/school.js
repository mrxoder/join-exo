$(document).ready(function(){
	
	header={ url:"index.php", type:"post", data:{"page":"school","action":"getinfo"}, dataType:"json",success:function(data){
		
		if(data.status=="success"){
			total = [data.totalst, data.totalprf];
			data = data.data;
			
			data.map(function(element){
				student = $(`<tr> <td>${element.name}</td> <td>${element.students}/${element.capacite}</td> </tr>`);
				prof = $(`<tr> <td>${element.name}</td> <td>${element.profs}</td> </tr>`);
				student.appendTo($("#stutab"));
				prof.appendTo($("#proftab"));
				
			});
			
			$("#Totalstudent").text(`${total[0]} Students`);
			$("#Totalprof").text(`${total[1]} Prof`);
			
			
			
		}
		
		
	}};
	
	$.ajax(header);
});


