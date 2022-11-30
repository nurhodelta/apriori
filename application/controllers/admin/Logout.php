<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $admin_session = array('admin_id', 'isAdmin', 'token_id', 'session_id');
        $this->session->unset_userdata($admin_session);
        redirect(base_url());
    }

}