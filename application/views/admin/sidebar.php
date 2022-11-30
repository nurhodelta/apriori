<aside class="main-sidebar">
    
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $user->location ? base_url('assets/uploads/admins/'.$user->location) : base_url('assets/img/avatar.png'); ?>" class="img-circle" alt="User Image">
                <!-- <img src="<?= base_url('assets/img/avatar.png'); ?>" class="img-circle" alt="User Image"> -->
            </div>
            <div class="pull-left info">
                <p><?= $user->first_name.' '.$user->last_name; ?></p>
                <a><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?= $active == 'dashboard' ? 'active' : ''; ?>">
                <a href="<?= base_url('admin/dashboard'); ?>"><i class="fa fa-tachometer-alt"></i> <span>Dashboard</span></a>
            </li>
            <li class="<?= $active == 'admins' ? 'active' : ''; ?>">
                <a href="<?= base_url('admin/admins'); ?>"><i class="fa fa-lock"></i> <span>Admins</span></a>
            </li>
            <li class="<?= $active == 'members' ? 'active' : ''; ?>">
                <a href="<?= base_url('admin/members'); ?>"><i class="fa fa-users"></i> <span>Members</span></a>
            </li>
            <li class="<?= $active == 'products' ? 'active' : ''; ?>">
                <a href="<?= base_url('admin/products'); ?>"><i class="fa fa-barcode"></i> <span>Products</span></a>
            </li>
            <li class="<?= $active == 'category' ? 'active' : ''; ?>">
                <a href="<?= base_url('admin/categories'); ?>"><i class="fa fa-bars"></i> <span>Categories</span></a>
            </li>
            <li class="<?= $active == 'orders' ? 'active' : ''; ?>">
                <a href="<?= base_url('admin/orders'); ?>"><i class="fa fa-shopping-basket"></i> <span>Orders</span></a>
            </li>
            <li class="<?= $active == 'history' ? 'active' : ''; ?>">
                <a href="<?= base_url('admin/history'); ?>"><i class="fa fa-clipboard-list"></i> <span>View History</span></a>
            </li>
        </ul>
    </section>
    
  </aside>