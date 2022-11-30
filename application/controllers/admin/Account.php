<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MY_Controller {
    public function __construct() {
        parent::__construct();

        // validate admin session redirect to login if not
		if( !$this->admin_authenticated() ) {
            redirect(base_url());
        }
        
    }

	public function index() {
        $data['title'] = 'Personal Collections | Account';
        $data['active'] = 'account';
        $data['scripts'] = [
            base_url('assets/js/admin/account.js'),
        ];
		$this->admin('admin/account', $data);
	}

    public function profile() {
        $output = ['error'=>false];

        $this->load->model('admin_model');

        try {

            if (!empty($_FILES['photo']['name'])) {	

                $admin_photo = 'admin-photo-'.rand(0,99999).'-'.strtotime(date("His"));

                $admin_photo_config = [
                    'allowed_types'		=>		'jpg|jpeg|png',
                    'upload_path'		=>		realpath('assets/uploads/admins'),
                    'max_size'			=>		2000,
                    'file_name'			=>		$admin_photo,
                    'overwrite'			=>		TRUE
                ];

                $this->load->library('upload');

                $this->upload->initialize($admin_photo_config);

                if ($this->upload->do_upload('photo')) {
                    $admin_photo_data = $this->upload->data();
                } else {
                    $output['error'] = true;
                    $output['message'] = $this->upload->display_errors();
                    echo json_encode($output);
                    exit();
                }

            }

            $id = $this->session->userdata('admin_id');

            $data = [
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name')
            ];

            if (isset($admin_photo_data)) {
                $data['location'] = $admin_photo_data['file_name'];
            }

            $this->admin_model->updateAdmin($data, $id);

            $output['message'] = 'Profile updated successfully';

        } catch (Throwable $t) {
            // Executed only in PHP 7, will not match in PHP 5

            $output['error'] = TRUE;
            $output['message'] = 'An error occured';

        } catch (Exception $e) {
            // Executed only in PHP 5, will not be reached in PHP 7

            $output['error'] = TRUE;
            $output['message'] = 'An error occured';
        }

        echo json_encode($output);
    }

    public function password() {
        $output = ['error'=>false];

        $this->load->model('admin_model');

        try {

            $id = $this->session->userdata('admin_id');

            // check if old password match
            $user = $this->admin_model->getAdmin($id);

            if (!password_verify($this->input->post('old_password'), $user->password)) {
                $output['error'] = TRUE;
                $output['message'] = 'Current password did not match';
                echo json_encode($output);
                exit();
            }

            $data = [
                'password' => password_hash($this->input->post('new_password'), PASSWORD_DEFAULT)
            ];

            $this->admin_model->updateAdmin($data, $id);

            $output['message'] = 'Password updated successfully';

        } catch (Throwable $t) {
            // Executed only in PHP 7, will not match in PHP 5

            $output['error'] = TRUE;
            $output['message'] = 'An error occured';

        } catch (Exception $e) {
            // Executed only in PHP 5, will not be reached in PHP 7

            $output['error'] = TRUE;
            $output['message'] = 'An error occured';
        }

        echo json_encode($output);
    }

}