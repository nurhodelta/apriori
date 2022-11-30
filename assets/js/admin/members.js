$(function(){
    // base url
    var base_url = $('.base_url').data('value');

    var memberstable = $('#membersTable').DataTable({
    	"processing": true, 
        "serverSide": true, 
        "order": [[0, 'asc']], 
 
        "ajax": {
            "url": base_url+"admin/members/dtmembers",
            "type": "POST",
        },

        //Set column definition initialisation properties.
        "columnDefs": [
	        { 
	            "targets": [3, 4], 
	            "orderable": false,
	        },
        ],
        "columns": [
            { data: "first_name" },
            { data: "last_name" },
            { data: "email" },
            { data: "contact_info" },
            { data: "id",
	         	render: function (data, type, row) {
                    return '<button class="btn btn-info btn-sm btn-flat viewmember" value="'+data+'" data-toggle="modal" data-target="#viewMembers"><i class="fa fa-search"></i> View</button> <button class="btn btn-success btn-sm btn-flat editmember" value="'+data+'" data-toggle="modal" data-target="#editMembers"><i class="fa fa-edit"></i> Edit</button> <button class="btn btn-danger btn-sm btn-flat deletemember" value="'+data+'" data-toggle="modal" data-target="#deleteMembers"><i class="fa fa-trash"></i> Delete</button>';
                }
	        },
       ],
    });

    $('#addMemberForm').validate({
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
            birthdate: {
                required: true
            },  
            contact_info: {
                required: true
            }, 
            address: {
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
            email: {
                required: "Please input email",
                email: "Invalid email format"
            },
            birthdate: {
                required: "Please input birthdate"
            },  
            contact_info: {
                required: "Please input contact info"
            }, 
            address: {
                required: "Please input address"
            },  
        }
    });

    $('#addMemberForm').submit(function(e){
        e.preventDefault();
        if($(this).valid()){
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: base_url+'admin/members/insert',
                data: data,
                dataType: 'json',
                beforeSend: function(){
                    $('#addMemberBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
                },
                success: function(res){
                    $('#addMemberBtn').html('<i class="fa fa-save"></i> Save');
                    if(res.error){
                        Swal.fire('Error!', res.message, 'error');
                    } else {
                        Swal.fire('Success!', res.message, 'success');
                        $('#addMembers').modal('hide');
                        $('#addMemberForm')[0].reset();
                        memberstable.ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#addMemberBtn').html('<i class="fa fa-save"></i> Save');
                    Swal.fire('Error!', 'An error occurred while processing', 'error');
                },
            });
        }
    });

    $(document).on('click', '.editmember', function(){
        var memberid = $(this).val();
        $('#memberid').val(memberid);

        $.ajax({
            type: "POST",
            url: base_url+'admin/members/getMember',
            data: {memberid: memberid},
            dataType: 'json',
            beforeSend: function(){
            },
            success: function(res){
                if(res.error){
                    Swal.fire('Error!', res.message, 'error');
                } else {
                    var member = res.data;
                    $('#edit_firstname').val(member.first_name);
                    $('#edit_lastname').val(member.last_name);
                    $('#edit_email').val(member.email);
                    $('#edit_birthdate').val(member.birthdate);
                    $('#edit_contact_info').val(member.contact_info);
                    $('#edit_address').val(member.address);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire('Error!', 'An error occured while processing', 'error');
            },
        });
    });

    $('#editMemberForm').validate({
        rules: {
            edit_firstname: {
                required: true
            },
            edit_lastname: {
                required: true
            },
            edit_birthdate: {
                required: true
            },  
            edit_contact_info: {
                required: true
            }, 
            edit_address: {
                required: true
            }, 
        },
        messages: {
            edit_firstname: {
                required: "Please input first name"
            },
            edit_lastname: {
                required: "Please input last name"
            },
            edit_birthdate: {
                required: "Please input birthdate"
            },  
            edit_contact_info: {
                required: "Please input contact info"
            }, 
            edit_address: {
                required: "Please input address"
            },  
        }
    });

    $('#editMemberForm').submit(function(e){
        e.preventDefault();
        if($(this).valid()){
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: base_url+'admin/members/update',
                data: data,
                dataType: 'json',
                beforeSend: function(){
                    $('#editMemberBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
                },
                success: function(res){
                    $('#editMemberBtn').html('<i class="fa fa-check"></i> Update');
                    if(res.error){
                        Swal.fire('Error!', res.message, 'error');
                    } else {
                        Swal.fire('Success!', res.message, 'success');
                        $('#editMembers').modal('hide');
                        $('#editMemberForm')[0].reset();
                        memberstable.ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#editMemberBtn').html('<i class="fa fa-check"></i> Update');
                    Swal.fire('Error!', 'An error occured while processing', 'error');
                },
            });
        }
    });

    $(document).on('click', '.deletemember', function(){
        var memberid = $(this).val();
        $('#deleteMemberBtn').val(memberid);
    });

    $('#deleteMemberBtn').click(function(){
        var memberid = $(this).val();

        $.ajax({
            type: "POST",
            url: base_url+'admin/members/delete',
            data: {memberid: memberid},
            dataType: 'json',
            beforeSend: function(){
                $('#deleteMemberBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
            },
            success: function(res){
                $('#deleteMemberBtn').html('<i class="fa fa-trash"></i> Delete');
                if(res.error){
                    Swal.fire('Error!', res.message, 'error');
                } else {
                    Swal.fire('Success!', res.message, 'success');
                    $('#deleteMembers').modal('hide');
                    memberstable.ajax.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#deleteMemberBtn').html('<i class="fa fa-trash"></i> Delete');
                Swal.fire('Error!', 'An error occured while processing', 'error');
            },
        });
    });

    $(document).on('click', '.viewmember', function(){
        var memberid = $(this).val();
        $('#memberid').val(memberid);

        $.ajax({
            type: "POST",
            url: base_url+'admin/members/getMember',
            data: {memberid: memberid},
            dataType: 'json',
            beforeSend: function(){
            },
            success: function(res){
                if(res.error){
                    Swal.fire('Error!', res.message, 'error');
                } else {
                    var member = res.data;
                    $('#view_firstname').val(member.first_name);
                    $('#view_lastname').val(member.last_name);
                    $('#view_email').val(member.email);
                    $('#view_birthdate').val(member.birthdate);
                    $('#view_contact_info').val(member.contact_info);
                    $('#view_address').val(member.address);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire('Error!', 'An error occured while processing', 'error');
            },
        });
    });

});