$(function(){

    var base_url = $('.base_url').data('value');
    var product_id = $('.product_id').data('value');
    
    $.ajax({
        type: "POST",
        url: base_url+'admin/products/apriori',
        data: {product_id: product_id},
        dataType: 'json',
        beforeSend: function(){},
        success: function(res){
            if(!res.error){
                var products = res.data;
                var html = '<div class="row">';
                $.each(products, function(index, product){
                    var imgsrc = base_url + 'assets/img/no-product.png';
                    if (product.location !== '') {
                        imgsrc = base_url + 'assets/uploads/products/' + product.location;
                    }
                    html += '<div class="col-md-3 apriori-div">';
                    html += '<div class="apriori-photo"><img src="'+imgsrc+'"></div>';
                    html += '<div class="apriori-name"><a href="'+base_url + 'admin/products/view/' + product.slug+'">'+product.product_name+'</a></div>';
                    html += '<div class="apriori-price">Price: '+product.price+'</div></div>';
                });
                html += '</div>';
                $('#apriori').html(html);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire('Error!', 'An error occurred while processing', 'error');
        },
    });

});