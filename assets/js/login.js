$(function(){
    var base_url = $('.base_url').data('value');
    $('#loginForm').validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            },  
        },
        messages: {
            email: {
                required: "Please input email",
                email: "Invalid email format"
            },
            password: {
                required: "Please input password"
            }, 
        }
    });

    $('#loginForm').submit(function(e){
        e.preventDefault();
        if($(this).valid()){
            var login = $(this).serialize();
            $.ajax({
                type: "POST",
                url: base_url+'login/submit',
                data: login,
                dataType: 'json',
                beforeSend: function(){
                    $('#signin').html('<i class="fa fa-spinner fa-spin"></i> Processing');
                },
                success: function(res){
                    $('#signin').html('<i class="fa fa-sign-in-alt"></i> Signin');
                    if(res.error){
                        Swal.fire('Error!', res.message, 'error');
                    } else {
                        Swal.fire({
                            title: res.message, 
                            text: 'Redirecting to your account...', 
                            icon: 'success',
                            showCloseButton: false,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        setTimeout(function(){ location.href = base_url + 'admin/dashboard'; }, 3000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#signin').html('<i class="fa fa-sign-in-alt"></i> Signin');
                    Swal.fire('Error!', 'An error occurred while processing', 'error');
                },
            });
        }
    });
});