$(function(){
    // base url
    var base_url = $('.base_url').data('value');

    $('#profileForm').validate({
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            }, 
        },
        messages: {
            first_name: {
                required: "Please input first name"
            },
            last_name: {
                required: "Please input last name"
            },
        }
    });

    $('#profileForm').submit(function(e){
        e.preventDefault();
        if($(this).valid()){
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
           
            var formdata = new FormData();

            if (document.getElementById('photo').files.length > 0) {
                formdata.append('photo', document.getElementById('photo').files[0]);
            }

            formdata.append('first_name', first_name);
            formdata.append('last_name', last_name);

            $.ajax({
                type: "POST",
                url: base_url+'admin/account/profile',
                data: formdata,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#profileBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
                },
                success: function(res){
                    $('#profileBtn').html('<i class="fa fa-check"></i> Submit');
                    if(res.error){
                        Swal.fire('Error!', res.message, 'error');
                    } else {
                        Swal.fire('Success!', res.message, 'success');
                        setTimeout(function(){ location.reload(); }, 3000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#profileBtn').html('<i class="fa fa-check"></i> Submit');
                    Swal.fire('Error!', 'An error occurred while processing', 'error');
                },
            });
        }
    });

    $('#passwordForm').validate({
        rules: {
            old_password: {
                required: true
            },
            new_password: {
                required: true,
                minlength: 8,
            }, 
            retype_password: {
                required: true,
                equalTo: "#new_password"
            },
        },
        messages: {
            old_password: {
                required: "Please input current password"
            },
            new_password: {
                required: "Please input new password",
                minlength: "New password minimum of 8 characters",
            },
            retype_password: {
                required: "Please re-type new password",
                equalTo: "Passwords did not match"
            },
        }
    });

    $('#passwordForm').submit(function(e){
        e.preventDefault();
        if($(this).valid()){
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: base_url+'admin/account/password',
                data: data,
                dataType: 'json',
                beforeSend: function(){
                    $('#passwordBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
                },
                success: function(res){
                    $('#passwordBtn').html('<i class="fa fa-check"></i> Submit');
                    if(res.error){
                        Swal.fire('Error!', res.message, 'error');
                    } else {
                        Swal.fire('Success!', res.message, 'success');
                        setTimeout(function(){ location.href=base_url+'admin/logout'; }, 3000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#passwordBtn').html('<i class="fa fa-check"></i> Submit');
                    Swal.fire('Error!', 'An error occurred while processing', 'error');
                },
            });
        }
    });

});