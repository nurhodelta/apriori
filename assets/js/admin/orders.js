$(function(){
    // base url
    var base_url = $('.base_url').data('value');

    var orderstable = $('#ordersTable').DataTable({
    	"processing": true, 
        "serverSide": true, 
        "order": [[0, 'desc']], 
 
        "ajax": {
            "url": base_url+"admin/orders/dtorders",
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
            { data: "order_date", 
                render: function (data, type, row) {
                    return  formatDate(data);
                }
            },
            { data: "member_id", 
                render: function (data, type, row) {
                    return row.first_name+' '+row.last_name;
                }
            },
            { data: "total" },
            { data: "order_id",
	         	render: function (data, type, row) {
                    return '<button class="btn btn-info btn-sm btn-flat vieworder" value="'+data+'" data-toggle="modal" data-target="#viewOrder"><i class="fa fa-search"></i> View Products</button>';
                }
	        },
       ],
    });

    $("#member_id").select2({
        minimumInputLength: 2,
        ajax: {
            url: base_url+'admin/orders/members',
            dataType: 'json',
            type: "GET",
            // quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.text,
                            id: item.id,
                        }
                    })
                };
            }
        }
    });

    $(document).on('click', '.order-product-minus', function(){
        $(this).closest('div.form-group').css('display', 'none');
    });

    $('#order-product-add').click(function(){
        var html = '<div class="form-group">';
        html += '<label for="" class="col-sm-3 control-label"></label>';
        html += '<div class="col-sm-9 order-product-div">';
        html += '<div class="order-product-select" style="margin-right:2px"><select class="form-control product-class-select2" id="" name="product_id[]"></select></div>'; 
        html += '<div class="order-product-quantity" style="margin-right:3px"><input type="number" class="form-control" min="1" name="quantity[]"></div>';       	
        html += '<div><button type="button" class="btn btn-sm btn-danger order-product-minus"><i class="fa fa-minus"></i></button></div>';
        html += '</div></div>';         	
        $('#order-product-new-div').append(html);
        $('.product-class-select2').select2({
            minimumInputLength: 2,
            ajax: {
                url: base_url+'admin/orders/products',
                dataType: 'json',
                type: "GET",
                // quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id,
                            }
                        })
                    };
                }
            }
        });
    });

    $('.product-class-select2').select2({
        minimumInputLength: 2,
        ajax: {
            url: base_url+'admin/orders/products',
            dataType: 'json',
            type: "GET",
            // quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.text,
                            id: item.id,
                        }
                    })
                };
            }
        }
    });

    $('#addOrdersForm').validate({
        ignore: [],
        rules: {
            member_id: {
                required: true
            },
            'product_id[]': {
                required: true
            }
        },
        messages: {
            member_id: {
                required: "Please select member"
            },
            'product_id[]': {
                required: "Please select product"
            }
        }
    });

    $('#addOrdersForm').submit(function(e){
        e.preventDefault();
        if($(this).valid()){
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: base_url+'admin/orders/insert',
                data: data,
                dataType: 'json',
                beforeSend: function(){
                    $('#addOrdersBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
                },
                success: function(res){
                    $('#addOrdersBtn').html('<i class="fa fa-save"></i> Save');
                    if(res.error){
                        Swal.fire('Error!', res.message, 'error');
                    } else {
                        Swal.fire('Success!', res.message, 'success');
                        $('#addOrders').modal('hide');
                        $('#addOrdersForm')[0].reset();
                        orderstable.ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#addOrdersBtn').html('<i class="fa fa-save"></i> Save');
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

    $(document).on('click', '.vieworder', function(){
        var orderid = $(this).val();
        $('#orderid').val(orderid);

        $.ajax({
            type: "POST",
            url: base_url+'admin/orders/getProducts',
            data: {orderid: orderid},
            dataType: 'json',
            beforeSend: function(){
            },
            success: function(res){
                if(res.error){
                    Swal.fire('Error!', res.message, 'error');
                } else {
                    var gtotal = 0;
                    var products = res.data;
                    var html = '<table class="table table-bordered table-striped">';
                    html += '<thead>';
                    html += '<th>Product Name</th><th>Price</th><th>Quantity</th><th>Total</th>';
                    html += '</thead>';
                    html += '<tbody>';
                    $.each(products, function(i, product){
                        var total = product.order_price * product.quantity;
                        html += '<tr>';
                        html += '<td>'+product.product_name+'</td>';
                        html += '<td>'+product.order_price+'</td>';
                        html += '<td>'+product.quantity+'</td>';
                        html += '<td>'+total+'</td>';
                        html += '</tr>';
                        gtotal = gtotal + total;
                    });
                    html += '</tbody>';
                    html += '</table>';
                    html += '<div class="order-gtotal">Grand Total: <b>'+gtotal+'</b></div>';
                    $('#products-table').html(html);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire('Error!', 'An error occured while processing', 'error');
            },
        });
    });

});

function formatDate(date) {
    var main_data_array = date.split(' ');

    var date_array = main_data_array[0].split('-');
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    var time_array = main_data_array[1].split(':');
    var meridian = '';
    var hour_time = '';
    var hour = time_array[0];
    var min = time_array[1];

    if (hour < 12) {
        meridian = 'AM';
        hour_time = hour;
    }

    if (hour > 12) {
        meridian = 'PM';
        var new_hour = parseInt(hour)-12;
        if (new_hour < 10) {
            hour_time = '0'+new_hour;
        } else {
            hour_time = new_hour;
        }
    }

    if (hour == 12) {
        if (min == '00') {
            meridian = 'NN';
        } else {
            meridian = 'PM'; 
        }
        hour_time = hour;
    }

    return months[parseInt(date_array[1]) - 1] + ' ' + date_array[2] + ', ' + date_array[0] + ' - ' + hour_time + ':' + min + ' ' + meridian;
}