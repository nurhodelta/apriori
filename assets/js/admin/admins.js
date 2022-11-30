$(function(){
    // base url
    var base_url = $('.base_url').data('value');

    var adminstable = $('#adminsTable').DataTable({
    	"processing": true, 
        "serverSide": true, 
        "order": [[0, 'asc']], 
 
        "ajax": {
            "url": base_url+"admin/admins/dtadmins",
            "type": "POST",
        },

        //Set column definition initialisation properties.
        "columnDefs": [
	        { 
	            "targets": [3], 
	            "orderable": false,
	        },
        ],
        "columns": [
            { data: "first_name" },
            { data: "last_name" },
            { data: "email" },
            { data: "id",
	         	render: function (data, type, row) {
                    return '<button class="btn btn-success btn-sm btn-flat editadmin" value="'+data+'" data-toggle="modal" data-target="#editAdmins"><i class="fa fa-edit"></i> Edit</button> <button class="btn btn-danger btn-sm btn-flat deleteadmin" value="'+data+'" data-toggle="modal" data-target="#deleteAdmins"><i class="fa fa-trash"></i> Delete</button>';
                }
	        },
       ],
    });

    $('#addAdminForm').validate({
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },  
        },
        messages: {
            first_name: {
                required: "Please input firstname"
            },
            last_name: {
                required: "Please input lastname"
            },
            email: {
                required: "Please input email",
                email: "Please input a valid email"
            },
        }
    });

    $('#addAdminForm').submit(function(e){
        e.preventDefault();
        if($(this).valid()){
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: base_url+'admin/admins/insert',
                data: data,
                dataType: 'json',
                beforeSend: function(){
                    $('#addAdminBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
                },
                success: function(res){
                    $('#addAdminBtn').html('<i class="fa fa-save"></i> Save');
                    if(res.error){
                        Swal.fire('Error!', res.message, 'error');
                    } else {
                        Swal.fire('Success!', res.message, 'success');
                        $('#addAdmins').modal('hide');
                        $('#addAdminForm')[0].reset();
                        adminstable.ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#addAdminBtn').html('<i class="fa fa-save"></i> Save');
                    Swal.fire('Error!', 'An error occured while processing', 'error');
                },
            });
        }
    });

    $(document).on('click', '.editadmin', function(){
        var adminid = $(this).val();
        $('#adminid').val(adminid);

        $.ajax({
            type: "POST",
            url: base_url+'admin/admins/getAdmin',
            data: {adminid: adminid},
            dataType: 'json',
            beforeSend: function(){
            },
            success: function(res){
                if(res.error){
                    Swal.fire('Error!', res.message, 'error');
                } else {
                    var admin = res.data;
                    $('#edit_firstname').val(admin.first_name);
                    $('#edit_lastname').val(admin.last_name);
                    $('#edit_email').val(admin.email);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire('Error!', 'An error occured while processing', 'error');
            },
        });
    });

    $('#editAdminForm').validate({
        rules: {
            edit_firstname: {
                required: true
            },
            edit_lastname: {
                required: true
            }, 
        },
        messages: {
            edit_firstname: {
                required: "Please input firstname"
            },
            edit_lastname: {
                required: "Please input lastname"
            },
        }
    });

    $('#editAdminForm').submit(function(e){
        e.preventDefault();
        if($(this).valid()){
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: base_url+'admin/admins/update',
                data: data,
                dataType: 'json',
                beforeSend: function(){
                    $('#editAdminBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
                },
                success: function(res){
                    $('#editAdminBtn').html('<i class="fa fa-check"></i> Update');
                    if(res.error){
                        Swal.fire('Error!', res.message, 'error');
                    } else {
                        Swal.fire('Success!', res.message, 'success');
                        $('#editAdmins').modal('hide');
                        $('#editAdminForm')[0].reset();
                        adminstable.ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#editAdminBtn').html('<i class="fa fa-check"></i> Update');
                    Swal.fire('Error!', 'An error occured while processing', 'error');
                },
            });
        }
    });

    $(document).on('click', '.deleteadmin', function(){
        var adminid = $(this).val();
        $('#deleteAdminBtn').val(adminid);
    });

    $('#deleteAdminBtn').click(function(){
        var adminid = $(this).val();

        $.ajax({
            type: "POST",
            url: base_url+'admin/admins/delete',
            data: {adminid: adminid},
            dataType: 'json',
            beforeSend: function(){
                $('#deleteAdminBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
            },
            success: function(res){
                $('#deleteAdminBtn').html('<i class="fa fa-trash"></i> Delete');
                if(res.error){
                    Swal.fire('Error!', res.message, 'error');
                } else {
                    Swal.fire('Success!', res.message, 'success');
                    $('#deleteAdmins').modal('hide');
                    adminstable.ajax.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#deleteAdminBtn').html('<i class="fa fa-trash"></i> Delete');
                Swal.fire('Error!', 'An error occurred while processing', 'error');
            },
        });
    });


});