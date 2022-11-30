<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
    public function __construct() {
        parent::__construct();

        // validate admin session redirect to login if not
		if( $this->admin_authenticated() ) {
            redirect(base_url('admin/dashboard'));
        }
    }

	public function index(){
        $data['title'] = 'Personal Collections | Login';
        $data['scripts'] = [base_url('assets/js/login.js')];
		$this->login('login/login', $data);
	}

    public function submit() {
        $output = ['error'=>false];
 
        $password = $this->input->post('password');

        $this->load->model('auth_model');

        $admin = $this->auth_model->validate_admin();

        if($admin){
            // check password
            if(password_verify($password, $admin->password)){
                $tokenID = $this->generateTokenID($admin);
                $sessionID = $this->generateSessionID($admin);

                // set the user as login session
				$this->session->set_userdata('admin_id', $admin->id);
				$this->session->set_userdata('isAdmin', TRUE);
				$this->session->set_userdata('token_id', $tokenID);
				$this->session->set_userdata('session_id', $sessionID);

                // Update sessionID and tokenID
				$this->auth_model->updateAdminToken($tokenID, $sessionID);

                $output['message'] = 'Login successful';
            } else {
                $output['error'] = true;
                $output['message'] = 'Incorrect Password';  
            }
        } else{
            $output['error'] = true;
            $output['message'] = 'Email not found';
        }
        echo json_encode($output);
    }
}
