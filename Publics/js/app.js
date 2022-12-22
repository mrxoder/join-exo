$(document).ready(function() {
    const URL = "http://localhost/school/" ;
    
    $("#myFormConnect").submit(function(e) {
        e.preventDefault();
        var datas = $(this).serialize() ;
        $.ajax({
            url: URL+"UserControls/connect",
            type: "post",
            data: datas , 
        })
        .done(function(data) {
            if(data.trim() == "users") {
                Swal.fire({
                    icon: 'success',
                    title: 'Bravo, Connected !',
                    text: 'Congratulations',
                }).then(function(){
					document.location="./";
				});
                
                
            }
            else if(data.trim() == "not-users") {
                Swal.fire({
                    icon: 'error',
                    title: 'Bravo, Not Connected !',
                    text: 'ERROR',
                })
            }
            
        })
        .fail(function(errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                footer: '<a href="">Why do I have this issue?</a>'
            })
        })
    })

    $("#myFormRegister").submit(function(e) {
        e.preventDefault() ;
        var form = this;
        $.ajax({
            url: "UserControls/register" ,
            type: "post",
            data: $(form).serialize() ,
        })
        .done(function(data) {
            Swal.fire({
                icon: 'success',
                title: 'Bravo, Registered !',
                text: 'Congratulations',
            }).then(function(){
				$("#myModal").modal('hide');
				$(form)[0].reset();
			})
            
        })
        .fail(function(errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                footer: '<a href="">Why do I have this issue?</a>'
            })
        })
    })
})  
