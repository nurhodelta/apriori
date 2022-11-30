<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="admin-page-title">
            <i class="fa fa-bars"></i> <span>Categories</span>
        </h1>
        <div class="add-btn">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addCategory"><i class="fa fa-plus-circle"></i> New</button>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="categoryTable" class="table table-bordered table-striped">
                            <thead>
                                <th>Category Name</th>
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
<div class="modal fade" id="addCategory">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Category</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" id="addCategoryForm">
                <div class="form-group">
                  	<label for="category_name" class="col-sm-3 control-label">Category Name </label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="category_name" name="category_name">
                  	</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" id="addCategoryBtn"><i class="fa fa-save"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="editCategory">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Edit Category</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" id="editCategoryForm">
            	<input type="hidden" id="categoryid" name="categoryid">
				<div class="form-group">
                  	<label for="edit_category_name" class="col-sm-3 control-label">Category Name</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="edit_category_name" name="edit_category_name">
                  	</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="submit" class="btn btn-success btn-flat" id="editCategoryBtn"><i class="fa fa-check"></i> Update</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="deleteCategory">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Delete Category</b></h4>
          	</div>
          	<div class="modal-body">
                <div class="text-center">
                    <h4>Are you sure you want to delete category?</h4>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="button" class="btn btn-danger btn-flat" id="deleteCategoryBtn"><i class="fa fa-trash"></i> Delete</button>
          	</div>
        </div>
    </div>
</div>