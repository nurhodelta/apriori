$(function(){
    // base url
    var base_url = $('.base_url').data('value');

    var categorytable = $('#categoryTable').DataTable({
    	"processing": true, 
        "serverSide": true, 
        "order": [[0, 'asc']], 
 
        "ajax": {
            "url": base_url+"admin/categories/dtcategories",
            "type": "POST",
        },

        //Set column definition initialisation properties.
        "columnDefs": [
	        { 
	            "targets": [1], 
	            "orderable": false,
	        },
        ],
        "columns": [
            { data: "category_name" },
            { data: "id",
	         	render: function (data, type, row) {
                    return '<button class="btn btn-success btn-sm btn-flat editcategory" value="'+data+'" data-toggle="modal" data-target="#editCategory"><i class="fa fa-edit"></i> Edit</button> <button class="btn btn-danger btn-sm btn-flat deletecategory" value="'+data+'" data-toggle="modal" data-target="#deleteCategory"><i class="fa fa-trash"></i> Delete</button>';
                }
	        },
       ],
    });

    $('#addCategoryForm').validate({
        rules: {
            category_name: {
                required: true
            },
        },
        messages: {
            category_name: {
                required: "Please input category name"
            }, 
        }
    });

    $('#addCategoryForm').submit(function(e){
        e.preventDefault();
        if($(this).valid()){
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: base_url+'admin/categories/insert',
                data: data,
                dataType: 'json',
                beforeSend: function(){
                    $('#addCategoryBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
                },
                success: function(res){
                    $('#addCategoryBtn').html('<i class="fa fa-save"></i> Save');
                    if(res.error){
                        Swal.fire('Error!', res.message, 'error');
                    } else {
                        Swal.fire('Success!', res.message, 'success');
                        $('#addCategory').modal('hide');
                        $('#addCategoryForm')[0].reset();
                        categorytable.ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#addCategoryBtn').html('<i class="fa fa-save"></i> Save');
                    Swal.fire('Error!', 'An error occurred while processing', 'error');
                },
            });
        }
    });

    $(document).on('click', '.editcategory', function(){
        var categoryid = $(this).val();
        $('#categoryid').val(categoryid);

        $.ajax({
            type: "POST",
            url: base_url+'admin/categories/getCategory',
            data: {categoryid: categoryid},
            dataType: 'json',
            beforeSend: function(){
            },
            success: function(res){
                if(res.error){
                    Swal.fire('Error!', res.message, 'error');
                } else {
                    var category = res.data;
                    $('#edit_category_name').val(category.category_name);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire('Error!', 'An error occurred while processing', 'error');
            },
        });
    });

    $('#editCategoryForm').validate({
        rules: {
            edit_category_name: {
                required: true
            },
        },
        messages: {
            edit_category_name: {
                required: "Please input category name"
            },
        }
    });

    $('#editCategoryForm').submit(function(e){
        e.preventDefault();
        if($(this).valid()){
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: base_url+'admin/categories/update',
                data: data,
                dataType: 'json',
                beforeSend: function(){
                    $('#editCategoryBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
                },
                success: function(res){
                    $('#editCategoryBtn').html('<i class="fa fa-check"></i> Update');
                    if(res.error){
                        Swal.fire('Error!', res.message, 'error');
                    } else {
                        Swal.fire('Success!', res.message, 'success');
                        $('#editCategory').modal('hide');
                        $('#editCategoryForm')[0].reset();
                        categorytable.ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#editCategoryBtn').html('<i class="fa fa-check"></i> Update');
                    Swal.fire('Error!', 'An error occured while processing', 'error');
                },
            });
        }
    });

    $(document).on('click', '.deletecategory', function(){
        var categoryid = $(this).val();
        $('#deleteCategoryBtn').val(categoryid);
    });

    $('#deleteCategoryBtn').click(function(){
        var categoryid = $(this).val();

        $.ajax({
            type: "POST",
            url: base_url+'admin/categories/delete',
            data: {categoryid: categoryid},
            dataType: 'json',
            beforeSend: function(){
                $('#deleteCategoryBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
            },
            success: function(res){
                $('#deleteCategoryBtn').html('<i class="fa fa-trash"></i> Delete');
                if(res.error){
                    Swal.fire('Error!', res.message, 'error');
                } else {
                    Swal.fire('Success!', res.message, 'success');
                    $('#deleteCategory').modal('hide');
                    categorytable.ajax.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#deleteCategoryBtn').html('<i class="fa fa-trash"></i> Delete');
                Swal.fire('Error!', 'An error occured while processing', 'error');
            },
        });
    });

});