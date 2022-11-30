<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="admin-page-title">
            <i class="fa fa-barcode"></i> <span>Products</span>
        </h1>
        <div class="add-btn">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addProducts" id="productBtn"><i class="fa fa-plus-circle"></i> New</button>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="productsTable" class="table table-bordered table-striped">
                            <thead>
                                <th>Product Name</th>
                                <th>Photo</th>
                                <th>Category</th>
								<th>Price</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>  
        </div>
    </section>
    <!-- /.content -->

</div>

<!-- Add -->
<div class="modal fade" id="addProducts">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Product</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" id="addProductForm">
                <div class="form-group">
                  	<label for="product_name" class="col-sm-3 control-label">Product Name </label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="product_name" name="product_name">
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="category_id" class="col-sm-3 control-label">Category</label>

                  	<div class="col-sm-9">
                    	<select class="form-control" id="category_id" name="category_id">
                            <option value="">Select</option>
                        </select>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="price" class="col-sm-3 control-label">Price</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="price" name="price">
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="description" class="col-sm-3 control-label">Description</label>

                  	<div class="col-sm-9">
                    	<textarea class="form-control" id="description" name="description" rows="4"></textarea>
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="photo" class="col-sm-3 control-label">Photo</label>

                  	<div class="col-sm-9">
                    	<input type="file" class="form-control" id="photo" name="photo">
                  	</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" id="addProductBtn"><i class="fa fa-save"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="editProduct">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Edit Product</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" id="editProductForm">
            	<input type="hidden" id="productid" name="productid">
				<div class="form-group">
                  	<label for="edit_product_name" class="col-sm-3 control-label">Product Name </label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="edit_product_name" name="edit_product_name">
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="edit_category_id" class="col-sm-3 control-label">Category</label>

                  	<div class="col-sm-9">
                    	<select class="form-control" id="edit_category_id" name="edit_category_id">
                            <option value="">Select</option>
                        </select>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="edit_price" class="col-sm-3 control-label">Price</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="edit_price" name="edit_price">
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="edit_description" class="col-sm-3 control-label">Description</label>

                  	<div class="col-sm-9">
                    	<textarea class="form-control" id="edit_description" name="edit_description" rows="4"></textarea>
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="edit_photo" class="col-sm-3 control-label">Photo</label>

                  	<div class="col-sm-9">
                    	<input type="file" class="form-control" id="edit_photo" name="edit_photo">
                  	</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="submit" class="btn btn-success btn-flat" id="editProductBtn"><i class="fa fa-check"></i> Update</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- View -->
<div class="modal fade" id="viewProduct">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>View Product</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal">
                <div class="row">
                    <div class="col-md-3">
                        <img src="<?= base_url('assets/img/no-product.png') ?>" id="view_photo" width="100%">
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="view_product_name" class="col-sm-3 control-label">Product Name </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="view_product_name" name="view_product_name" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="view_category" class="col-sm-3 control-label">Category</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="view_category" name="view_category" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="view_price" class="col-sm-3 control-label">Price</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="view_price" name="view_price" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="view_description" class="col-sm-3 control-label">Description</label>

                            <div class="col-sm-9">
                                <textarea class="form-control" id="view_description" name="view_description" rows="4" disabled></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="view_slug" class="col-sm-3 control-label">Slug</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="view_slug" name="view_slug" disabled>
                            </div>
                        </div>
                    </div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="deleteProduct">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Delete Product</b></h4>
          	</div>
          	<div class="modal-body">
                <div class="text-center">
                    <h4>Are you sure you want to delete product?</h4>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="button" class="btn btn-danger btn-flat" id="deleteProductBtn"><i class="fa fa-trash"></i> Delete</button>
          	</div>
        </div>
    </div>
</div>