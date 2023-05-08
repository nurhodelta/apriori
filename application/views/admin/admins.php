<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="admin-page-title">
            <i class="fa fa-lock"></i> <span>Users</span>
        </h1>
        <div class="add-btn">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addAdmins"><i class="fa fa-plus-circle"></i> New</button>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="adminsTable" class="table table-bordered table-striped">
                            <thead>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
								<th>User Type</th>
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
<div class="modal fade" id="addAdmins">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Admin</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" id="addAdminForm">
                <div class="form-group">
                  	<label for="first_name" class="col-sm-3 control-label">First Name </label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="first_name" name="first_name">
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="last_name" class="col-sm-3 control-label">Last Name</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="last_name" name="last_name">
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="email" class="col-sm-3 control-label">Email</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="email" name="email">
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="user_type" class="col-sm-3 control-label">User Type</label>

                  	<div class="col-sm-9">
                    	<select class="form-control" id="user_type" name="user_type">
							<option value="0">Staff</option>
							<option value="1">Admin</option>
						</select>
                  	</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" id="addAdminBtn"><i class="fa fa-save"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="editAdmins">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Edit User</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" id="editAdminForm">
            	<input type="hidden" id="adminid" name="adminid">
				<div class="form-group">
                  	<label for="edit_email" class="col-sm-3 control-label">Email</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="edit_email" name="edit_email" disabled>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="edit_firstname" class="col-sm-3 control-label">FirstName </label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="edit_firstname" name="edit_firstname">
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="edit_lastname" class="col-sm-3 control-label">LastName</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="edit_lastname" name="edit_lastname">
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="edit_user_type" class="col-sm-3 control-label">User Type</label>

                  	<div class="col-sm-9">
                    	<select class="form-control" id="edit_user_type" name="edit_user_type">
						</select>
                  	</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="submit" class="btn btn-success btn-flat" id="editAdminBtn"><i class="fa fa-check"></i> Update</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="deleteAdmins">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Delete User</b></h4>
          	</div>
          	<div class="modal-body">
                <div class="text-center">
                    <h4>Are you sure you want to delete user?</h4>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="button" class="btn btn-danger btn-flat" id="deleteAdminBtn"><i class="fa fa-trash"></i> Delete</button>
          	</div>
        </div>
    </div>
</div>