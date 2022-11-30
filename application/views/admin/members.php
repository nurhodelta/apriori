<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="admin-page-title">
            <i class="fa fa-users"></i> <span>Members</span>
        </h1>
        <div class="add-btn">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addMembers"><i class="fa fa-plus-circle"></i> New</button>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="membersTable" class="table table-bordered table-striped">
                            <thead>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
								<th>Contact</th>
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
<div class="modal fade" id="addMembers">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Member</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" id="addMemberForm">
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
                  	<label for="birthdate" class="col-sm-3 control-label">Birthdate</label>

                  	<div class="col-sm-9">
                    	<input type="date" class="form-control" id="birthdate" name="birthdate">
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="contact_info" class="col-sm-3 control-label">Contact Info</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="contact_info" name="contact_info">
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="address" class="col-sm-3 control-label">Address</label>

                  	<div class="col-sm-9">
                    	<textarea class="form-control" id="address" name="address" rows="4"></textarea>
                  	</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" id="addMemberBtn"><i class="fa fa-save"></i> Save</button>
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

<!-- View -->
<div class="modal fade" id="viewMembers">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>View Member</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal">
				<div class="form-group">
                  	<label for="view_email" class="col-sm-3 control-label">Email</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="view_email" disabled>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="view_firstname" class="col-sm-3 control-label">First Name </label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="view_firstname" disabled>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="view_lastname" class="col-sm-3 control-label">Last Name</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="view_lastname" disabled>
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="view_birthdate" class="col-sm-3 control-label">Birthdate</label>

                  	<div class="col-sm-9">
                    	<input type="date" class="form-control" id="view_birthdate" disabled>
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="view_contact_info" class="col-sm-3 control-label">Contact Info</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="view_contact_info" disabled>
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="view_address" class="col-sm-3 control-label">Address</label>

                  	<div class="col-sm-9">
                    	<textarea class="form-control" rows="4" id="view_address" disabled></textarea>
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