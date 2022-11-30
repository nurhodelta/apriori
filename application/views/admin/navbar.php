<header class="main-header">
    <a href="<?= base_url('admin/dashboard'); ?>" class="logo">
        <span class="logo-mini"><b>PC</b></span>
        <span class="logo-lg"><b>PC Collections</b></span>
    </a>
   
    <nav class="navbar navbar-static-top">
        
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span> <i class="fa fa-bars"></i>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                <a href="<?= base_url('admin/account'); ?>">
                    <img src="<?= $user->location ? base_url('assets/uploads/admins/'.$user->location) : base_url('assets/img/avatar.png'); ?>" class="user-image" alt="User Image">
                    <span class="hidden-xs"><?= $user->first_name.' '.$user->last_name; ?></span>
                </a>
                </li>
                <li><a href="<?= base_url('admin/logout'); ?>"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </nav>
</header>