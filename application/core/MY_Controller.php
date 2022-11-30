<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function login($page = '', $data = []) {
        $this->load->view('login/header', $data);
        $this->load->view($page, $data);
        $this->load->view('login/footer');
    }

    public function admin($page = '', $data = []) {
        $this->load->model('admin_model');
        $data['user'] = $this->admin_model->getAdminDetails();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/navbar', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view($page, $data);
        $this->load->view('admin/footer');
    }

    public function generateTokenID($user) {
        $token = md5($user->email)."_".date('Y-m-d h:i:s')."".md5(self::generateRandomString(50));
        return md5($token);
    }

    public function generateSessionID($user) {
        $token = date('Y-m-d h:i:s')."".md5(self::generateRandomString(50))."".md5($user->email)."_"."XYZ123".date('Y-m-d h:i:s');
        return md5($token);
    }

    public function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public function admin_authenticated() {
        if(!$this->isAdminLogin() OR !$this->adminValidateToken()) {
            return FALSE;
        }  
        return TRUE; 
    }

    public function isAdminLogin() {
        return $this->session->userdata('isAdmin') ? TRUE : FALSE;
    }

    public function adminValidateToken() {
        $this->load->model('admin_model');
        return $this->admin_model->adminValidateToken();
    }

}
