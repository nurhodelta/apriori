<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="admin-page-title">
            <i class="fa fa-shopping-basket"></i> <span>Orders</span>
        </h1>
        <div class="add-btn">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addOrders"><i class="fa fa-plus-circle"></i> New</button>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="ordersTable" class="table table-bordered table-striped">
                            <thead>
                                <th>Date</th>
								<th>Number</th>
                                <th>Member</th>
                                <th>Total</th>
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
<div class="modal fade" id="addOrders">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Order</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" id="addOrdersForm">
                <div class="form-group">
                  	<label for="member_id" class="col-sm-3 control-label">Member </label>

                  	<div class="col-sm-9">
                    	<select class="form-control" id="member_id" name="member_id"></select>
						<label id="member_id-error" class="error" for="member_id" style="display: none;"></label>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="" class="col-sm-3 control-label">Products</label>

                  	<div class="col-sm-9 order-product-div">
						<table class="table table-bordered">
							<tbody id="product-table-body">
								<tr>
									<td class="order-product-select">
										<select class="form-control product-class-select2" name="product_id[]"></select>
										<label id="product_id[]-error" class="error" for="product_id[]" style="display: none;">Please select product</label>
									</td>
									<td class="order-product-quantity"><input type="number" class="form-control" min="1" name="quantity[]" value="1"></td>
									<td><button type="button" class="btn btn-sm btn-primary" id="order-product-add"><i class="fa fa-plus"></i></button></td>
								</tr>
							</tbody>
						</table>
						
                  	</div>
                </div>
				<div id="order-product-new-div"></div>
                
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="submit" class="btn btn-success btn-flat" id="addOrdersBtn"><i class="fa fa-check"></i> Submit</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="editMembers">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Edit Member</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" id="editMemberForm">
            	<input type="hidden" id="memberid" name="memberid">
				<div class="form-group">
                  	<label for="edit_email" class="col-sm-3 control-label">Email</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="edit_email" name="edit_email" disabled>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="edit_firstname" class="col-sm-3 control-label">First Name </label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="edit_firstname" name="edit_firstname">
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="edit_lastname" class="col-sm-3 control-label">Last Name</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="edit_lastname" name="edit_lastname">
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="edit_birthdate" class="col-sm-3 control-label">Birthdate</label>

                  	<div class="col-sm-9">
                    	<input type="date" class="form-control" id="edit_birthdate" name="edit_birthdate">
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="edit_contact_info" class="col-sm-3 control-label">Contact Info</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="edit_contact_info" name="edit_contact_info">
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="edit_address" class="col-sm-3 control-label">Address</label>

                  	<div class="col-sm-9">
                    	<textarea class="form-control" id="edit_address" name="edit_address" rows="4"></textarea>
                  	</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="submit" class="btn btn-success btn-flat" id="editMemberBtn"><i class="fa fa-check"></i> Update</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Display Order -->
<div class="modal fade" id="showOrders">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Order Details</b></h4>
          	</div>
          	<div class="modal-body">
            	<div id="orderTable"></div>
				<div>Total: <span id="orderTotal"></span></div>
          	</div>
          	<div class="modal-footer">
			  	<button type="button" class="btn btn-default btn-flat pull-left" id="returnOrderBtn"><i class="fa fa-undo"></i> Return</button>
            	<button type="button" class="btn btn-primary btn-flat" id="saveOrderBtn"><i class="fa fa-save"></i> Save</button>
          	</div>
        </div>
    </div>
</div>

<!-- View -->
<div class="modal fade" id="viewOrder">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>View Products</b></h4>
          	</div>
          	<div class="modal-body">
            	<div id="products-table"></div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="deleteMembers">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Delete Member</b></h4>
          	</div>
          	<div class="modal-body">
                <div class="text-center">
                    <h4>Are you sure you want to delete member?</h4>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="button" class="btn btn-danger btn-flat" id="deleteMemberBtn"><i class="fa fa-trash"></i> Delete</button>
          	</div>
        </div>
    </div>
</div>