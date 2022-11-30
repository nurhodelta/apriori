<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="admin-page-title">
            <i class="fa fa-tachometer-alt"></i> <span>Dashboard</span>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= $orders ?></h3>

                        <p>No. of Orders</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-basket"></i>
                    </div>
                    <a href="<?= base_url('admin/orders'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $products ?></h3>

                        <p>No. of Products</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-barcode"></i>
                    </div>
                    <a href="<?= base_url('admin/products'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= $members ?></h3>

                        <p>No. of Members</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="<?= base_url('admin/members'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?= $admins ?></h3>

                        <p>No. of Admins</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-lock"></i>
                    </div>
                    <a href="<?= base_url('admin/admins'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Monthly Sales</h3>
                        <div class="box-tools pull-right">
                            <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                            <select id="selectYear" class="form-control">
                                <?php
                                    $tz = 'Asia/Manila';
                                    $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
                                    $toyear = $dt->format('Y');
                                    $ymten = $toyear-10;
                                    $ypten = $toyear+10;
                                    for ($i=$ymten; $i<=$ypten; $i++) {
                                        ?>
                                        <option <?= $i==$toyear ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="barChart" style="height:550px"></canvas>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </section>
    <!-- /.content -->

</div>

<!-- Edit -->
<div class="modal fade" id="edit">
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
                  	<label for="edit_fullname" class="col-sm-3 control-label">Fullname </label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="edit_fullname" name="edit_fullname" required>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="edit_address" class="col-sm-3 control-label">Address</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="edit_address" name="edit_address" required>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="edit_birthdate" class="col-sm-3 control-label">Birthday</label>

                  	<div class="col-sm-9">
                    	<input type="date" class="form-control" id="edit_birthdate" name="edit_birthdate" required>
                  	</div>
                </div>
				<div class="form-group">
                  	<label for="edit_card_number" class="col-sm-3 control-label">Card</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="edit_card_number" name="edit_card_number" required>
                  	</div>
                </div>
                <div class="form-group row">
	                <label for="edit_photo" class="col-sm-3 control-label">Photo</label>

	                <div class="col-sm-9">
	                    <input type="file" class="form-control" id="edit_photo" name="edit_photo">
	                </div>
	            </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            	<button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check-double"></i> Update</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
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
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="button" class="btn btn-danger btn-flat" id="deleteMember"><i class="fa fa-trash"></i> Delete</button>
          	</div>
        </div>
    </div>
</div>