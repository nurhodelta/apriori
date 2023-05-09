<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="admin-page-title">
            <i class="fa fa-angle-double-down"></i> <span>Incoming Stocks</span>
        </h1>
        <div class="add-btn">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addIncoming"><i class="fa fa-plus-circle"></i> New</button>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="incomingTable" class="table table-bordered table-striped">
                            <thead>
                                <th>Date Added</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
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
<div class="modal fade" id="addIncoming">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Incoming Stock</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" id="addIncomingForm">
                <div class="form-group">
                  	<label for="product_id" class="col-sm-3 control-label">Product </label>

                  	<div class="col-sm-9">
                        <select class="form-control" id="product_id" name="product_id"></select>
						<label id="product_id-error" class="error" for="product_id" style="display: none;"></label>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="quantity" class="col-sm-3 control-label">Quantity </label>

                  	<div class="col-sm-9">
                    	<input type="number" min="1" class="form-control" id="quantity" name="quantity">
                  	</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" id="addIncomingBtn"><i class="fa fa-save"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>