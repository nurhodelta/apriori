<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="admin-page-title">
            <i class="fa fa-barcode"></i> <span><?= $product->product_name ?></span>
        </h1>
        <!-- <div class="add-btn">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addProducts" id="productBtn"><i class="fa fa-plus-circle"></i> New</button>
        </div> -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form class="form-horizontal">
            <div class="row">
                <div class="col-md-2">
                    <img src="<?= $product->location ? base_url('assets/uploads/products/'.$product->location) : base_url('assets/img/no-product.png') ?>" width="100%">
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="view_product_name" class="col-sm-2 control-label">Product Name </label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?= $product->product_name ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="view_category" class="col-sm-2 control-label">Category</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?= $product->category_name ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="view_price" class="col-sm-2 control-label">Price</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?= $product->price ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="view_description" class="col-sm-2 control-label">Description</label>

                        <div class="col-sm-10">
                            <textarea class="form-control" rows="4" disabled><?= $product->description ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="view_slug" class="col-sm-2 control-label">Slug</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?= $product->slug ?>" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div id="product-associate" style="margin-top:30px">
            <span class="product_id" data-value="<?= $product->product_id; ?>">
            <h3>Frequently Bought Together</h3>
            <div id="apriori">No products to show</div>
        </div>
    </section>
    <!-- /.content -->

</div>