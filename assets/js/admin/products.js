$(function(){
    // base url
    var base_url = $('.base_url').data('value');

    var productstable = $('#productsTable').DataTable({
    	"processing": true, 
        "serverSide": true, 
        "order": [[0, 'asc']], 
 
        "ajax": {
            "url": base_url+"admin/products/dtproducts",
            "type": "POST",
        },

        //Set column definition initialisation properties.
        "columnDefs": [
	        { 
	            "targets": [1, 5], 
	            "orderable": false,
	        },
        ],
        "columns": [
            { data: "product_name" },
            { data: "location",
                render: function (data, type, row) {
                    var img_src = '';
                    if (data) {
                        img_src = base_url + 'assets/uploads/products/' + data;
                    } else {
                        img_src = base_url + 'assets/img/no-product.png';
                    }
                    return '<img src="'+img_src+'" width="30px" height="30px">';
                }
            },
            { data: "category_name" },
            { data: "price" },
            { data: "quantity" },
            { data: "product_id",
	         	render: function (data, type, row) {
                    return '<a href="'+base_url+'admin/products/view/'+row.slug+'" class="btn btn-info btn-sm btn-flat" target="_blank"><i class="fa fa-search"></i> View</a> <button class="btn btn-success btn-sm btn-flat editproduct" value="'+data+'" data-toggle="modal" data-target="#editProduct"><i class="fa fa-edit"></i> Edit</button> <button class="btn btn-danger btn-sm btn-flat deleteproduct" value="'+data+'" data-toggle="modal" data-target="#deleteProduct"><i class="fa fa-trash"></i> Delete</button>';
                }
	        },
       ],
    });

    var categories;
    $.ajax({
        type: "GET",
        url: base_url+'admin/products/categories',
        dataType: 'json',
        beforeSend: function(){},
        success: function(res){
            if(res.error){
                Swal.fire('Error!', res.message, 'error');
            } else {
                categories = res.data;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire('Error!', 'An error occurred while processing', 'error');
        },
    });

    $('#addProductForm').validate({
        rules: {
            product_name: {
                required: true
            },
            category_id: {
                required: true
            },
            price: {
                required: true
            },
            quantity: {
                required: true
            },
            description: {
                required: true
            },
        },
        messages: {
            product_name: {
                required: "Please input product name"
            },
            category_id: {
                required: "Please select category"
            },
            price: {
                required: "Please input price"
            },
            quantity: {
                required: "Please input quantity"
            },
            description: {
                required: "Please input description"
            },
        }
    });

    $('#addProductForm').submit(function(e){
        e.preventDefault();
        if($(this).valid()){
            var product_name = $('#product_name').val();
            var category_id = $('#category_id').val();
            var price = $('#price').val();
            var quantity = $('#quantity').val();
            var description = $('#description').val();
           
            var formdata = new FormData();

            if (document.getElementById('photo').files.length > 0) {
                formdata.append('photo', document.getElementById('photo').files[0]);
            }

            formdata.append('product_name', product_name);
            formdata.append('category_id', category_id);
            formdata.append('price', price);
            formdata.append('quantity', quantity);
            formdata.append('description', description);

            $.ajax({
                type: "POST",
                url: base_url+'admin/products/insert',
                data: formdata,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#addProductsBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
                },
                success: function(res){
                    $('#addProductsBtn').html('<i class="fa fa-save"></i> Save');
                    if(res.error){
                        Swal.fire('Error!', res.message, 'error');
                    } else {
                        Swal.fire('Success!', res.message, 'success');
                        $('#addProducts').modal('hide');
                        $('#addProductForm')[0].reset();
                        productstable.ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#addProductsBtn').html('<i class="fa fa-save"></i> Save');
                    Swal.fire('Error!', 'An error occurred while processing', 'error');
                },
            });
        }
    });

    $('#productBtn').click(function(){
        var html = '<option value="" disabled selected>Select</option>';
        $.each(categories, function(i, category){
            html += '<option value="'+category.id+'">'+category.category_name+'</option>';
        });
        $('#category_id').html(html);
    });

    $(document).on('click', '.editproduct', function(){
        var productid = $(this).val();
        $('#productid').val(productid);

        $.ajax({
            type: "POST",
            url: base_url+'admin/products/getProduct',
            data: {productid: productid},
            dataType: 'json',
            beforeSend: function(){
            },
            success: function(res){
                if(res.error){
                    Swal.fire('Error!', res.message, 'error');
                } else {
                    var product = res.data;
                    $('#edit_product_name').val(product.product_name);
                    $('#edit_price').val(product.price);
                    $('#edit_description').val(product.description);
                    var html = '';
                    $.each(categories, function(i, category){
                        var selected = '';
                        if (category.id == product.category_id) {
                            selected = 'selected';
                        }
                        html += '<option value="'+category.id+'" '+selected+'>'+category.category_name+'</option>';
                    });
                    $('#edit_category_id').html(html);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire('Error!', 'An error occurred while processing', 'error');
            },
        });
    });

    $('#editProductForm').validate({
        rules: {
            edit_product_name: {
                required: true
            },
            edit_category_id: {
                required: true
            },
            edit_price: {
                required: true
            },
            edit_description: {
                required: true
            },
        },
        messages: {
            edit_product_name: {
                required: "Please input product name"
            },
            edit_category_id: {
                required: "Please select category"
            },
            edit_price: {
                required: "Please input price"
            },  
            edit_description: {
                required: "Please input description"
            },  
        }
    });

    $('#editProductForm').submit(function(e){
        e.preventDefault();
        if($(this).valid()){
            var product_name = $('#edit_product_name').val();
            var category_id = $('#edit_category_id').val();
            var price = $('#edit_price').val();
            var description = $('#edit_description').val();
            var productid = $('#productid').val();
           
            var formdata = new FormData();

            if (document.getElementById('edit_photo').files.length > 0) {
                formdata.append('photo', document.getElementById('edit_photo').files[0]);
            }

            formdata.append('product_name', product_name);
            formdata.append('category_id', category_id);
            formdata.append('price', price);
            formdata.append('description', description);
            formdata.append('productid', productid);

            $.ajax({
                type: "POST",
                url: base_url+'admin/products/update',
                data: formdata,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#editProductBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
                },
                success: function(res){
                    $('#editProductBtn').html('<i class="fa fa-check"></i> Update');
                    if(res.error){
                        Swal.fire('Error!', res.message, 'error');
                    } else {
                        Swal.fire('Success!', res.message, 'success');
                        $('#editProduct').modal('hide');
                        $('#editProductForm')[0].reset();
                        productstable.ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#editProductBtn').html('<i class="fa fa-check"></i> Update');
                    Swal.fire('Error!', 'An error occured while processing', 'error');
                },
            });
        }
    });

    $(document).on('click', '.deleteproduct', function(){
        var productid = $(this).val();
        $('#deleteProductBtn').val(productid);
    });

    $('#deleteProductBtn').click(function(){
        var productid = $(this).val();

        $.ajax({
            type: "POST",
            url: base_url+'admin/products/delete',
            data: {productid: productid},
            dataType: 'json',
            beforeSend: function(){
                $('#deleteProductBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
            },
            success: function(res){
                $('#deleteProductBtn').html('<i class="fa fa-trash"></i> Delete');
                if(res.error){
                    Swal.fire('Error!', res.message, 'error');
                } else {
                    Swal.fire('Success!', res.message, 'success');
                    $('#deleteProduct').modal('hide');
                    productstable.ajax.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#deleteProductBtn').html('<i class="fa fa-trash"></i> Delete');
                Swal.fire('Error!', 'An error occured while processing', 'error');
            },
        });
    });

});