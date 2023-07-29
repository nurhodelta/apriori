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
	            "targets": [1, 4], 
	            "orderable": false,
	        },
        ],
        "columns": [
            { data: "order_date", 
                render: function (data, type, row) {
                    return  formatDate(data);
                }
            },
            { data: "order_number" },
            { data: "member_id", 
                render: function (data, type, row) {
                    return row.first_name+' '+row.last_name;
                }
            },
            { data: "total" },
            { data: "order_id",
	         	render: function (data, type, row) {
                    // return '<button class="btn btn-info btn-sm btn-flat vieworder" value="'+data+'" data-toggle="modal" data-target="#viewOrder"><i class="fa fa-search"></i> View Products</button>';
                    return '<a href="'+base_url+'admin/order/'+row.order_number+'" target="_blank"><button class="btn btn-info btn-sm btn-flat"><i class="fa fa-search"></i> View Products</button></a>';
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
        $(this).closest('tr').remove();
    });

    $('#order-product-add').click(function(){
        var html = '<tr>';
        html += '<td class="order-product-select"><select class="form-control product-class-select2" id="" name="product_id[]"></td>'; 
        html += '<td class="order-product-quantity"><input type="number" class="form-control" min="1" name="quantity[]" value="1"></td>';       	
        html += '<td><button type="button" class="btn btn-sm btn-danger order-product-minus"><i class="fa fa-minus"></i></button></td>';
        html += '</tr>';         	
        $('#product-table-body').append(html);
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
            // check for duplicate product
            var values = $("select[name='product_id[]']").map(function(){return $(this).val();}).get();
           
            var duplicates = $.grep(values, function(element, index){
                return $.inArray(element, values) !== index;
            });

            if (duplicates.length === 0) {
                var data = $(this).serialize();
                console.log(data);
                $.ajax({
                    type: "POST",
                    url: base_url+'admin/orders/display',
                    data: data,
                    dataType: 'json',
                    beforeSend: function(){
                        $('#addOrdersBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
                    },
                    success: function(res){
                        $('#addOrdersBtn').html('<i class="fa fa-check"></i> Submit');
                        if(res.error){
                            Swal.fire('Error!', res.message, 'error');
                        } else {
                            $('#addOrders').modal('hide');
                            $('#showOrders').modal('show');
                            $('#orderTable').html(res.html);
                            $('#orderTotal').html('<strong>'+res.total+'</strong>');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#addOrdersBtn').html('<i class="fa fa-check"></i> Submit');
                        Swal.fire('Error!', 'An error occurred while processing', 'error');
                    },
                });
            } else {
                Swal.fire('Error!', 'Duplicate product(s) selected', 'error');
            }
        }
    });

    $(document).on('click', '#returnOrderBtn', function(){
        $('#showOrders').modal('hide');
        $('#addOrders').modal('show');
    });

    $(document).on('click', '#saveOrderBtn', function(){
        $.ajax({
            type: "GET",
            url: base_url+'admin/orders/insert',
            dataType: 'json',
            beforeSend: function(){
                $('#saveOrderBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing');
            },
            success: function(res){
                $('#saveOrderBtn').html('<i class="fa fa-save"></i> Save');
                if(res.error){
                    Swal.fire('Error!', res.message, 'error');
                } else {
                    Swal.fire('Success!', res.message, 'success');
                    $('#showOrders').modal('hide');
                    $('#addOrdersForm')[0].reset();
                    orderstable.ajax.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#saveOrderBtn').html('<i class="fa fa-save"></i> Save');
                Swal.fire('Error!', 'An error occurred while processing', 'error');
            },
        });
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