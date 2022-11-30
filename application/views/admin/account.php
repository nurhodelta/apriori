<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="admin-page-title">
            <i class="fa fa-key"></i> <span>Account</span>
        </h1>
        <!-- <div class="add-btn">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addAdmins"><i class="fa fa-plus-circle"></i> New</button>
        </div> -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Profile</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" id="profileForm">
                            <div class="form-group">
                                <label for="first_name" class="col-sm-3 control-label">First Name </label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?= $user->first_name ?>" id="first_name" name="first_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="col-sm-3 control-label">Last Name</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?= $user->last_name ?>" id="last_name" name="last_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="photo" class="col-sm-3 control-label">Photo</label>

                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="photo" name="photo">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success" style="float: right" id="profileBtn"><i class="fa fa-check"></i> Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Change Password</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" id="passwordForm">
                            <div class="form-group">
                                <label for="old_password" class="col-sm-3 control-label">Current Password </label>

                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="old_password" name="old_password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="col-sm-3 control-label">New Password</label>

                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="new_password" name="new_password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="retype_password" class="col-sm-3 control-label">Re-type Password</label>

                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="retype_password" name="retype_password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success" style="float: right" id="passwordBtn"><i class="fa fa-check"></i> Submit</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

</div>